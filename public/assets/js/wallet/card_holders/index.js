$('#card_holders_listing').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        'url': appUrl+"application/card-holders/get-all",
        'type': 'POST',
    },
    columns: [
        {data: 'DT_RowIndex'},
        { data: 'card_number'},
        { data: 'card_holder'},
        { data: 'action'},
    ]
});



$("body").on("click",".delete_card_holder",function(){
    var id = $(this).attr('data-id');
    var url = appUrl+"application/card-holders/"+id;
    var table = "#card_holders_listing";
    delete_data(url,table);
});
