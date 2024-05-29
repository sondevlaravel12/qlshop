@extends('app.master')
@push('stylesheets')

{{-- daterangepicker --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
{{-- end daterangepicker --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/r-2.4.0/datatables.min.css"/>
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
</style>
@endpush


@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Hóa đơn</h4>

            <div class="page-title-right">
                <div >
                    <a href="{{route('invoices.create')}}" class="btn btn-primary waves-effect waves-light" ><i class="fas fa-plus"></i>Thêm mới</a>
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

<script>

// $(document).ready( function () {
//     $('#datatable').DataTable({

//         });
// } );



</script>
{{-- daterangepicker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{-- end daterangepicker --}}
<script src="{{ global_asset('backend/assets/js/custom/invoice_page_index.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/r-2.4.0/datatables.min.js"></script>


<script>
    $(document).ready( function () {

        $('#example').DataTable( {
            "order": [0,'desc'],
            dom: 'Bfrtip',
        buttons: [

            {
            extend: 'colvis',
            text: "Ẩn / Hiện cột"
            },
            {
            extend: 'excel',
            text: "Xuất excel"
            }
        ],
        "columnDefs": [
            { "visible": false, "targets": [4,5] }
        ],
        responsive: true,
        } );


    } );
</script>
<script>
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
    // $('.btn_show_invoice').on('click', function(e){
    // e.preventDefault();
    // get product id
    // var $productId = $(this).siblings("input[name='product_id']").val();
    // call ajax to load data and show modal
    // getProductInfo($productId).done(function(data){
    // console.log($productId);
    // $modal_show_invoice = $('#modal_show_invoice');
    // $modal_show_product.find("#sale_unit_holder").hide();

    // // fill in modal data
    // $modal_show_product.find(".modal-title").html(data.name);
    // $modal_show_product.find("input[name='price']").val(data.price);
    // $modal_show_product.find("input[name='original_price']").val(data.original_price);
    // $modal_show_product.find("input[name='sale_unit']").val(data.sale_unit);
    // $modal_show_product.find("input[name='created_at']").val(data.created_at);
    // $modal_show_product.find("input[name='SKU']").val(data.SKU);


    // // $modal_show_product.find("#sale_unit_holder").hide();

    // // $modal_show_product.find("#imagePreview").attr('scr','hihi');

    // // disabled input field
    // $modal_show_invoice.find('input').attr('disabled','disabled');

    // $modal_show_invoice.modal('show');
    // console.log('hi');
    // });
</script>

@endpush

