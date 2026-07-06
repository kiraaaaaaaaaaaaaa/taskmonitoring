<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>{{ Str::title(str_replace('.', ' ', Route::currentRouteName())) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/mfbm.png')}}">

    <!-- plugin css -->
    <link href="{{asset('assets/libs/jsvectormap/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/mfbm.png" alt="" height="70">
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/mfbm.png" alt="" height="70">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <!-- App Search-->

                    </div>

                    <div class="d-flex align-items-center">

                        <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>






                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="{{Auth::user()->avatar}}" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{Auth::user()->name}}</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{Auth::user()->position}}</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->

                                
                                {{-- <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a> --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                <button type="submit" class="dropdown-item"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></button>
                            
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- removeNotificationModal -->
        <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure ?</h4>
                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box py-3">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/mfbm.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/mfbm.png')}}" alt="" height="70">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/mfbm.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/mfbm.png')}}" alt="" height="70">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{route('dashboard')}}" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboard</span>
                            </a>

                        </li> <!-- end Dashboard Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{route('task disposition')}}" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-apps">Task Disposition</span>
                            </a>

                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{route('my task')}}" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                                <i class="mdi mdi-view-carousel-outline"></i> <span data-key="t-layouts">My Task</span>
                            </a>

                        </li> <!-- end Dashboard Menu -->

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{route('review')}}" id="review" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                <i class="mdi mdi-account-circle-outline"></i> <span data-key="t-authentication">To Review</span>
                            </a>

                        </li>

                        <li class="nav-item">
                                        <a class="nav-link menu-link" href="{{route('budget management')}}" id="budget" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                                            <i class="ri-rocket-line"></i> <span data-key="t-landing">Budget Management</span>
                                        </a>

                        </li>
                        

                         {{-- <li class="nav-item">
                            <a class="nav-link menu-link" href="/reports" role="button" aria-expanded="false" aria-controls="sidebarPages">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-pages">Reports</span>
                            </a>

                        </li> --}}

                       


                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarTables" id="management" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTables">
                                <i class="mdi mdi-grid-large"></i> <span data-key="t-tables">Master Data</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarTables">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link menu-link" href="{{route('user management')}}" id="users" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                                            <i class="ri-rocket-line"></i> <span data-key="t-landing">User</span>
                                        </a>

                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link menu-link" href="{{route('pap management')}}" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                                            <i class="ri-rocket-line"></i> <span data-key="t-landing">PAP</span>
                                        </a>

                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link menu-link" href="{{route('sector management')}}" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                                            <i class="ri-rocket-line"></i> <span data-key="t-landing">Sector</span>
                                        </a>

                                    </li>
                                     <li class="nav-item">
                                        <a class="nav-link menu-link" href="{{route('obex management')}}" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                                            <i class="ri-rocket-line"></i> <span data-key="t-landing">Program/Sub-program/OBEX</span>
                                        </a>

                                    </li>
                                </ul>
                            </div>
                        </li>

                        





                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ Str::title(str_replace('.', ' ', Route::currentRouteName())) }}</h4>



                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    @yield('content')






                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            2026 © BRO.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by BRO-ICD
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>



    <!-- Theme Settings -->

    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script  src="{{asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
    {{-- <script src="{{asset('assets/js/plugins.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/js/jquery-4.0.0.min.js')}}"></script> --}}
    <script src="{{asset('assets/libs/list.js/list.min.js')}}"></script>


    <!-- apexcharts -->
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Vector map-->
    <script src="{{asset('assets/libs/jsvectormap/jsvectormap.min.js')}}"></script>
    <script src="{{asset('assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

    <!-- Dashboard init -->
    <script src="{{asset('assets/js/pages/dashboard-analytics.init.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('assets/js/app.js')}}"></script>
    @yield('scripts')
</body>

</html>

<script>
 document.addEventListener('DOMContentLoaded', () => {

    const review = document.getElementById('review');
    const user = document.getElementById('users');
    const management = document.getElementById('management');
    const budget = document.getElementById('budget');

    const userType = @json(Auth::user()->usertype);

    if (userType === '2') {
        review.style.display = 'none';
        user.style.display = 'none';
    }

    if (userType !== '1') {
        management.style.display = 'none';
        budget.style.display = 'none';
    }

});
</script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    @endif

    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: '{{ session('warning') }}'
        });
    @endif
</script>
