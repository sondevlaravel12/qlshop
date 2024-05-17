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
                    {{-- <a href="{{route('dashboard')}}" class="waves-effect"> --}}
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end"></span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Tenant Manager </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('tenants.index') }}">Tenant list</a></li>
                        <li><a href="{{ route('tenants.off') }}">Delete Tenant</a></li>
                    </ul>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
