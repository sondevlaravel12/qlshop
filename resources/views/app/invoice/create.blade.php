@extends('app.master')
@push('stylesheets')
<link rel="stylesheet" href="{{ global_asset('asset/lib/jquery-ui/jquery-ui.css') }}">
<!-- Image-Uploader -->
<!--Material Design Iconic Font-->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="{{global_asset('asset/admin/stylesheets/image-uploader.min.css')}}">
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
            <h4 class="mb-sm-0">Thêm mới hóa đơn</h4>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4">
                        <div class="md-3 mb-3">
                            <label for="example-text-input" class="form-label">Số hóa đơn</label>
                            <input class="form-control " value="{{ $invoiceNumber }}" name="invoice_no" type="text" readonly style="background-color:#ddd" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="md-3">
                            <label for="example-text-input" class="form-label">Ngày</label>
                            <input class="form-control example-date-input" type="date"  name="invoice_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="InputAddOn">
                            <button class="InputAddOn-item" data-bs-toggle="modal" data-bs-target="#modal_insert_customer">Thêm</button>
                            <input class="InputAddOn-field " id="customer_search" placeholder="Tìm khách hàng">
                            <div id="modal_insert_customer" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                {{-- modal form create customer --}}
                                <form action="" id="customerForm">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Khách hàng</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <label for="customer_name" class="col-sm-2 col-form-label">Tên khách hàng</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" id="customer_name" name="customer_name">
                                                            </div>
                                                        </div>

                                                    <!-- end row -->

                                                        <div class="row mb-3">
                                                            <label for="customer_phone" class="col-sm-2 col-form-label">Số điện thoại</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="tel"  id="customer_phone" name="customer_phone">
                                                            </div>
                                                        </div>
                                                        <!-- end row -->
                                                        <div class="row">
                                                            <label for="customer_address" class="col-sm-2 col-form-label">địa chỉ</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control"  name="customer_address" id="customer_address" cols="30" rows="2"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Bỏ qua</button>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Lưu khách hàng</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </form>
                            </div><!-- /.modal -->
                        </div>
                    </div>
                </div>

                {{-- holder customer info --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row" id="customerHolder" >
                            {{-- cutomer infor  --}}
                            {{-- for edit customer in js file  --}}
                        </div>
                    </div>
                </div>

                {{-- product  --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="InputAddOn">
                            <button class="InputAddOn-item" data-bs-toggle="modal" data-bs-target="#modal_insert_product">Thêm</button>
                            <input class="InputAddOn-field " id="product_search" placeholder="Tìm sản phẩm">
                            {{-- modal create product  --}}
                            <div id="modal_insert_product" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <form enctype="multipart/form-data" id="productForm">
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
                <form method="post" action="{{ route('invoices.store') }}" id="invoice_form">
                    @csrf
                    <input type="hidden" value="{{ $invoiceNumber }}" name="invoice_no_holder" type="text"  id="invoice_no" >
                    <input type="hidden"  name="invoice_date_holder" value="{{ date('Y-m-d') }}">
                    <input type="hidden" id="customer_id" class="customer_id" name="customer_id">
                    <div class="table-responsive">
                        <table class="table-sm" width="100%" style="border-color: #ddd;" id="productTable">
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
                                        <input type="text" name="invoice_subtotal"  value="" id="invoice_subtotal" class="form-control estimated_amount" readonly >
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="7"><b>Phí vận chuyển:</b></td>

                                    <td colspan="3">
                                        <input value="30.000" type="text" name="shipping_fee" value="" id="shipping_fee" class="form-control shipping_fee auto_formatting_input_value" style="background-color: #ddd; font-weight:bold;" >
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="7"><b>Giảm giá hóa đơn:</b></td>

                                    <td colspan="3">
                                        <input type="text" name="invoice_amount_off" value="" id="invoice_amount_off" class="form-control invoice_amount_off auto_formatting_input_value" style="background-color: #ddd; font-weight:bold; color:red;" >
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="7"><h4 class="blue">Khách cần trả:</h4></td>

                                    <td colspan="3">
                                        <input type="text" name="product_total" value="0" id="product_total" class="form-control estimated_amount" readonly style="background-color: #ddd; font-weight:bold; color:rgb(32, 90, 226)" >
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <textarea name="note" class="form-control" id="note" placeholder="Ghi chú đơn hàng..."></textarea>
                        </div>
                    </div><br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="fas fa-save"></i> Lưu
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
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/jquery.validate.js"></script> --}}
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/additional-methods.js"></script> --}}
<script type="text/javascript" src="{{ global_asset('asset/js/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ global_asset('asset/js/additional-methods.js') }}"></script>

<script>
    function preview() {
        imagePreview.src=URL.createObjectURL(event.target.files[0]);
}
</script>
<script src="{{ global_asset('backend/assets/libs/jquery-ui/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{global_asset('asset/admin/javascripts/image-uploader.min.js')}}"></script>

<script src="{{ global_asset('backend/assets/js/custom/invoice_page.js') }}"></script>
<script src="{{ global_asset('backend/assets/js/custom/auto_formatting_input_value.js') }}"></script>
<script>

</script>
@endpush
