var appUrl = $('#appUrl').val();
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
    },
});

$(".onlydigits").keypress(function (e) {
//if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //$(".error_Msg").html("Digits Only").show().fadeOut("slow");
                return false;
    }
});

$(document).ajaxError(function (event, request, settings) {
    
    if (request.status === 422) {
        if (request.responseJSON.hasOwnProperty('errors')) {
            $('.has-error').removeClass('has-error');
            $('.requiredAsteriskSpanTag, .help-block').remove();
            var requiredAsteriskSpanTag = '<span class="requiredAsteriskSpanTag" style="color: red;"> *</span>';
            $.each(request.responseJSON.errors, function (key, value) {
                var name = key;
                if (key.indexOf('.') >= 0) {
                    name = createArrayInputNameByJsonObjectKeyString(key);
                }
                try {
                    var currentInputObject = $(':input[name="' + name + '"]');
                    var parentObject = currentInputObject.parents('.form-group') || currentInputObject.parent();
                    parentObject.addClass('has-error');
                    parentObject.append('<span class="help-block"> ' + value + ' </span>');
                    parentObject.find('label').append(requiredAsteriskSpanTag);
                    new PNotify({

                        title: 'Oh No!',
        
                        text: value,
        
                        type:'error'
        
                    });
                } catch (e) {
                }
            });
        }
    }
});

function delete_data(url,table){ 

        swal({
            title: "Confirmation Needed",
            text: 'Are you sure?',
            icon: "warning",
            dangerMode: true,
            buttons: ["Cancel", "Yes"],
        }).then(function (wantToRemove) {
            if (wantToRemove) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        '_method':'DELETE'
                    },
                    success: function (data) {
                        console.log(data);
                        if(data.status === 200)
        
                        {
                            swal(data.message, {
                                icon: "success",
                            });
                            $(table).DataTable().ajax.reload();
                        
                        }
                        
                    }
                });
            }
        });
    }