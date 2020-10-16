<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileHandling extends Component
{
	use WithFileUploads;

	public $documents = [];

	public function updatedDocuments(){
		$this->validate([
			'documents.*' => ['required','max:512000','mimes:sql,SQL,jpg,jpeg,JPG,JPEG,png,PNG,xlsx,doc,docx,zip,pdf,csv,mp4,mp3,mkv,avi,gif,exe,deb,tar,3gp']
		],[
			'documents.*.mimes' => 'The :attribute have no valid type please upload valid file type.',
			'documents.*.max' => 'The :attirbute max size is out of range please make sure file size is below 12 MB'
		],[
			'documents.*' => 'Uploaded File'
		]);
	}

	protected $rules = [
		'documents.*' => ['required','max:512000','mimes:sql,SQL,jpg,jpeg,JPG,JPEG,png,PNG,xlsx,doc,docx,zip,pdf,csv,mp4,mp3,mkv,avi,gif,exe,deb,tar,3gp']
	];

	protected $messages = [
		'documents.*.mimes' => 'The :attribute have no valid type please upload valid file type.',
		'documents.*.max' => 'The :attirbute max size is out of range please make sure file size is below 12 MB'
	];

	public function uploadDocument(){
		$this->validate();
		
		foreach($this->documents as $document):
			$file_name = time().mt_rand(10000,99999);
			$file_name .= $document->getClientOriginalName();
			$db_save_path = 'user_documents/user_'.auth()->user()->id."/".$file_name;
			$save_path = 'public/user_documents/user_'.auth()->user()->id."/";
			// Storage::disk('public')->putFileAs($document,$path,$file_name);
			// $document->move($path,$file_name);
			// Storage::move($document,$path);
			$document->storeAs($save_path,$file_name);
			// $file_size = ceil((filesize(storage_path('app/public'.$db_save_path))/1024/1024));
			File::create([
				'file_name' => $document->getClientOriginalName(),
				'file_url' => $db_save_path,
				'file_size' => ceil($document->getSize()/1024/1024),
				'user_id' => auth()->user()->id
			]);

		endforeach;
		session()->flash('info','Your files are uploaded successfully.');
	}

	public function render()
	{
		return view('livewire.file-handling')->layout('layouts.app');
	}
}
