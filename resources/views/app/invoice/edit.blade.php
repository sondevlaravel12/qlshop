@extends('backend.layouts.master')
@push('stylesheets')
<link rel="stylesheet" href="{{ asset('asset/lib/jquery-ui/jquery-ui.css') }}">
<!-- Image-Uploader -->
<!--Material Design Iconic Font-->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="{{asset('asset/admin/stylesheets/image-uploader.min.css')}}">
<style>
/*Change text in autofill textbox*/
input:-webkit-autofill{
    -webkit-text-fill-color: red !important;
    -webkit-box-shadow: 0 0 0 1000px white inset !important;
}

.InputAddOn {
  display: flex;
}

.InputAddOn-field {
  flex: 1;
  /* field styles */
  border: 1px solid rgba(147,128,108,.25);
    padding: 0.5em 0.75em;
    border-radius: 0 2px 2px 0;
}

.InputAddOn-item {
  /* item styles */
  border-radius: 2px 0 0 2px;
  border: 1px solid rgba(147,128,108,.25);
    padding: 0.5em 0.75em;
    background-color: rgba(147,128,108,.1);
    color: #666;
    font: inherit;
    font-weight: 400;
}
#customer td{
    font-size: 19px;
    font-weight: bold;
}
/* for icon */
.blue {
    color: rgb(7, 117, 141) !important;
}


