{{-- insert customer modal --}}
<div id="modal_insert_customer" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <form action="" id="customerForm">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body ui-front">
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
                            <div class="row mb-3">
                                <label for="customer_address" class="col-sm-2 col-form-label">địa chỉ</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"  id="customer_address" name="customer_address">
                                    {{-- <textarea class="form-control"  name="customer_address" id="customer_address" cols="30" rows="2"></textarea> --}}
                                </div>
                            </div>
                            <div class="row zones-row" >
                                <label for="customer_address" class="col-sm-2 col-form-label">Khu vực</label>
                                <div class="col-sm-10">
                                    <input class="form-control zones" type="text"  id="zones" name="zones">
                                    {{-- <ul style="list-style-type: none; margin-top:10px" id="zones-holder"></ul> --}}
                                    <input type="hidden" id="zone-short-name">
                                    <input type="hidden" id="zone-id">
                                    <input type="hidden" id="ward-code">
                                    <input type="hidden" id="district_code">
                                </div>
                            </div>
                            <div class="row wards-holder invisible" >
                                <label for="customer_address" class="col-sm-2 col-form-label">Phường xã</label>
                                <div class="col-sm-10">
                                    <input class="form-control wards" type="text"  id="wards" name="wards">
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
</div>
{{-- end insert customer modal --}}

{{-- update customer modal --}}
<div id="modal_update_customer" class="modal fade bs-example-modal-center-2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <form action="" id="updateCutomerForm" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ui-front">
                    <div class="card">
                        <div class="card-body">
                            <input name="customer_id" type="hidden" value="` + id + `">
                            <div class="row mb-3">
                                <label for="customer_name" class="col-sm-2 col-form-label">Tên khách hàng</label>
                                <div class="col-sm-10">
                                    <input class="form-control" value="" type="text" id="customer_name" name="customer_name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="customer_phone" class="col-sm-2 col-form-label">Số điện thoại</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="tel" value=""  id="customer_phone" name="customer_phone">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="customer_address" class="col-sm-2 col-form-label">địa chỉ</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"  id="customer_address" name="customer_address">
                                    {{-- <textarea class="form-control"  name="customer_address" id="customer_address" cols="30" rows="2"></textarea> --}}
                                </div>
                            </div>
                            <div class="row zones-row" >
                                <label for="zones" class="col-sm-2 col-form-label">Khu vực</label>
                                <div class="col-sm-10">
                                    <input class="form-control zones" type="text"  id="zones" name="zones">
                                    {{-- <ul style="list-style-type: none; margin-top:10px" id="zones-holder"></ul> --}}
                                    <input type="hidden" id="zone-short-name">
                                    <input type="hidden" id="zone-id">
                                    <input type="hidden" id="ward-code">
                                    <input type="hidden" id="district_code">

                                </div>
                            </div>
                            <div class="row wards-holder " >
                                <label for="wards" class="col-sm-2 col-form-label">Phường xã</label>
                                <div class="col-sm-10">
                                    <input class="form-control wards" type="text"  id="wards" name="wards">
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
</div>
{{-- end update customer modal --}}

{{-- show invoice modal --}}
<div id="modal_show_invoice" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <form enctype="multipart/form-data" id="invoiceModalForm">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title">Số hóa đơn: #HD-6652048AE701B</h5> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row ">
                        <div class="col-12 text-center">
                            <h5>Hóa Đơn Bán Hàng</h5>
                            <div>
                                <strong>Số HD: </strong>
                                <span id="invoice_no"></span>
                            </div>
                            <div>
                                <strong>Ngày: </strong>
                                <span id="date"></span>
                            </div>

                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-12" id="customerHolder">
                            <div>
                                <strong>Khách hàng: </strong>
                                <span id="name"></span>

                            </div>
                            <div>
                                <strong>SDT: </strong>
                                <span id="phone"></span>

                            </div>
                            <div>
                                <strong>Địa chỉ: </strong>
                                <hspan4 id="address"></span>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="p-2">
                                    <h3 class="font-size-16"><strong>Thông tin hàng đặt</strong></h3>
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td><strong>Tên hàng</strong></td>
                                                <td class="text-center"><strong>Giá</strong></td>
                                                <td class="text-center"><strong>Số lượng</strong>
                                                </td>
                                                <td class="text-end"><strong>Thành tiền</strong></td>
                                            </tr>
                                            </thead>
                                            <tbody id="invoice_details_holder">

                                                <tr>
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
                                                    <td id="total" class="no-line text-end"><h4 class="m-0"></h4></td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div>
{{-- end show invoice modal --}}

{{-- insert product modal  --}}
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
</div>
{{-- end insert product modal  --}}
