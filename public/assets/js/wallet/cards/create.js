$("#save_card").on("click",function(e){    
    e.preventDefault();
    $( "#add_card" ).validate({
        rules: {
            number: {
                required: true,
            },
            type: {
                required: true,
            },
    }
    }); 
    if($("#add_card").valid()){
        var frm = new FormData($("#add_card")[0]);
        var action = $('#add_card').attr('action');
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