</style>
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Chỉnh sửa hóa đơn</h4>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                        <h5>Số hóa đơn: <span class="badge bg-info">#{{ $invoice->invoice_no }}</span></h5>
                    </div>
                    <div class="col-md-6 ">
                        <p class="float-end">Ngày: <span style="color:red;">{{$invoice->date}}</span></p>
                    </div>
                </div><br>

                {{-- holder customer info --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row" id="customerHolder">
                            <div class="col-md-3">
                                <input id="customer_id" type="hidden" value="{{ $invoice->customer->id }}">
                                <div class="mb-3 position-relative">

                                    <input disabled  value=" + name + " class="form-control" type="hidden" >
                                    <h5>{{ $invoice->customer->name }}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 position-relative">

                                    <input disabled value=" + phone + " class="form-control" type="hidden" >
                                    <h5>{{ $invoice->customer->phone }} </h5>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3 position-relative">

                                    <div class="input-group">
                                        <h5>{{ $invoice->customer->address }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="mb-3 position-relative">

                                    <button class="btn btn-outline-info waves-effect waves-light" type="button" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center-2"><i class="fas fa-edit"></i></button>
                                    <div id="modal_update_customer" class="modal fade bs-example-modal-center-2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <form action="" id="updateCutomerForm" >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Khách hàng</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <input name="customer_id" type="hidden" value="{{ $invoice->customer->id }}">
                                                                    <div class="row mb-3">
                                                                        <label for="customer_name" class="col-sm-2 col-form-label">Tên khách hàng</label>
                                                                        <div class="col-sm-10">
                                                                            <input class="form-control" value="{{ $invoice->customer->name }}" type="text" id="customer_name" name="customer_name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="customer_phone" class="col-sm-2 col-form-label">Số điện thoại</label>
                                                                        <div class="col-sm-10">
                                                                            <input class="form-control" type="tel" value="{{ $invoice->customer->phone }}"  id="customer_phone" name="customer_phone">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label for="customer_address" class="col-sm-2 col-form-label">địa chỉ</label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control"  name="customer_address" id="customer_address" cols="30" rows="2">{{ $invoice->customer->address }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Bỏ qua</button>
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Cập nhật khách hàng</button>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </form>
                                        </div><!-- /.modal -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- product  --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="InputAddOn">
                            <button class="InputAddOn-item" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">Thêm</button>
                            <input class="InputAddOn-field " id="product_search" placeholder="Tìm sản phẩm">
                            {{-- modal create product  --}}
                            <div id="modal_insert_product" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <form method="post" enctype="multipart/form-data" action="{{route('admin.invoices.ajaxCreateProduct')}}" id="productForm">
                                    @csrf
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sản phẩm</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="example-text-input" class="col-sm-2 col-form-label">Tên</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" name="name" value="{{old('name')}}"  >
                                                                    @error('name')
                                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="example-text-input" class="col-sm-2 col-form-label">Giá bán</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control auto_formatting_input_value" type="text" name="price" value="{{old('price')}}"  >
                                                                    @error('price')
                                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="example-text-input" class="col-sm-2 col-form-label">Giá vốn</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control auto_formatting_input_value" type="text" name="original_price" value="{{old('original_price')}}"  >
                                                                    @error('original_price')
                                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label" >Hình ảnh</label>
                                                                <div class="col-sm-10">
                                                                    <div class="input-images-1" style="padding-top: .5rem;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="example-text-input" class="col-sm-2 col-form-label">Đơn vị tính cơ bản</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text" value="Gói" name="sale_unit" list="cars">
                                                                    <datalist id="cars">
                                                                        <option>Volvo</option>
                                                                        <option>Saab</option>
                                                                        <option>Mercedes</option>
                                                                        <option>Audi</option>
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <a href="#collapseOne" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseOne">
                                                                    <div class="card-header" id="headingOne">
                                                                        <h6 class="m-0">
                                                                            Thêm Đơn vị tính
                                                                            <i class="float-end fas fa-angle-down"></i>
                                                                        </h6>
                                                                    </div>
                                                                </a>

                                                            </div>

                                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion" style="">
                                                                <div class="row ">
                                                                    <div class="col-lg-12">
                                                                        <div class="card card-body">
                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <label for="validationTooltip01" class="form-label">Tên đơn vị</label>
                                                                                    <input type="hidden" value="{{ $saleUnits }}" id="sale_unit_lists">
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <label for="validationTooltip02" class="form-label">Giá bán</label>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <label for="validationTooltipUsername" class="form-label">Giá vốn</label>
                                                                                </div>
                                                                                <div class="col-md-2">

                                                                                </div>
                                                                            </div>
                                                                            <div id="show_item">

                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-10"></div>

                                                                                <div class="col-md-2 ">
                                                                                    <div class="mb-3 ">
                                                                                        <button type="button" class="btn btn-light waves-effect add_item_btn ">
                                                                                             <i class="fas fa-plus-circle"></i>&nbspThêm
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Bỏ qua</button>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Lưu sản phẩm</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </form>
                            </div><!-- /.modal -->
                        </div>
                    </div>
                </div>
                <br>
                {{-- holder product info --}}
                <form method="post" action="{{ route('admin.invoices.update', $invoice) }} " id="invoice_form">
                    @csrf
                    <input type="hidden" value="{{ $invoice->invoice_no }}" name="invoice_no_holder" type="text"  id="invoice_no" >
                    <input type="hidden"  name="invoice_date_holder" value="{{ date('Y-m-d H:i:s') }}">
                    <input type="hidden" class="customer_id" name="customer_id" value="{{ $invoice->customer->id }}">
                    <div class="table-responsive">
                        <table class="table-sm mb-0 " width="100%" style="border-color: #ddd;" id="productTable">
                            <thead>
                                <tr style="background-color: #fff1da;">
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th >Đơn vị tính</th>
                                    <th style="width:8%">Số lượng</th>
                                    <th>Đơn giá </th>
                                    <th>Giảm giá</th>
                                    <th>Giá bán </th>
                                    <th>Thành tiền</th>
                                    <th></th>

                                </tr>
                            </thead>

                            <tbody id="productItemsHolder">

                                @foreach ($invoice->invoiceDetails as $invoiceDetail)
                                    @php
                                        $product = $invoiceDetail->product;
                                    @endphp
                                    <tr style="background-color: #e2f6e7;">
                                        <td>
                                            <input  class="form-control"  id="product_id" name="product_id[]"  value="{{ $product->id }}" type="hidden">
                                            <input  class="form-control"  id="product_sku" name="product_sku[]"  value="{{ $product->SKU }}" type="hidden">
                                            {{ $product->SKU }}
                                        </td>
                                        <td style="width:25%; ">
                                            {{ $product->name }}
                                        </td>
                                        <td>
                                            <input  class="form-control"  type="hidden" id="product_sale_unit[]" name="product_sale_unit[]"  value="{{ $product->sale_unit }}">
                                            {{ $product->sale_unit }}
                                        </td>
                                        <td ><input class="form-control product_quantity" id="" name="product_quantity[]" type="number" value="{{ $invoiceDetail->quantity }}" min="1"></td>
                                        <td>
                                            <input type="hidden" class="form-control product_price" readonly name="product_price[]"  value="{{ $product->price }}">
                                            {{ $product->price }}
                                        </td>
                                        <td ><input style="color:red;" class="form-control product_amount_off auto_formatting_input_value" name="product_amount_off[]" type="text" value="{{ $invoiceDetail->amount_off }}"></td>
                                        <td >
                                            <input type="readonly" class="form-control selling_price" readonly name="selling_price[]"  value=" {{ $invoiceDetail->selling_price }}">

                                        </td>
                                        <td >
                                            <input class="form-control product_line_total"  readonly  name="product_line_total[]"  value="   {{ $invoiceDetail->line_total }}" style="width:100%">

                                        </td>
                                        <td >
                                            <button type="button" class="btn btn-outline-danger waves-effect waves-light remove_item_btn">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- product items append here --}}
                            </tbody>

                            <tbody>
                                <tr>
                                    <td class="no_product_error">

                                    </td>
                                    <td>
                                        <input type="hidden" name="product_count" id="product_count">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7"><b>Tổng tiền hàng</b></td>

                                    <td colspan="3">
                                        <input type="text" name="invoice_subtotal"  value="{{ $invoice->subtotal }}" id="invoice_subtotal" class="form-control estimated_amount" readonly >
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="7"><b>Phí vận chuyển:</b></td>

                                    <td colspan="3">
                                        <input value="30.000" type="text" name="shipping_fee" value="{{ $invoice->shipping }}" id="shipping_fee" class="form-control shipping_fee auto_formatting_input_value" style="background-color: #ddd; font-weight:bold;" >
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="7"><b>Giảm giá hóa đơn:</b></td>

                                    <td colspan="3">
                                        <input type="text" name="invoice_amount_off" value="{{ $invoice->amount_off }}" id="invoice_amount_off" class="form-control invoice_amount_off auto_formatting_input_value" style="background-color: #ddd; font-weight:bold; color:red;" >
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="7"><h4 class="blue">Khách cần trả:</h4></td>

                                    <td colspan="3">
                                        <input type="text" name="product_total" value="{{ $invoice->total }}" id="product_total" class="form-control estimated_amount" readonly style="background-color: #ddd; font-weight:bold; color:rgb(32, 90, 226)" >
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <textarea name="note" class="form-control" id="note" placeholder="Ghi chú đơn hàng...">{{ $invoice->note }}</textarea>
                        </div>
                    </div><br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>

                    </div>

                </form>


            </div> <!-- End card-body -->
    <!--  ---------------------------------- -->
        </div>
    </div> <!-- end col -->
</div>

@endsection
@push('scripts')
{{-- jquery validate  --}}
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/jquery.validate.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/additional-methods.js"></script>
<script>
    function preview() {
        imagePreview.src=URL.createObjectURL(event.target.files[0]);
}
</script>
<script src="{{ asset('backend/assets/libs/jquery-ui/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{asset('asset/admin/javascripts/image-uploader.min.js')}}"></script>
<script src="{{ asset('backend/assets/js/custom/invoice_page.js') }}"></script>
<script src="{{ asset('backend/assets/js/custom/auto_formatting_input_value.js') }}"></script>
<script>

jQuery().ready(function () {
    updateProductCount();
    // updateTotal();
});

</script>
<script>
    $("#productForm").submit(function(e) {

        //prevent Default functionality
        e.preventDefault();
        //get the action-url of the form
        var actionurl = e.currentTarget.action;
        // set up header
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //do your own request an handle the results
        $.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'json',
                data: $("#productForm").serialize(),
                success: function(response) {
                    //alert(response.name);
                    // console.log(response.name);
                    var $newrow = `<tr style="background-color: #e2f6e7;">
                                    <td>
                                        <input  class="form-control"  id="product_id" name="product_id[]"  value="` +  response.id + `" type="hidden">
                                        <input  class="form-control"  id="product_sku" name="product_sku[]"  value="` +  response.SKU + `" type="hidden">
                                        `+ response.SKU +`
                                    </td>
                                    <td style="width:25%; ">
                                        `+ response.name +`
                                    </td>
                                    <td>
                                        <input  class="form-control"  type="hidden" id="product_sale_unit[]" name="product_sale_unit[]"  value="` + response.sale_unit + `">
                                        ` + response.sale_unit + `
                                    </td>
                                    <td ><input class="form-control product_quantity" id="" name="product_quantity[]" type="number" value="1" min="1"></td>
                                    <td>
                                        <input type="hidden" class="form-control product_price" readonly name="product_price[]"  value="` +  response.price + `">
                                        ` +  response.price + `
                                    </td>
                                    <td ><input style="color:red;" class="form-control product_amount_off auto_formatting_input_value" name="product_amount_off[]" type="text" value=""></td>
                                    <td >
                                        <input type="readonly" class="form-control selling_price" readonly name="selling_price[]"  value="` +  response.price + `">

                                    </td>
                                    <td >
                                        <input class="form-control product_line_total"  readonly  name="product_line_total[]"  value="  ` + response.price + `" style="width:100%">

                                    </td>
                                    <td >
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light remove_item_btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>`;
                        //alert($newrow);
                    $('#productItemsHolder').append($newrow);
                    $('#modal_insert_product').removeData();
                    $('#modal_insert_product').modal('hide');

                }
        });

    });
</script>
@endpush
