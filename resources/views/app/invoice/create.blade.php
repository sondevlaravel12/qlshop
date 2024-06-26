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
            <h4 class="mb-sm-0">Lên đơn</h4>
            <div class="page-title-right">
                <div >
                    <a target="_blank" href="{{route('invoices.create')}}" class="btn btn-primary waves-effect waves-light" ><i class=" fas fa-file-invoice-dollar"></i> Mở thêm tab lên đơn</a>
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
                {{-- <div class="row" >
                    <label for="customer_address" class="col-sm-2 col-form-label">Khu vực</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text"  id="zones" name="zones">
                        <ul style="list-style-type: none; margin-top:10px" id="zones-holder"></ul>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="InputAddOn">
                            <button class="InputAddOn-item" data-bs-toggle="modal" data-bs-target="#modal_insert_customer">Thêm</button>
                            <input class="InputAddOn-field " id="customer_search" placeholder="Tìm khách hàng">
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
@include('app.invoice.modal.modal_all')

@endsection
@push('scripts')
{{-- jquery validate  --}}
<script type="text/javascript" src="{{ global_asset('asset/js/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ global_asset('asset/js/additional-methods.js') }}"></script>

<script>
    function preview() {
        imagePreview.src=URL.createObjectURL(event.target.files[0]);
    }
</script>
<script src="{{ global_asset('backend/assets/libs/jquery-ui/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{global_asset('asset/admin/javascripts/image-uploader.min.js')}}"></script>

<script src="{{ global_asset('backend/assets/js/custom/invoice_page.js?31') }}"></script>
<script src="{{ global_asset('backend/assets/js/custom/auto_formatting_input_value.js') }}"></script>



@endpush
