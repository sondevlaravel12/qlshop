$(document).ready(function() {

    var $start = moment().subtract(6, 'days');
    var $end = moment();

    cb($start, $end);

    // fill date in input or div place holder
    function cb($start, $end) {
        $('#reportrange span').html($start.format('D/M/YYYY') + ' - ' + $end.format('D/M/YYYY'));

        fetch_data($start.format('YYYY-MM-DD') ,$end.format('YYYY-MM-DD'));

    }

    $('#reportrange').daterangepicker({
        startDate: $start,
        endDate: $end,
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
    })
    ;

    function fetch_data(start_date = '', end_date = ''){
        $('#datatable_with_daterange').DataTable().destroy();

        // load data source for datatable
        var dataTable = $('#datatable_with_daterange').DataTable({
            // "processing" : true,
            // "serverSide" : true,
            stateSave: true,
            "ajax" : {
                type: "GET",
                url: "/admin/invoices/ajax-filter-deleted-ivoices",
                data:{start_date:start_date, end_date:end_date},
                dataSrc: 'data'
            },
            "columns":[
                {data: 'date'},
                {data: 'invoice_no'},
                {data: 'customer_name'},
                {data: 'customer_phone'},
                {data: 'total'},
                {data: 'note'},
                {data: 'id'}
            ],
            "columnDefs":[
                {
                    "targets":[6],
                    'searchable':false,
                    "orderable":false,
                    'render': function(data){
                        return `<button type="submit" class="btn btn-sm btn-link btn_invoice_recovery"  data-orderid="orderId"><i class="far fa-edit"></i>Khôi phục</button>
                        <button type="submit" class="btn btn-sm btn-link btn_invoice_deletePermanently" data-orderid="orderId" ><i class="far fa-trash-alt"></i>Xóa vĩnh viễn</button>`.replace(/orderId/g,data);
                    }
                }
            ]
        });

        // recovery invoice
        $('#datatable_with_daterange').on('click','.btn_invoice_recovery', function(){
            var $row = dataTable.row($(this).parents('tr'));
            var $invoiceId = $(this).attr('data-orderid');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/admin/ajax-restore",
                data: {invoiceID:$invoiceId},
                dataType: "json",
                success: function (response) {
                    if(response.message){
                    // remove row
                    $row.remove().draw(false);
                    //console.log($(this).parents('tr'));
                    // display notification
                    //alert($(this).closest('tr').val());
                    toastr.success(response.message);
                    };
                }
            });
        });

        // delete invoice permanently
        $('#datatable_with_daterange').on('click','.btn_invoice_deletePermanently', function(){
            // event.preventDefault();
            Swal.fire({
                title: 'Bạn có chắc muốn?',
                text: "Xóa vĩnh viễn hóa đơn này? hóa đơn đã xóa không thể khôi phục được.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Vâng, xóa vĩnh viễn hóa đơn!'
                }).then((result) => {
                if (result.isConfirmed) {
                    var $row = dataTable.row($(this).parents('tr'));
                    var $invoiceId = $(this).attr('data-orderid');
                    deleteInvoicePermanently($invoiceId, $row)
                }

            })

        });

        function deleteInvoicePermanently($invoiceId, $row){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/admin/ajax-delete-permanently",
                data: {invoiceID:$invoiceId},
                dataType: "json",
                success: function (response) {
                    if(response.message){
                    $row.remove().draw();
                    toastr.success(response.message);
                    return true;
                    };
                }
            });
        };
    }

});
