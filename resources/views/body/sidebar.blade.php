<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                <img src="{{global_asset('backend/global_assets/images/users/avatar-1.jpg')}}" alt="" class="avatar-md rounded-circle">
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
                <li class="menu-title">Menu</li>

                <li>
                    {{-- <a href="{{route('admin.dashboard')}}" class="waves-effect"> --}}
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end"></span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Coupon</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{ route('admin.coupons.index') }}">Danh sách Coupon</a></li> --}}
                        {{-- <li><a href="{{ route('admin.coupons.create') }}">Thêm mới Coupon</a></li> --}}
                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{ route('admin.order.fromcarts.index') }}">Đơn hàng giỏ hàng</a></li> --}}
                        <li><a href="#">Đơn hàng form chat</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Sản Phẩm</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{ route('admin.products.index') }}">Danh Sách Sản Phẩm</a></li> --}}
                        {{-- <li><a href="{{ route('admin.products.create') }}">Thêm mới Sản Phẩm</a></li> --}}
                        {{-- <li><a href="{{ route('admin.categories.index') }}">Danh Mục Sản Phẩm</a></li> --}}
                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Bài viết</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{ route('admin.posts.index') }}">Danh Sách Bài Viết</a></li> --}}
                        {{-- <li><a href="{{ route('admin.posts.create') }}">Thêm Mới Bài Viết</a></li> --}}
                        <li><a href="#">Danh Mục Bài Viết</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Tag</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{ route('admin.tags.index') }}">Danh sách tag</a></li> --}}
                        {{-- <li><a href="{{ route('admin.posts.create') }}">Tag bài viết</a></li> --}}
                        {{-- <li><a href="{{ route('admin.tags.tag-to-product') }}">Tag Sản Phẩm</a></li> --}}
                        {{-- <li><a href="{{ route('admin.tags.tag-to-post') }}">Tag Bài Viết</a></li> --}}
                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Tùy Chỉnh Giao Diện</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{ route('interfacecustomize.category') }}">Cấu Hình Hiển Thị Danh Mục</a></li> --}}

                        <li><a href="#">Cấu Hình Chung</a></li>
                        <li><a href="#">Cấu Hình Header</a></li>
                        <li><a href="#">Cấu Hình Footer</a></li>
                        <li><a href="#">Cấu Hình Sidebar</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Khác</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{ route('admin.about.edit') }}">Giới thiệu Cty</a></li> --}}
                        {{-- <li><a href="{{ route('admin.contact.edit') }}">Trang liên lạc</a></li> --}}
                        {{-- <li><a href="{{ route('admin.returnPolicy.edit') }}">Chính sách đổi trả</a></li> --}}
                        {{-- <li><a href="{{ route('admin.purchasingPolicy.edit') }}">Chính sách mua hàng</a></li> --}}
                        {{-- <li><a href="{{ route('admin.bankInfor.edit') }}">Tài khoản ngân hàng</a></li> --}}
                        <li><a href="#">Add New Slider</a></li>
                    </ul>
                </li>

                {{-- @haspermission('can-view-themes','admin')
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Theme</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a target="_blank"  href="{{ global_asset('project_theme/frontend_theme/home.html') }}">Frontend</a></li>
                        <li><a target="_blank"  href="{{ global_asset('project_theme/backend_theme/ui-cards.html') }}">Backend</a></li>
                    </ul>
                </li>
                @endhaspermission
                @role('superadmin', 'admin')

                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Super admin only</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a  href="{{ route('superadmin.sample.index') }}">only text product multiple version</a></li>
                        <li><a  href="{{ route('superadmin.originalproduct.index') }}">Original product</a></li>
                        <li><a  href="{{ route('superadmin.oproduct.import') }}">Import sản phẩm gốc từ file csv</a></li>
                    </ul>


                </li>
                @endrole --}}



                {{-- <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Slider</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.slider.index')}}">All Sliders</a></li>
                        <li><a href="{{route('admin.slider.create')}}">Add New Slider</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Post</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.posts.index')}}">All Posts</a></li>
                        <li><a href="{{route('admin.posts.create')}}">Add New Post</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Product</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.products.index')}}">All products</a></li>
                        <li><a href="{{route('admin.products.create')}}">Add new product</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Inventory Product</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.inventory_products.index')}}">All inventory products</a></li>
                        <li><a href="{{route('admin.inventory_products.create')}}">Add new inventory product</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Hóa đơn</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.invoices.create')}}">Thêm mới</a></li>
                        <li><a href="{{route('admin.invoices.index')}}">Danh sách Hóa đơn</a></li>
                        <li><a href="{{route('admin.invoices.deleted')}}">Hóa đơn đã xóa</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>SEO</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.seo.posts.index')}}">All Seo Post</a></li>
                        <li><a href="">Product</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Quản lý Đơn Hàng</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.order.fromcarts.index')}}">Đơn hàng giỏ hàng</a></li>
                        <li><a href="{{route('admin.order.fromchats.index')}}">Đơn hàng form chat</a></li>

                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-layout-3-line"></i>
                        <span>Layouts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Vertical</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="layouts-dark-sidebar.html">Dark Sidebar</a></li>
                                <li><a href="layouts-compact-sidebar.html">Compact Sidebar</a></li>
                                <li><a href="layouts-icon-sidebar.html">Icon Sidebar</a></li>
                                <li><a href="layouts-boxed.html">Boxed Layout</a></li>
                                <li><a href="layouts-preloader.html">Preloader</a></li>
                                <li><a href="layouts-colored-sidebar.html">Colored Sidebar</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Horizontal</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="layouts-horizontal.html">Horizontal</a></li>
                                <li><a href="layouts-hori-topbar-light.html">Topbar light</a></li>
                                <li><a href="layouts-hori-boxed-width.html">Boxed width</a></li>
                                <li><a href="layouts-hori-preloader.html">Preloader</a></li>
                                <li><a href="layouts-hori-colored-header.html">Colored Header</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="menu-title">Pages</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Authentication</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="auth-login.html">Login</a></li>
                        <li><a href="auth-register.html">Register</a></li>
                        <li><a href="auth-recoverpw.html">Recover Password</a></li>
                        <li><a href="auth-lock-screen.html">Lock Screen</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Utility</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html">Starter Page</a></li>
                        <li><a href="pages-timeline.html">Timeline</a></li>
                        <li><a href="pages-directory.html">Directory</a></li>
                        <li><a href="pages-invoice.html">Invoice</a></li>
                        <li><a href="pages-404.html">Error 404</a></li>
                        <li><a href="pages-500.html">Error 500</a></li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
