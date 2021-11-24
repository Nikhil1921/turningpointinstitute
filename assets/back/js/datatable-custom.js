var url = $("#base_url").val();
var dataTableUrl = $("#dataTableUrl").val();

var table = $('.datatable').DataTable({
    "pagingType": "full_numbers",
    rowReorder: $('#reorder').val() != undefined ? true : false,
    /*"lengthMenu": [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ],
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        {
            extend: 'print',
            footer: true,
            exportOptions: {
                columns: ':visible'
            },
        },
        {
            extend: 'csv',
            footer: true,
            exportOptions: {
                columns: ':visible'
            },
        },
        'colvis'
    ],
    columnDefs: [ {
        targets: -1,
        visible: false
    } ],*/
    "processing": true,
    "serverSide": true,
    'language': {
        'loadingRecords': '&nbsp;',
        'processing': 'Processing',
        'paginate': {
            'first': 'First',
            'next': '<i class="fa fa-arrow-circle-right"></i>',
            'previous': '<i class="fa fa-arrow-circle-left"></i>',
            'last': 'Last'
        }
    },
    "order": [],
    "ajax": {
        url: dataTableUrl,
        type: "POST",
        data: function(data) {
            data.status = $("#status").val();
            data.staff_id = $("#staff_id").val();
        },
        complete: function(response) {},
    },
    "columnDefs": [{
        "targets": "target",
        "orderable": false,
    }, ]
});

table.on('row-reorder', function(e, diff, edit) {

    var result = [];

    for (var i = 0, ien = diff.length; i < ien; i++)
        result.push({ id: $(table.row(diff[i].node).data()[4]).attr('id'), position: diff[i].newData });
    if (result.length > 0) {
        $.ajax({
            url: dataTableUrl + '/sort',
            type: 'POST',
            data: { sort: result },
            dataType: "JSON",
            success: function(result) {
                notify(result.status ? " Success : " : " Error : ", result.message, result.status ? "success" : "danger");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                notify("Error : ", "Something is not going good. Try again.", "danger");
            }
        });
    }
});