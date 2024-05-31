@extends('app.master')
@section('title')
{{ Request::getHost(); }} - giao dịch - hóa đơn
@endsection
@push('stylesheets')
    <style>
        @page{
            margin-top: 0px;
            margin-bottom: 0px;
        }
    </style>
@endpush
@section('content')


<div class="row" id='content'>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <h3>
                                    <img src="{{  App\Models\Webinfo::first()?App\Models\Webinfo::first()->getFirstMediaUrl('logo'):'noimage' }}" alt="logo" height="42"/>
                                </h3>

                            </div>
                            <div class="col-6 text-end">

                                <div>
                                    <strong>Địa chỉ: </strong>
                                    {{ App\Models\Webinfo::first()?App\Models\Webinfo::first()->address_2:'' }}
                                </div>
                                <div>
                                    <strong>Điện thoại: </strong>
                                    {{ App\Models\Webinfo::first()?App\Models\Webinfo::first()->phonebase:'' }}
                                </div>
                                <div>
                                    <strong>Website: </strong>
                                    {{ Request::getHost(); }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row ">
                    <div class="col-12 text-center">
                        <h5>Hóa Đơn Bán Hàng</h5>
                        <div>
                            <strong>Số HD: </strong>
                            #{{ $invoice->invoice_no }}
                        </div>
                        <div>
                            <strong>Ngày: </strong>
                            {{ $invoice->date }}
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div>
                            <strong>Khách hàng: </strong>
                            {{ $customer->name }}
                        </div>
                        <div>
                            <strong>SDT: </strong>
                            {{ $customer->phone }}
                        </div>
                        <div>
                            <strong>Địa chỉ: </strong>
                            {{ $customer->address }}
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
                                        <tbody>
                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                        @foreach ($invoiceDetails as $line)
                                        <tr>
                                            <td>{{ $line->product->name }}</td>
                                            <td class="text-center">{{ $line->selling_price }}</td>
                                            <td class="text-center">{{ $line->quantity }}</td>
                                            <td class="text-end">{{ $line->line_total }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center">
                                                <strong>Tổng Tiền hàng</strong></td>
                                            <td class="thick-line text-end">{{ $invoice->subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Phí vận chuyển</strong></td>
                                            <td class="no-line text-end">{{ $invoice->shipping }}</td>
                                        </tr>
                                        @if ($invoice->amount_off>0)
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Chiết khấu</strong></td>
                                            <td class="no-line text-end">{{ $invoice->amount_off }}</td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Tổng thanh toán</strong></td>
                                            <td class="no-line text-end"><h4 class="m-0">{{ $invoice->total }}</h4></td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> <!-- end row -->
                <hr>
                <div class="row">
                    <div class="col-12 text-end">
                        <p>Quý khách được kiểm hàng trước khi nhận. Mọi thắc mắc vui lòng liên hệ {{ App\Models\Webinfo::first()->phonebase }}</p>
                        <p>Cảm ơn và hẹn gặp lại!</p>
                    </div>
                </div>
                <div class="d-print-none">
                    <div class="float-end">
                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i>&nbsp;&nbsp;In hóa đơn</a>

                    </div>
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


@endsection
@push('scripts')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
{{-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script src="{{ asset('backend/assets/js/NunitoSans-Regular-normal.js') }}"></script>
<script>
    // $('#btn_invoice_download').click(function(){
    //     alert('hello');
    // });
    // window.html2canvas = html2canvas;
    // $('#btn_invoice_download').on('click', function(e){
    //     e.preventDefault();

    //     window.jsPDF = window.jspdf.jsPDF
    //     //alert('hi');
    //     //import { jsPDF } from "jspdf";

    //     // Default export is a4 paper, portrait, using millimeters for units
    //     // Landscape export, 2×4 inches
    //     // const doc = new jsPDF({
    //     // orientation: "landscape",
    //     // unit: "in",
    //     // format: [4, 2]
    //     // });

    //     // doc.text("Hello world!", 1, 1);
    //     // doc.save("two-by-four.pdf");
    //     // const myFont = '/Users/sonnguyen/Desktop/devweb/ccls3/public/backend/assets/fonts/remixicon.ttf'
    //     var doc = new jsPDF();

    //     // doc.addFileToVFS("MyFont.ttf", myFont);
    //     doc.addFont("NunitoSans-Regular.ttf", "NunitoSans", "bold");
    //     doc.setFont("NunitoSans", "bold");

    //     console.log(doc.getFontList());
    //     // Source HTMLElement or a string containing HTML.
    //     var elementHTML = document.querySelector("#content");

    //     doc.html(elementHTML, {
    //         callback: function(doc) {
    //             // Save the PDF
    //             doc.save('sample-document.pdf');
    //         },
    //         x: 15,
    //         y: 15,
    //         width: 170, //target width in the PDF document
    //         windowWidth: 650 //window width in CSS pixels
    //     });



    // });


    </script>
@endpush
