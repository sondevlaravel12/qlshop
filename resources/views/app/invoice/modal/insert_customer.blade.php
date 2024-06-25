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
                            <div class="row" >
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
