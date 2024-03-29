<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileHandling extends Component
{
    use WithFileUploads, WithPagination;

    public $documents = [];
    public $search = '';
    public $folder_name = '';
    public $dir = '';
    public $directories = '';
    public $all_files = '';

    public function updatedDocuments()
    {
        $this->validate([
//            'documents.*' => 'required|max:512000|mimes:jpg,jpeg,JPG,svg,JPEG,png,PNG,xlsx,doc,docx,zip,pdf,csv,mp4,MP4,mp3,mkv,avi,gif,tar,3gp'
            'documents.*' => 'required|max:512000|mimetypes:video/avi,video/mpeg,video/mp4,video/avi,video/mkv,audio/mpeg,image/png,image/jpeg,image/jpg,application/pdf,application/zip,application/vnd.openofficeorg.extension,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/x-sql,text/plain'
        ], [
            'documents.*.mimetypes' => 'The :attribute have no valid type please upload valid file type.',
            'documents.*.max' => 'The :attribute max size is out of range please make sure file size is below 500 MB'
        ], [
            'documents.*' => 'Uploaded File'
        ]);
    }

    public function updated($property)
    {
        $this->validateOnly($property, [
            'folder_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/'
        ], [
            'folder_name.required' => 'Please enter :attribute',
            'folder_name.regex' => 'Please enter valid :attribute'
        ], [
            'folder_name' => 'Folder Name'
        ]);
    }

    public function uploadDocument()
    {
        $this->validate([
//            'documents.*' => 'required|max:512000|mimes:jpg,jpeg,JPG,svg,JPEG,png,PNG,xlsx,doc,docx,zip,pdf,csv,mp4,MP4,mp3,mkv,avi,gif,tar,3gp'
            'documents.*' => 'required|max:512000|mimetypes:video/avi,video/mpeg,video/mp4,video/avi,video/mkv,audio/mpeg,image/png,image/jpeg,image/jpg,application/pdf,application/zip,application/vnd.openofficeorg.extension,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/x-sql,text/plain'
        ], [
            'documents.*.mimetypes' => 'The :attribute have no valid type please upload valid file type.',
            'documents.*.max' => 'The :attribute max size is out of range please make sure file size is below 500 MB'
        ], [
            'documents.*' => 'Uploaded File'
        ]);
        foreach ($this->documents as $document):
            $file_name = time() . mt_rand(10000, 99999);
            $file_name .= $document->getClientOriginalName();
//            $db_save_path = 'user_documents/user_' . auth()->user()->id . "/" . $file_name;
            $db_save_path = $this->dir . $file_name;
            $save_path = 'public/user_documents/user_' . auth()->user()->id . "/";
            // Storage::disk('public')->putFileAs($document,$path,$file_name);
            // $document->move($path,$file_name);
            // Storage::move($document,$path);
//            $document->storeAs($save_path, $file_name);
            /*if(!file_exists($this->dir)){
                mkdir($this->dir,0777,true);
            }*/
            $uploaded_file_size = $document->getSize() / 1024 / 1024;
            $storage_limit = auth()->user()->storage_limit * 1024;
            $used_space = File::where('user_id', auth()->user()->id)->get()->sum('file_size');
            $uploaded_file_size += $used_space;


            if ($uploaded_file_size > $storage_limit) {
                session()->flash('info', 'Sorry Your Storage Limit is going to out of range.');
                return redirect()->back();
            }
            $document->storeAs($this->dir, $file_name);
            File::create([
                'file_name' => $document->getClientOriginalName(),
                'file_url' => $db_save_path,
                'file_size' => $document->getSize() / 1024 / 1024,
                'user_id' => auth()->user()->id
            ]);
        endforeach;
        $this->documents = [];
        $this->dispatchBrowserEvent('reset-form');
        $this->directories = Storage::directories($this->dir);
        $this->all_files = Storage::files($this->dir);
        session()->flash('info', 'Your files are uploaded successfully.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createFolder()
    {
        Storage::makeDirectory($this->dir . '/' . $this->folder_name);
        $this->folder_name = '';
        $this->directories = Storage::directories($this->dir);
        $this->all_files = Storage::files($this->dir);
        session()->flash('info', 'Folder Created Successfully.');
    }

    public function downloadFile($filename = NULL)
    {
        return Storage::download(decrypt($filename));
    }

    public function deleteFile($id = NULL)
    {
        if ($id != NULL) {
            $id = decrypt($id);
            $file = File::find($id);
//            $path = storage_path("app/{$file->file_url}");
//            $check = unlink($path);
            $check = Storage::delete($file->file_url);
            if ($check) {
                $file->delete();
                $this->directories = Storage::directories($this->dir);
                $this->all_files = Storage::files($this->dir);
                session()->flash('info', 'File Successfully deleted.');
            } else {
                session()->flash('info', 'Something went wront please try again.');
            }
        }
    }

    public function deleteDirectory($dir = NULL)
    {
        if ($dir != NULL) {
            $dir = decrypt($dir);
            $is_dir_empty = Storage::allFiles($dir);
            if($is_dir_empty == NUll || $is_dir_empty == []){
                $check = Storage::deleteDirectory($dir);
                if ($check) {
                    $this->directories = Storage::directories($this->dir);
                    $this->all_files = Storage::files($this->dir);
                    session()->flash('info', 'Directory Successfully deleted.');
                }
            }else{
                session()->flash("info", "Sorry Directory is not deleted because it's contains some files. first delete all of them and try again Successfully deleted.");
            }
        }
    }

    public function changeDir($dir = NULL)
    {
        if ($dir != NULL) {
            $this->dir = decrypt($dir) . '/';
            $this->directories = Storage::directories($this->dir);
            $this->all_files = Storage::files($this->dir);
        }
    }

    public function rewind()
    {
        $dir_array = explode('/', trim($this->dir, '/'));
        array_pop($dir_array);
        $this->dir = implode('/', $dir_array) . '/';
        $this->directories = Storage::directories($this->dir);
        $this->all_files = Storage::files($this->dir);
    }

    public function mount()
    {
        $this->dir = 'public/user_documents/user_' . auth()->user()->id . '/';
        $this->directories = Storage::directories($this->dir);
        $this->all_files = Storage::files($this->dir);
    }

    public function render()
    {
        $files = File::where('user_id', auth()->user()->id)->where('file_name', 'like', '%' . $this->search . '%')->latest()->paginate(8);
        $used_space = File::where('user_id', auth()->user()->id)->get()->sum('file_size');
        return view('livewire.file-handling', compact('files', 'used_space'));
    }
}
