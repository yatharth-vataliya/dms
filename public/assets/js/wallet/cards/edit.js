$("#update_card").on("click",function(e){    
    e.preventDefault();
    $( "#edit_card" ).validate({
        rules: {
            number: {
                required: true,
            },
            type: {
                required: true,
            },
    }
    }); 
    if($("#edit_card").valid()){
        var id = $('#cardId').val();
        var frm = new FormData($("#edit_card")[0]);
		var action = $('#edit_card').attr('action');
        frm.append('_method','PUT');
        $.ajax({
            url: action,
            type: 'POST',
            data : frm,
            processData: false,
            contentType: false,
            success:function(data){
                console.log(data);
                if(data.status == 400)
                {
                    swal("Oh no!", data.message, "error");
                }
                if(data.status == 200)
                {
                    swal(data.message, {
                        icon: "success",
                    }).then(function () {
                        window.location = data.data.redirect_path;
                    });

                    
                }

            },
            error: function(){
                
            }
        });
    }else{
        
    }
});
