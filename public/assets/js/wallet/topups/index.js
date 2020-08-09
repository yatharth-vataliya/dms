$('#topups_listing').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        'url': appUrl+"application/topups/get-all",
        'type': 'POST',
    },
    columns: [
        {data: 'DT_RowIndex'},
        { data: 'title'},
        { data: 'amount'},
        { data: 'discount'},
        { data: 'price'},
        { data: 'description'},
        { data: 'action'},
    ]
});



$("body").on("click",".delete_topup",function(){
    var id = $(this).attr('data-id');
    var url = appUrl+"application/topups/"+id;
    var table = "#topups_listing";
    delete_data(url,table);
});
