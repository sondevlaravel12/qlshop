@extends('backend.layouts.master')
@push('stylesheets')
{{-- daterangepicker --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
{{-- end daterangepicker --}}
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Hóa đơn đã xóa</h4>

            <div class="page-title-right">
                <div >
                    <a href="{{route('admin.invoices.create')}}" class="btn btn-primary waves-effect waves-light" ><span ><i class="fas fa-plus"></i> Add invoice</span></a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Hóa đơn đã xóa</h4>
                <div class="row">
                        <div class="col-12">
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>

                </div><br><br>

                <table id="datatable_with_daterange" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>


                        <th>Ngày xóa</th>
                        <th>Mã hóa đơn</th>
                        <th>Tên Khách hàng</th>
                        <th>SDT</th>
                        <th>Tổng tiền hàng</th>
                        <th>Ghi chú</th>
                        <th width='18%'>Sửa</th>

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

{{-- daterangepicker --}}

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('backend/assets/js/custom/invoice_page_deleted.js') }}"></script>

@endpush

