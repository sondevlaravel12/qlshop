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
    <htmlpageheader name="page-header">
        <p class="text-start size1">{{ date('d/m/Y, H:i:s') }}</p>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <p class="text-end size1" >trang: {PAGENO} / {nbpg}</p>
    </htmlpagefooter>
    @include('app.invoice.print_sample2')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
