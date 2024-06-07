<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>hatgionglamson invoices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <style>
        @page {
            header: page-header;
            footer: page-footer;
        }
        .bold{
            font-weight:bold;
        }
        table {
           border-collapse: separate;
           border-spacing: 3px;
        }

    </style>
  </head>
  <body>

        @foreach ($invoices as $invoice)
        <htmlpageheader name="page-header">
            <p class="text-start" style="font-size: 6px">{{ date('d/m/Y, H:i:s') }}</p>
        </htmlpageheader>

        <htmlpagefooter name="page-footer">
            <p class="text-end" style="font-size: 6px">trang: {PAGENO} / {nbpg}</p>
        </htmlpagefooter>
        <div class="invoice">
                    <div class="row">
                        <div class="col-12" style="font-size: 8px">

                                <div class="col-8">
                                    <img src="{{  App\Models\Webinfo::first()?App\Models\Webinfo::first()->getFirstMediaUrl('logo'):'noimage' }}" alt="logo" height="20"/>
                                    <br>


                                    <div >
                                        <span >Địa chỉ:</span>
                                        {{ App\Models\Webinfo::first()?App\Models\Webinfo::first()->address:'' }}
                                    </div>
                                    <div>
                                        <strong >Điện thoại: </strong>
                                        {{ App\Models\Webinfo::first()?App\Models\Webinfo::first()->phonebase:'' }}
                                    </div>
                                    <div>
                                        <strong >Website: </strong>
                                        {{-- {{ Request::getHost(); }} --}}
                                        {{ App\Models\Webinfo::first()->website }}
                                    </div>

                                </div>

                        </div>
                    </div>
                    <hr style="border-top: dotted">
                    <div class="row ">
                        <div class="col-12 text-center" style="font-size: 8px">
                            <h6 class="bold">Hóa Đơn Bán Hàng</h6>
                            <div>
                                <strong >Số HD: </strong>
                                #{{ $invoice->invoice_no }}
                            </div>
                            <div>
                                <strong >Ngày: </strong>
                                {{ $invoice->date }}
                            </div>

                        </div>
                    </div>
                    <div class="row" style="font-size: 8px">
                        <div class="col-12">
                            <div class="bold">
                                <strong >Khách hàng: </strong>
                                {{ $invoice->customer->name }}
                            </div>
                            <div>
                                <strong >SDT: </strong>
                                {{ $invoice->customer->phone }}
                            </div>
                            <div>
                                <strong >Địa chỉ: </strong>
                                {{ $invoice->customer->address }}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12" >
                            <div>
                                <div class="p-2">
                                    <h6 ><strong class="bold">Thông tin hàng đặt</strong></h6>
                                </div>
                                <div>
                                    <table class="table table-bordered " style="font-size: 6px;">
                                        <thead>
                                        <tr style="margin: 1.5 !important;">
                                            <td ><strong class="bold">Tên hàng</strong></td>
                                            <td class="text-center bold"><strong>Giá</strong></td>
                                            <td class="text-center bold"><strong>Số lượng</strong>
                                            </td>
                                            <td class="text-end bold"><strong>Thành tiền</strong></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->

                                        @foreach ($invoice->invoiceDetails as $line)
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
                                            <td class="thick-line text-center bold">
                                                <strong class="bold">Tổng Tiền hàng</strong>
                                            </td>
                                            <td class="thick-line text-end bold">{{ $invoice->subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong class="bold">Phí vận chuyển</strong>
                                            </td>
                                            <td class="no-line text-end bold">{{ $invoice->shipping }}</td>
                                        </tr>
                                        @if ($invoice->amount_off>0)
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong class="bold">Chiết khấu</strong>
                                            </td>
                                            <td class="no-line text-end bold">{{ $invoice->amount_off }}</td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line ">
                                                <strong class="bold">Tổng thanh toán</strong>
                                            </td>
                                            <td class="no-line text-end bold"><h4 class="m-0"><strong>{{ $invoice->total }}</strong></h4></td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->
                    <hr>
                    <div class="row">
                        <div class="col-12 text-end" style="font-size: 8px">
                            <p>Quý khách được kiểm hàng trước khi nhận. Mọi thắc mắc vui lòng liên hệ: {{ App\Models\Webinfo::first()->phonebase }}</p>
                            <p>Cảm ơn và hẹn gặp lại!</p>
                        </div>
                    </div>
        </div>
        @if (!$loop->last)
        <pagebreak />
        @endif
        @endforeach
    </body>
</html>