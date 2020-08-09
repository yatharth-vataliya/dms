$("#save_topup").on("click",function(e){    
    e.preventDefault();
    $( "#add_topup" ).validate({
        rules: {
            title: {
                required: true,
            },
            amount: {
                required: true,
            },
            discount: {
                required: true,
            },
            price: {
                required: true,
            },
            description: {
                required: true,
            },
    }
    }); 
    if($("#add_topup").valid()){
        var id = $('#topupId').val();
        var frm = new FormData($("#add_topup")[0]);
		var action = $('#add_topup').attr('action');
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
