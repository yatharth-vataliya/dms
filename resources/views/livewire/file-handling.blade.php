<x-slot name="header">File Handling Section</x-slot>
<div class="bg-blue-100 m-2 p-2 rounded">
	@if ($errors->any())
	<div class="bg-red-200 p-3 rounded my-2">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	@if(!empty(session('info')))
	<div class="p-4 m-3 shadow-sm rounded bg-teal-400">
		{{ session('info') }}
	</div>
	@endif
	<form enctype="multipart/form-data" id="user_file_form" wire:submit.prevent="uploadDocument">
		<input type="file" style="display: none;" id="file_input" wire:model="documents" multiple>
		<button class="bg-blue-700 rounded p-2 text-gray-300 hover:text-gray-700 hover:bg-white hover:shadow focus:outline-none transition duration-150 ease-in-out" type="button" onclick="document.getElementById('file_input').click();">Upload File</button>
		<button type="submit" class="p-2 mr-1 bg-blue-900 text-white hover:bg-white hover:text-blue-900 rounded text-gray-300">Submit</button>
	</form>
</div>
