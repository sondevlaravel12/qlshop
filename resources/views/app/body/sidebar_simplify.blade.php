<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                <img src="{{global_asset('backend/assets/images/users/avatar-1.jpg')}}" alt="" class="avatar-md rounded-circle">
            </div>
            <div class="mt-3">
                {{-- <h4 class="font-size-16 mb-1">{{Auth::guard('admin')->check()?Auth::guard('admin')->user()->name:''}}</h4> --}}
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i> Online</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                        <a href="{{route('app.index')}}" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end"></span>
                        <span>Dashboard</span>
                    </a>
                </li>

                @role('superadmin')
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>User Manager </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('users.index') }}">User list</a></li>
                        <li><a href="#">Delete Tenant</a></li>
                    </ul>
                </li>
                @endrole
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="fab fa-product-hunt"></i>
                        <span>Sản phẩm </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('products.index') }}">Danh sách Sản phẩm</a></li>
                        <li><a href="{{ route('products.create') }}">Thêm mới sản phẩm</a></li>
                        <li><a href="{{ route('products.deleted') }}">Sản phẩm Đã xóa</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Hóa đơn</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('invoices.create')}}">Thêm mới</a></li>
                        <li><a href="{{route('invoices.index')}}">Danh sách Hóa đơn</a></li>
                        <li><a href="{{route('invoices.deleted')}}">Hóa đơn đã xóa</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#" class=" waves-effect">
                        <i class="fas fa-cog"></i>
                        <span>Cài đặt</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('tenant.settings.display.edit') }}">Hóa đơn</a></li>
                    @role('superadmin')
                        <li><a href="{{ route('tenant.settings.info.edit') }}">Thông tin cửa hàng</a></li>
                        <li><a href="#">Giao diện</a></li>

                    @endrole
                    </ul>


                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
