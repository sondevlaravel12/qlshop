<!doctype html>
<html lang="en">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />


        <!-- App favicon -->
        <link rel="shortcut icon" href="{{global_asset('backend/assets/images/favicon.ico')}}">

        <!-- jquery.vectormap css -->
        <link href="{{global_asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="{{global_asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        {{-- <link href="{{global_asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" /> --}}
        <!-- Taginput -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css" >
        <!-- Bootstrap Css -->
        <link href="{{global_asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap-theme.min.css">

        <!-- Icons Css -->
        <link href="{{global_asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{global_asset('backend/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
        @stack('stylesheets')
    </head>

    <body data-topbar="dark" >
    {{-- <body data-topbar="light" data-sidebar="dark" data-sidebar-size="small" > --}}



    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">


            @include('app.body.header_simplify')

            <!-- ========== Left Sidebar Start ========== -->
            @include('app.body.sidebar_simplify')
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>

                <!-- End Page-content -->

                @include('app.body.footer')

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->

        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->

        <script src="{{global_asset('backend/assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{global_asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{global_asset('backend/assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{global_asset('backend/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{global_asset('backend/assets/libs/node-waves/waves.min.js')}}"></script>


        <!-- apexcharts -->
        <script src="{{global_asset('backend/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- jquery.vectormap map -->
        <script src="{{global_asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{global_asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')}}"></script>

        <!-- Required datatable js -->
        <script src="{{global_asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{global_asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <!-- Datatable modify sorting with non english language : not work-->
        <script src="//cdn.datatables.net/plug-ins/1.12.1/sorting/intl.js"></script>
        {{-- <script src="{{global_asset('backend/assets/js/pages/datatable_sorting_intl.js')}}"></script> --}}
        <!-- Datatable init js -->
        <script src="{{global_asset('backend/assets/js/pages/datatables.init.js')}}"></script>
        {{-- <script src="{{global_asset('backend/assets/js/pages/datatables_default_setting.js')}}"></script> --}}


        <!-- Responsive examples -->
        {{-- <script src="{{global_asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script> --}}
        {{-- <script src="{{global_asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script> --}}

        <script src="{{global_asset('backend/assets/js/pages/dashboard.init.js')}}"></script>

        <!-- App js -->
        <script src="{{global_asset('backend/assets/js/app.js')}}"></script>


        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
         @if(Session::has('message'))
         var type = "{{ Session::get('alert-type','info') }}"
         switch(type){
            case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;
            case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;
            case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;
            case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
         }
         @endif
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script src="{{ global_asset('backend/assets/js/sweetalert.js') }}"></script>

         <!--tinymce js 5.3 version-->
         <script src="{{ global_asset('backend/assets/libs/tinymce/tinymce.min.js') }}"></script>

         <!-- init js -->
         <script src="{{ global_asset('backend/assets/js/pages/form-editor.init.js') }}"></script>
         <!-- Taginput -->
         <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js" ></script>
         <script src="{{global_asset('backend/assets/js/typeahead.bundle.js')}}"></script>
         {{-- setup ajax header  --}}
         <script>
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
         </script>
        {{--datatable innitialize  --}}
        <script>
        var $table = $('table');
        var $dataTable = $('#datatable').DataTable({
            order: [[0, 'desc']],
            paging: !1,
        });

        </script>

         {{-- displayNotification  --}}
         <script>
            function displayNotification(message, type="info"){
             switch(type){
                case 'info':
                toastr.info(message);
                break;
                case 'success':
                toastr.success(message);
                break;
                case 'warning':
                toastr.warning(message);
                break;
                case 'error':
                toastr.error(message);
                break;
             }

            }
        </script>
        {{-- characters count live function  --}}
        <script>
            function titleCharCountLive(str, range='50-100'){
                $length = str.length;
                document.getElementById("title-char-count").innerHTML = $length + ' out of range ' + range + ' characters';
            }
            function excerptCharCountLive(str, range='300-500'){
                $length = str.length;
                document.getElementById("excerpt-count").innerHTML ='should be ' + $length + ' out of range ' + range + ' characters';
            }
            // call on tinymce init keyup event
            function descriptionCharCountLive(currentLength,range='110-110000'){
                document.getElementById("description-char-count").innerHTML = currentLength + ' out of range ' + range + ' characters';
            }
        </script>
        {{--end characters count live function  --}}
        {{-- global variabl and const  --}}
        <script>
            const money = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'VND' });
        </script>
        @stack('scripts')
    </body>

</html>
