<template>
	<div class="p-4 hover rounded shadow">
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group row">
				<label for="userfiles" class="hover rounded">Select File:- </label>
				<div class="col-md-3 rounded hover">
					<input type="file" id="userfiles" name="userfiles[]" class="form-control-file">
				</div>
			</div>
		</form>
	</div>
</template>

<script>
export default {
	mounted() {
		console.log('File Upload Component mounted.');
	}
};
</script>

<style type="text/css" scoped>
	.hover:hover{
		background-color: rgba(120,140,225,0.6);
		transition: 1.5s;
		display: block;
		box-shadow: 0.25rem 0.25rem 0.5rem gray;
	}
	.hover{
		transition: 1s;
	}
</style>