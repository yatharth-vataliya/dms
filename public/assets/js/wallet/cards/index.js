var cardTable =  $('#card_listing').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        'url': appUrl+"application/cards/get-all",
        'type': 'POST',
    },
    columns: [
        {data: 'DT_RowIndex'},
        { data: 'number'},
        { data: 'type'},
        { data: 'action'},
    ]
});



$("body").on("click",".delete_card",function(){
    var id = $(this).attr('data-id');
    var url = appUrl+"application/cards/"+id;
    var table = "#card_listing";
    delete_data(url,table);
});
