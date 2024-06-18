@extends('app.master')
@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Báo cáo doanh thu</h4>

                        {{-- <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Upcube</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div> --}}

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Hôm nay: <span>{{ date("d-m-Y"); }}</span></p>
                                    <h4 class="mb-2">{{ $todayRevenue }}</h4>
                                    <p class="text-muted mb-0"><span class="{{ $compareToYesterday>0?'text-success':'text-danger' }} fw-bold font-size-12 me-2"><i class="ri-arrow-right-{{ $compareToYesterday>0?'up':'down' }}-line me-1 align-middle"></i>{{ $compareToYesterdayFormat }}</span>sv hôm qua</p>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light {{ $compareToYesterday>0?'text-success':'text-danger' }} rounded-3">
                                        <i class="mdi mdi-calendar-today font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Tuần này</p>
                                    <h4 class="mb-2">{{ $thisWeekRevenue }}</h4>
                                    <p class="text-muted mb-0"><span class="{{ $compareToLastWeek>0?'text-success':'text-danger' }} fw-bold font-size-12 me-2"><i class="ri-arrow-right-{{ $compareToLastWeek>0?'up':'down' }}-line me-1 align-middle"></i>{{ $compareToLastWeekFormat }}</span>sv tuần trước</p>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light {{ $compareToLastWeek>0?'text-success':'text-danger' }} rounded-3">
                                        <i class="mdi mdi-calendar-week font-size-24"></i>
                                    </span>
                                </div>

                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Tháng này</p>
                                    <h4 class="mb-2">{{ $thisMonthRevenue }}</h4>
                                    <p class="text-muted mb-0"><span class="{{ $compareToLastMonth>0?'text-success':'text-danger' }} fw-bold font-size-12 me-2"><i class="ri-arrow-right-{{ $compareToLastMonth>0?'up':'down' }}-line me-1 align-middle"></i>{{ $compareToLastMonthFormat }}</span>sv tháng trước</p>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light {{ $compareToLastMonth>0?'text-success':'text-danger' }} rounded-3">
                                        <i class="mdi mdi-calendar-month font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Năm nay</p>
                                    <h4 class="mb-2">{{ $thisYearRevenue }}</h4>
                                    <p class="text-muted mb-0"><span class="{{ $compareToLastYear>0?'text-success':'text-danger' }} fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{ $compareToLastYearFormat }}</span>sv năm trước</p>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light {{ $compareToLastYear>0?'text-success':'text-danger' }} rounded-3">
                                        <i class="mdi mdi-calendar-range-outline font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">

                <!-- end col -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body pb-0">
                            <div class="float-end d-none d-md-inline-block">
                                <select id="revenue-chart" class="form-select shadow-none form-select-sm">
                                    <option  value="this_year">Năm nay</option>
                                    <option selected value="this_month">Tháng này</option>
                                    <option  value="this_week">Tuần này</option>
                                </select>
                            </div>
                            <h4 class="card-title mb-4">Doanh thu</h4>

                            {{-- <div class="text-center pt-3">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <div>
                                            <h5>17,493</h5>
                                            <p class="text-muted text-truncate mb-0">Marketplace</p>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <div>
                                            <h5>$44,960</h5>
                                            <p class="text-muted text-truncate mb-0">Last Week</p>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-sm-4">
                                        <div>
                                            <h5>$29,142</h5>
                                            <p class="text-muted text-truncate mb-0">Last Month</p>
                                        </div>
                                    </div><!-- end col -->
                                </div><!-- end row -->
                            </div> --}}
                        </div>
                        <div class="card-body py-0 px-2">
                            <div id="column_line_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Hóa đơn mới nhất</h4>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tên khách hàng</th>
                                            <th>Địa chỉ</th>
                                            <th>SDT</th>
                                            <th>Thành tiền</th>
                                            <th>Ngày</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        @foreach ($lastInvoices as $lastInvoice)
                                            <tr>
                                                <td>{{ $lastInvoice->customer->name }}</td>
                                                <td>{{ $lastInvoice->customer->address }}</td>
                                                <td>{{ $lastInvoice->customer->phone }}</td>
                                                <td>{{ $lastInvoice->total }}</td>
                                                <td>{{ $lastInvoice->date }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody><!-- end tbody -->
                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->
        </div>

    </div>
    <!-- End Page-content -->

@endsection
@push('scripts')
    <script src="{{ global_asset('backend/assets/js/custom/report_page.js?12') }}"></script>
@endpush
