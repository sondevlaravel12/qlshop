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
           border-collapse: collapse;
           border-spacing: 3px;
        }
        .size1{
            font-size: 6px
        }
        .size2{
            font-size: 7px
        }
        .size3{
            font-size: 8px
        }
        .size4{
            font-size: 9px
        }
        .size5{
            font-size: 10px
        }


    </style>
  </head>
  <body>

        @foreach ($invoices as $invoice)
        <htmlpageheader name="page-header">
            <p class="text-start" style="font-size: 6px">{{ date('d/m/Y, H:i:s') }}</p>
        </htmlpageheader>
        @php
            $customer = $invoice->customer;
            $invoiceDetails = $invoice->invoiceDetails;
        @endphp

        {{-- <htmlpagefooter name="page-footer">
            <p class="text-end" style="font-size: 6px">trang: {PAGENO} / {nbpg}</p>
        </htmlpagefooter> --}}
        @include('app.invoice.print_sample2')

        @if (!$loop->last)
        <pagebreak />
        @endif
        @endforeach
    </body>
</html>
