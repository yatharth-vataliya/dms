<template>
	<div class="p-4 rounded shadow-sm bg-white">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card shadow-sm border-primary">
					<div class="card-header">
						<h4><strong>File Upload Section</strong></h4>
					</div>
					<div card="card-body">
						<form id="file-upload-form" ref="file_upload_form" v-bind:action="action" method="POST" enctype="multipart/form-data" v-on:submit.prevent>
							<button class="m-1 btn btn-success" v-on:click="$refs.file.click()">Add Files</button>
							<input type="file" ref="file" name="userfiles[]" id="user-files" class="file">
							<button type="button" class="btn btn-warning">Add Folder</button>
							<button type="submit" class="float-right btn btn-primary m-1" v-on:click="submit()">Submit File</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:{
		action :{
			type : String,
			required : true
		},
	},
	data(){
		return {
			files: null,
			directories: null,
		}
	},
	methods:{
		submit: function(){
			// this.$refs.file_upload_form.reset();
		},
	},
	computed:{},
	watch:{},
	mounted() {
		console.log('Component Mounted');
		axios.get(`${MainUrl}/file`).then(function(response){
			console.log(response.data);
			let data = response.data;
			if(_.isEmpty(data.files) && !_.isEmpty(data.directories)){
				this.files = data.files;
				this.directories = data.directories;
			}
		});
	},
};
</script>

<style type="text/css" scoped>

.file{
	display: none;
}

</style>