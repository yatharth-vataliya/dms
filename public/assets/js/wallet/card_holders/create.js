$("#save_card_holders").on("click",function(e){    
    e.preventDefault();
    $( "#add_card_holders" ).validate({
        rules: {
            patient_id: {
                required: true,
            },
            card_id: {
                required: true,
            },
    }
    }); 
    if($("#add_card_holders").valid()){
        var frm = new FormData($("#add_card_holders")[0]);
		var action = $('#add_card_holders').attr('action');
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
