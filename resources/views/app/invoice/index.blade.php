@extends('app.master')
@push('stylesheets')

{{-- daterangepicker --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
{{-- end daterangepicker --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/r-2.4.0/datatables.min.css"/>
<style>
    table#example td {
  font-size: 1em;
}
div.dt-button-collection button.dt-button:active:not(.disabled), div.dt-button-collection button.dt-button.active:not(.disabled), div.dt-button-collection div.dt-button:active:not(.disabled), div.dt-button-collection div.dt-button.active:not(.disabled), div.dt-button-collection a.dt-button:active:not(.disabled), div.dt-button-collection a.dt-button.active:not(.disabled) {
    background-color: #cccccc;
    background-image: linear-gradient(to bottom, #bfe0f5 0%, #bfe0f5 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='#f0f0f0', EndColorStr='#dadada');
    /* box-shadow: inset 1px 1px 3px #666; */
    font-family: 'Trebuchet MS',sans-serif;
    font-size: 12px;
}
</style>
@endpush


@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Hóa đơn</h4>

            <div class="page-title-right">
                <div >
                    <a href="{{route('invoices.create')}}" class="btn btn-primary waves-effect waves-light" ><i class="fas fa-plus"></i>Thêm mới</a>
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
                    <div class="col-12">
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>

                </div>
                <br><br>

                <table id="datatable_with_daterange" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>


                        <th>Ngày</th>
                        <th>Mã HD</th>
                        <th>Tên Khách hàng</th>
                        <th>SDT</th>
                        <th>Địa chỉ giao hàng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Thành tiền</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>

                    </tr>
                    </thead>


                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->




@endsection
@push('scripts')

<script>

// $(document).ready( function () {
//     $('#datatable').DataTable({

//         });
// } );



</script>
{{-- daterangepicker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{-- end daterangepicker --}}
<script src="{{ global_asset('backend/assets/js/custom/invoice_page_index.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/r-2.4.0/datatables.min.js"></script>


<script>
    $(document).ready( function () {

        $('#example').DataTable( {
            "order": [0,'desc'],
            dom: 'Bfrtip',
        buttons: [

            {
            extend: 'colvis',
            text: "Ẩn / Hiện cột"
            },
            {
            extend: 'excel',
            text: "Xuất excel"
            }
        ],
        "columnDefs": [
            { "visible": false, "targets": [4,5] }
        ],
        responsive: true,
        } );


    } );
</script>
@endpush

