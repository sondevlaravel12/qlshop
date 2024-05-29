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
</div><!-- /.modal -->
