$("#save_card_transactions").on("click",function(e){    
    e.preventDefault();
    $( "#add_card_transactions" ).validate({
        rules: {
            card_holder_id: {
                required: true,
            },
            type: {
                required: true,
            },
            amount: {
                required: true,
            },
            balance: {
                required: true,
            },
            description: {
                required: true,
            }
        }
    }); 
    if($("#add_card_transactions").valid()){
        var id = $('#cardTransactionId').val();
        var frm = new FormData($("#add_card_transactions")[0]);
		var action = $('#add_card_transactions').attr('action');
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
