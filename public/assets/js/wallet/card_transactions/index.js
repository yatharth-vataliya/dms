$('#card_transactions_listing').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        'url': appUrl+"application/card-transactions/get-all",
        'type': 'POST',
    },
    columns: [
        {data: 'DT_RowIndex'},
        { data: 'card_holder'},
        { data: 'type'},
        { data: 'amount'},
        { data: 'balance'},
        { data: 'description'},
        { data: 'action'},
    ]
});



$("body").on("click",".delete_card_transaction",function(){
    var id = $(this).attr('data-id');
    var url = appUrl+"application/card-transactions/"+id;
    var table = "#card_transactions_listing";
    delete_data(url,table);
});
