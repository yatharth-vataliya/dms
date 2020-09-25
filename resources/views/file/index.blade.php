@extends('layouts.app')

@section('title')
File Handling
@endsection

@section('styles')

@endsection

@section('content')
<div id="file-upload-component" class="container-fluid">
	<file-component v-bind:action="action"></file-component>
</div>
@endsection


@section('scripts')
<script>
	window.MainUrl = '{{ url("/") }}';
	window.FileCreateUrl = '{{ route("file.create") }}';
</script>

@endsection