<x-slot name="header">File Handling Section</x-slot>
<div class="bg-blue-100 m-2 p-2 rounded">
    @if ($errors->any())
        <div class="bg-red-200 p-3 rounded my-2 text-center" id="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(!empty(session('info')))
        <div class="p-4 m-3 shadow-sm rounded bg-teal-400 text-center text-white text-lg">
            {{ session('info') }}
        </div>
    @endif
    <div class="text-center grid grid-cols-2">
        <form enctype="multipart/form-data" id="user_file_form" wire:submit.prevent="uploadDocument">
            <input type="file" style="display: none;" id="file_input" wire:model.defer="documents" multiple>
            <button
                class="bg-blue-700 rounded p-2 text-lg text-white hover:text-gray-700 hover:bg-white hover:shadow-md focus:outline-none transition duration-300 ease-in-out"
                type="button" onclick="document.getElementById('file_input').click();">Upload File
            </button>
            <button type="submit"
                    class="p-2 mr-1 text-lg bg-green-700 text-white hover:bg-white hover:text-black rounded hover:shadow-md focus:outline-none transition duration-300 ease-in-out">
                Submit
            </button>
        </form>
        <form wire:submit.prevent="createFolder">
            <label for="folder_name" class="text-lg">Create Folder </label>
            <input type="text" name="folder_name" id="folder_name" wire:model.debounce.500ms="folder_name"
                   class="focus:outline-none focus:shadow-outline-green p-2 rounded bg-green-300 text-black focus:bg-white w-64 placeholder-green-700"
                   placeholder="Enter Folder Name">
            <button type="submit"
                    class="p-2 mr-1 text-lg bg-green-700 text-white hover:bg-white hover:text-black rounded hover:shadow-md focus:outline-none transition duration-300 ease-in-out">
                Create
            </button>
        </form>
    </div>
    <div
        class="text-center rounded-full w-68 p-4 m-2 bg-white shadow text-lg text-teal-700">
        <div>
            {{ $used_space }} MB used out of {{ auth()->user()->storage_limit }} GB
        </div>
    </div>
    @php
        $chars = strlen('public/user_documents/user_'.auth()->user()->id);
    @endphp
    <div class="p-2 my-2 bg-white shadow-md text-lg grid grid-cols-2">
        <div>
            {{ substr($dir,$chars) }}
        </div>
        @if(!empty(trim(substr($dir,$chars,),'/')))
            <div class="w-10 h-10 bg-green-500 rounded-full shadow hover:shadow-md hover:bg-green-400"
                 wire:click="rewind">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M8.445 14.832A1 1 0 0010 14v-2.798l5.445 3.63A1 1 0 0017 14V6a1 1 0 00-1.555-.832L10 8.798V6a1 1 0 00-1.555-.832l-6 4a1 1 0 000 1.664l6 4z"/>
                </svg>
            </div>
        @endif
    </div>
    <div class="p-4 bg-green-100 mb-2 shadow grid grid-cols-8">
        @foreach($directories as $dir)
            <div class="w-28 h-38 rounded hover:bg-white p-2 m-2 hover:shadow-md shadow">
                <label for="" class="text-center break-words cursor-pointer"
                       wire:click="changeDir('{{ encrypt($dir) }}')">
                    @php
                        $dir_array = explode('/',$dir);
                        $dir_name = end($dir_array);
                    @endphp
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                    </svg>
                    <span class="text-green-700">{{ $dir_name }}</span>
                </label>
            </div>
        @endforeach
        @foreach($all_files as $file)
            <div class="w-28 h-38 rounded hover:bg-white p-2 m-2 hover:shadow-md shadow truncate">
                <svg class="svg-icon" viewBox="0 0 20 20">
                    <path
                        d="M15.475,6.692l-4.084-4.083C11.32,2.538,11.223,2.5,11.125,2.5h-6c-0.413,0-0.75,0.337-0.75,0.75v13.5c0,0.412,0.337,0.75,0.75,0.75h9.75c0.412,0,0.75-0.338,0.75-0.75V6.94C15.609,6.839,15.554,6.771,15.475,6.692 M11.5,3.779l2.843,2.846H11.5V3.779z M14.875,16.75h-9.75V3.25h5.625V7c0,0.206,0.168,0.375,0.375,0.375h3.75V16.75z"></path>
                </svg>
                <label for="" class="text-center break-all">
                    @php
                        $file_array = explode('/',$file);
                        $file_name = end($file_array);
                    @endphp
                    {{ $file_name }} <span class="bg-yellow-500 rounded">{{ number_format(\Illuminate\Support\Facades\Storage::size($file) / 1024 /1024,2) }} MB </span>
                </label>
                <div class="bg-red-500 shadow p-2 rounded hover:shadow-md">
                    <span wire:click="downloadFile('{{ $file }}')" class="text-white cursor-pointer">Download</span>
                </div>
            </div>
        @endforeach
    </div>
    <div class="p-2 my-2 shadow rounded bg-white">
        <input type="text" name="search" id="search" wire:model="search"
               class="focus:outline-none focus:shadow-outline-green p-2 rounded bg-green-300 text-black focus:bg-white w-64 placeholder-green-700"
               placeholder="Search File Here">
    </div>
    <div class="bg-white rounded p-4 grid grid-cols-4 shadow">
        @foreach($files as $file)
            <div class="p-4 m-2 bg-green-200 text-center hover:bg-green-300 hover:shadow-md rounded break-all">
                <div class="text-lg my-2">
                    {{ $file->file_name }}
                </div>
                <div class="p-2 bg-gray-300 rounded-md">
                    <div class="grid grid-cols-4">
                        <a href="{{ \Illuminate\Support\Facades\Storage::url($file->file_url) }}"
                           download="{{ $file->file_name }}"
                           class="hover:shadow-md rounded hover:bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="#" class="hover:shadow-md rounded hover:bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="p-2 my-2 bg-green-300 rounded shadow">
        {{ $files->links('livewire.tailwind_pagination') }}
    </div>
</div>
@push('modals')
    <script>
        window.addEventListener('reset-form', event => {
            document.getElementById('user_file_form').reset();
        });
        window.addEventListener('livewire-upload-progress', event => {
            progress.style.setProperty('--color', 'blue');
            progress.style.setProperty('--scroll', event.detail.progress + '%');
            console.log(event.detail.progress);
            if (event.detail.progress == 100) {
                progress.style.setProperty('--scroll', 0 + '%');
            }
        });
    </script>
@endpush
