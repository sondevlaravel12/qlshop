@extends('app.master')
@push('stylesheets')

{{-- daterangepicker --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
{{-- end daterangepicker --}}

<link href="https://cdn.datatables.net/v/bs/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/r-3.0.2/sl-2.0.3/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<style>
    table#example td {
  font-size: 1em;
}
div.dt-button-collection button.dt-button:active:not(.disabled), div.dt-button-collection button.dt-button.active:not(.disabled), div.dt-button-collection div.dt-button:active:not(.disabled), div.dt-button-collection div.dt-button.active:not(.disabled), div.dt-button-collection a.dt-button:active:not(.disabled), div.dt-button-collection a.dt-button.active:not(.disabled) {
    background-color: #cccccc;
    background-image: linear-gradient(to bottom, #bfe0f5 0%, #bfe0f5 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='#f0f0f0', EndColorStr='#dadada');
    /* box-shadow: inset 1px 1px 3px #666; */
    font-family: 'Trebuchet MS',sans-serif;
    font-size: 12px;
}


.dt-search{
    float: right;
}

</style>
@endpush


@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Hóa đơn</h4>

            <div class="page-title-right">
                <div >
                    <a href="{{route('invoices.create')}}" class="btn btn-primary waves-effect waves-light" ><i class="fas fa-plus"></i> Lên đơn</a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>

                </div>
                <br><br>
                <table id="datatable_with_daterange" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th class="text-center"><button style="border: none; background: transparent; font-size: 14px;" id="MyTableCheckAllButton">
                            <i class="far fa-square"></i>
                            </button></th>
                        <th>Ngày</th>
                        <th>Mã HD</th>
                        <th>Tên Khách hàng</th>
                        <th>SDT</th>
                        <th>Địa chỉ giao hàng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Thành tiền</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>

                    </tr>
                    </thead>


                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


{{-- modal  --}}
{{-- modal show invoice  --}}
@include('app.invoice.modal.show_invoice')
{{-- end modal  --}}

@endsection
@push('scripts')

{{-- daterangepicker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{-- end daterangepicker --}}
{{-- <script src="{{ global_asset('backend/assets/js/custom/invoice_page_index.js?123') }}"></script> --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/v/bs/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/r-3.0.2/sl-2.0.3/datatables.min.js"></script>

{{-- for sorting date format dd/mm/yyyy  --}}
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/2.0.8/sorting/date-euro.js"></script>

<script>
    // show invoice
    $('table').on('click','.btn_show_invoice', function(){
        // event.preventDefault();
        // get product id
        // var $invoiceId = $(this).siblings("input[name='invoice_id']").val();
        var $invoiceId = $(this).siblings("input[name='invoice_id']").val();
        // call ajax to load data and show modal
        getInvoiceInfo($invoiceId).done(function(data){
            $modal_show_invoice = $('#modal_show_invoice');
            // $modal_show_invoice.find(".modal-title").html('Số hóa đơn: #'+data.invoice_no);
            $modal_show_invoice.find("#invoice_no").html(data.invoice_no);
            $modal_show_invoice.find("#date").html(data.date);
            $customer = $modal_show_invoice.find("#customerHolder");
            $customer.find('#name').html(data.customer.name);
            $customer.find('#phone').html(data.customer.phone);
            $customer.find('#address').html(data.customer.address);

            $invoice_details_holder =  "";
            $modal_show_invoice.find('#invoice_details_holder').html('');
            $.each(data.invoice_details, function(key, detail){
                $row = `<tr>
                            <td>`+ data.products[key].name +`</td>
                            <td class="text-center">`+ detail.selling_price +`</td>
                            <td class="text-center">`+ detail.quantity +`</td>
                            <td class="text-end">`+ detail.line_total +`</td>
                        </tr>`;

                $invoice_details_holder += $row;
            })
            $summaryInvoice = `<tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-center">
                                        <strong >Tổng Tiền hàng</strong>
                                    </td>
                                    <td id="subtotal" class="thick-line text-end"></td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center">
                                        <strong >Phí vận chuyển</strong></td>
                                    <td id="shipping" class="no-line text-end"></td>
                                </tr>
                                {{-- @if ($invoice->amount_off>0) --}}
                                <tr id="amount_off_tr">
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center">
                                        <strong >Chiết khấu</strong></td>
                                    <td id="amount_off" class="no-line text-end"></td>
                                </tr>
                                {{-- @endif --}}

                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center">
                                        <strong >Tổng thanh toán</strong></td>
                                    <td  class="no-line text-end"><h4 id="total" class="m-0"></h4></td>
                                </tr>`;

            $invoice_details_holder += $summaryInvoice;
            $modal_show_invoice.find('#invoice_details_holder').prepend($invoice_details_holder);
            $modal_show_invoice.find('#subtotal').html(data.subtotal);
            $modal_show_invoice.find('#shipping').html(data.shipping);
            if(data.amount_off>0){
                $modal_show_invoice.find('#amount_off_tr').show();
                $modal_show_invoice.find('#amount_off').html(data.amount_off);
            }else{
                $modal_show_invoice.find('#amount_off_tr').hide();
            }
            $modal_show_invoice.find('#total').html(data.total);

            $modal_show_invoice.modal('show');
        })




    });
    function getInvoiceInfo(invoice){
        return $.ajax({
                type: "get",
                url: '/invoices/' + invoice,
                data: {invoice:invoice},
                dataType: "json",
            });
    }
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
</script>
<script>
    // -------------- datarangepicker with datatable --------------------------//
    //https://www.daterangepicker.com/
    // global variables
    var $start = moment().subtract(6, 'days');
    var $end = moment();
    var $table = $('#datatable_with_daterange');
    var $dataTable;

    // initial and config datatabes when loading page and when selecting daterangepicker
    function initial_and_config_datatabes(response){
        if(response.data){
            $dataTable = $table.DataTable({
                        'data':response.data,
                        "order": [1,'desc'],
                        buttons: [
                            {
                                extend: 'colvis',
                                titleAttr: "Ẩn / Hiện cột",
                                text: '<i class="fas fa-columns"></i>',
                                className: 'btn btn-info w-sm waves-effect waves-light',
                            },
                            {
                                extend: 'excelHtml5',
                                // title:'Hạt Giông Lam Sơn - đơn hàng',
                                title:'',
                                titleAttr: "Xuất excel",
                                text: '<i class="fa fa-file-excel-o"></i>',
                                className: 'btn btn-light w-sm waves-effect waves-light',
                                exportOptions: {
                                    // columns: [ 0, 1, 2, 3, 4, 5 ,6 ],
                                    columns: [ 1, 3, 4, 5 ,6 ],
                                    // https://datatables.net/extensions/buttons/examples/html5/outputFormat-orthogonal.html
                                    orthogonal: 'export'
                                },
                                customize: function( xlsx, row ) {
                                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                        $('row c[r^="E"]', sheet).attr( 's', 63);
                                },
                                filename: function() {
                                $today = moment().format('D_M_YYYY');
                                filename = 'hgls_' + $today ;
                                return filename;
                                }
                            },
                            {
                                text: '<i class="fa fa-print"></i>',
                                titleAttr: 'In hàng loạt',
                                className: 'btn btn-success w-sm waves-effect waves-light',
                                action: function () {
                                    let rowsSelected = $dataTable.rows({ selected: true });
                                    if(rowsSelected.data().length>0){
                                        let ids =[];
                                        for (var i = 0; i < rowsSelected.data().length; i++) {
                                            ids.push(rowsSelected.data()[i].id);
                                        }
                                        window.open('/in/{'+ ids +'}','_blank');
                                    }
                                }
                            },

                        ],
                        layout: {
                            topStart: 'buttons'
                        },
                        "columns":[
                            {"defaultContent": ""},
                            // {data: 'id'},
                            {data: 'date'},
                            {data: 'invoice_no'},
                            {data: 'customer_name'},
                            {data: 'customer_phone'},
                            {data: 'customer_address'},
                            {
                                data: 'total',
                                render: function (data, type, row) {
                                    return type === 'export' ? data.replace(/[.]/g, '') : data;
                                }
                            },
                            {data: 'note'},
                            {data: 'id'},
                        ],
                        "columnDefs":[

                            {
                                orderable: false,
                                className: 'select-checkbox',
                                targets: 0

                            },
                            {
                                "targets":[8],
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
                                'targets': 1,
                                type: 'date-euro',
                            },
                            {
                                // "visible": false, "targets": [2,7]
                                target: [2,7],
                                visible: false
                            }
                        ],
                        select: {
                            style: 'multi',
                            selector: 'td:first-child'
                            // selector: 'td:not(:last-child)' // no row selection on last column
                        },
                        stateSave: true,
                    });
        };

        $dataTable.on("click", "th.select-checkbox", function() {
            if ($("th.select-checkbox").hasClass("selected")) {
                $dataTable.rows().deselect();
                $("th.select-checkbox").removeClass("selected");
                $('#MyTableCheckAllButton i').attr('class', 'far fa-square');
            } else {
                $dataTable.rows().select();
                $("th.select-checkbox").addClass("selected");
                $('#MyTableCheckAllButton i').attr('class', 'far fa-check-square');

            }
        }).on("select deselect", function() {
            if ($dataTable.rows({
                    selected: true
                }).count() !== $dataTable.rows().count()) {
                $("th.select-checkbox").removeClass("selected");
                $('#MyTableCheckAllButton i').attr('class', 'far fa-square');
            } else {
                $('#MyTableCheckAllButton i').attr('class', 'far fa-check-square');
                $("th.select-checkbox").addClass("selected");


            }
        });

    };
    // fill date in input or div place holder
    function cb(start, end) {
        $('#reportrange span').html(start.format('D/M/YYYY') + ' - ' + end.format('D/M/YYYY'));
    }
    // call when load the page in the first time
    cb($start, $end);
    // attach a date range picker to div
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
    }, cb);
    // triggered when the apply button is clicked, or when a predefined range is clicked
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {

        $dataTable.clear().draw();
        call_ajax_and_fetch_data(picker.startDate, picker.endDate);
        // call_ajax_and_fetch_data($start, $end);
        // console.log(picker.startDate);
    });

    // fetch data when loading page the first time and when selected daterangepicker
    function ajax_get_invoices (start, end){
        return $.ajax({
                type: "GET",
                url: "/api/invoices/filter-invoices",
                data:{start_date:start.format('YYYY-MM-DD'), end_date:end.format('YYYY-MM-DD')},
                dataType: "json",
            });
    };
    function call_ajax_and_fetch_data(start, end){
                ajax_get_invoices(start, end).done(function(response){
                if ($.fn.dataTable.isDataTable('#datatable_with_daterange')) {
                    $dataTable.clear();
                    if(response.data){
                        $dataTable.rows.add(response.data).draw();
                    }
                }
                else {
                // innitial datatabels
                initial_and_config_datatabes(response);
                }
        });
    };
    call_ajax_and_fetch_data($start, $end);
    // -------------- datarangepicker with datatable --------------------------//
</script>


@endpush

