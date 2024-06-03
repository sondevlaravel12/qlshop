$(document).ready(function () {
    /* ---------------------------------------------
Sweetalert
--------------------------------------------- */
// delete invoice in index page

    // $(".delete_invoice").submit(function( event ) {
    //     event.preventDefault();
    //     Swal.fire({
    //         title: 'Bạn có chắc muốn?',
    //         text: "Xóa hóa đơn này?",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Vâng, xóa hóa đơn!'
    //         }).then((result) => {
    //         if (result.isConfirmed) {

    //             Swal.fire(
    //             'Xóa!',
    //             'Hóa đơn đã xóa.',
    //             'success'
    //             )
    //             $(".delete_invoice").off("submit").submit();
    //         }

    //     })
    // });

/* ---------------------------------------------
End Sweetalert
--------------------------------------------- */
var $start = moment().subtract(6, 'days');
var $end = moment();
var $table = $('#datatable_with_daterange');

// set data and call fetch data when load page
cb($start, $end);

// fill date in input or div place holder
function cb($start, $end) {
    $('#reportrange span').html($start.format('D/M/YYYY') + ' - ' + $end.format('D/M/YYYY'));

    fetch_data($start.format('YYYY-MM-DD') ,$end.format('YYYY-MM-DD'));

}

$('#reportrange').daterangepicker({
    startDate: $start,
    endDate: $end,
    dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    ranges: {
        'Hôm nay': [moment(), moment()],
        'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 ngày gần nhất': [moment().subtract(6, 'days'), moment()],
        '30 ngày gần nhất': [moment().subtract(29, 'days'), moment()],
        'Tháng này': [moment().startOf('month'), moment().endOf('month')],
        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb)
.on('apply.daterangepicker', function(ev, picker) {
    $startDate = picker.startDate.format('YYYY-MM-DD');
    $endDate = picker.endDate.format('YYYY-MM-DD');

    fetch_data($startDate ,$endDate);
    //fdt_without_datatable($startDate ,$endDate);
});
function fetch_data(start_date = '', end_date = ''){
    $table.DataTable().destroy();

    // load data source for datatable

    var $dataTable = $table.DataTable({
        // "processing" : true,
        // "serverSide" : true,
        // "order": [2,'desc'],
        "order": [0,'desc'],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'colvis',
                text: "Ẩn / Hiện cột"
            },
            {
                extend: 'excelHtml5',
                text: "Xuất excel",
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ,6 ]
                },
                customize: function( xlsx, row ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row c[r^="G"], row c[r^="F"]', sheet).attr( 's', 64);
                }
            }

        ],

        stateSave: true,
        "ajax" : {
            type: "GET",
            url: "/api/invoices/filter-invoices",
            data:{start_date:start_date, end_date:end_date},
            dataSrc: 'data'
        },
        "columns":[
            {data: 'date'},
            {data: 'invoice_no'},
            {data: 'customer_name'},
            {data: 'customer_phone'},
            {data: 'customer_address'},
            {data: 'total'},
            {data: 'note'},
            {data: 'id'}
        ],
        "columnDefs":[
            {
                "targets":[7],
                'searchable':false,
                "orderable":false,
                "width": "10%",
                'render': function(data){
                    return `<input type="hidden" name="invoice_id" value="invoiceId">
                    <button href="#" class="btn btn-sm btn-link btn_show_invoice"><i class="fas fa-eye"></i></button>
                    <a href="invoices/invoiceId/edit" class="btn btn-sm btn-link"><i class="far fa-edit"></i></a>
                    <a target="_blank" href="/invoices/invoiceId/print" class="btn btn-sm btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                    <button type="submit" class="btn btn-sm btn-danger btn_invoice_delete" data-orderid="invoiceId" ><i class="far fa-trash-alt"></i></button>
                    `
                    .replace(/invoiceId/g,data);
                }
            },
            {
                'targets': 0,
                type: 'date-euro',
            },
            // {"targets":[2],
            // "width": "10%"
            // },
            // {"targets":[4],
            // "width": "20%"
            // },
            { "visible": false, "targets": [1,6] }
        ]
    });

    // show invoice
    // $table.on('click','.btn_show_invoice', function(){
    //     // event.preventDefault();
    //     alert('hi');

    // });
    // delete invoice
    $table.on('click','.btn_invoice_delete', function(){
        // event.preventDefault();
        Swal.fire({
            title: 'Bạn có chắc muốn?',
            text: "Xóa hóa đơn này không?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Vâng, xóa hóa đơn!'
            }).then((result) => {
            if (result.isConfirmed) {
                // console.log('xoa');
                var $row = $dataTable.row($(this).parents('tr'));
                var $invoiceId = $(this).attr('data-orderid');
                deleteInvoice($invoiceId, $row)
            }

        })

    });


    function deleteInvoice($invoiceId, $row){
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $.ajax({
            type: "DELETE",
            url: "/api/invoices/destroy",
            data: {invoiceID:$invoiceId},
            dataType: "json",
            success: function (response) {
                if(response.message){
                $row.remove().draw(false);
                toastr.success(response.message);
                return true;
                };
            }
        });
    };
    // print invoice

    $table.on('click','.btn_invoice_print', function(){
        alert('hi');
    });

}



});
