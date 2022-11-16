<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/assets/images/npmi.png')}}">
    <title>PT. NPR Manufacturing Indonesia</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="{{asset('/assets/plugins/chartist-js/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/plugins/chartist-js/dist/chartist-init.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="{{asset('/assets/plugins/c3-master/c3.min.css" rel="stylesheet')}}">
    <!-- Custom CSS -->
    <link href="{{asset('/style/css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('/style/css/colors/blue.css')}}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
      <link href="https://material.io/resources/icons" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            
                            <!-- Light Logo icon -->
                            <img src="{{asset('/assets/images/npmi.png')}}" style="height:60px;widt:30px" class="rounded-circle" alt="homepage" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         
                         <!-- Light Logo text -->    
                         <img src="{{asset('/assets/images/npmi_text.png')}}" class="light-logo" alt="homepage" style="height:50px;width:150px" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="waves-effect waves-dark" href="pages-profile.html" aria-expanded="false"><i class="mdi mdi-48px mdi-account-circle"></i><span class="hide-menu">User</span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-teal" href="index.html" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li> 
                            <div class="dropdown">
                            <a class="dropdown-toggle waves-effect waves-teal" data-toggle="dropdown" href="#" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">Produksi</span></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/input">Entry Report</a>
                                    <a class="dropdown-item" href="#">NG Report</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown">
                            <a class="waves-effect waves-teal dropdown-toggle" data-toggle="dropdown" href="table-emotion.html" aria-expanded="false"><i class="mdi mdi-wrench"></i><span class="hide-menu">Maintenance</span></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Jadwal Perbaikan</a>
                                    <a class="dropdown-item" href="#">List Spare Part Mesin</a>
                                </div>
                            </div>
                        </li>
                        <li> 
                            <div class="dropdown">
                            <a class="waves-effect waves-teal dropdown-toggle" data-toggle="dropdown" href="map-google.html" aria-expanded="false"><i class="mdi mdi-checkbox-marked-circle"></i><span style="padding-left:10px;" class="hide-menu">Info Delivery</span></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Target Produksi</a>
                                    <a class="dropdown-item" href="#">Prioritas Hari ini</a>
                                    <a class="dropdown-item" href="#">Pengiriman</a>
                                </div>
                            </div>
                        </li>
                        <!--<li> <a class="waves-effect waves-dark" href="pages-blank.html" aria-expanded="false"><i class="mdi mdi-book-open-variant"></i><span class="hide-menu">Blank Page</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="pages-error-404.html" aria-expanded="false"><i class="mdi mdi-help-circle"></i><span class="hide-menu">Error 404</span></a>
                        </li> -->
                        <li> <a class="waves-effect waves-teal" href="pages-profile.html" aria-expanded="false"><i class="mdi mdi-account-check"></i><span class="hide-menu">User</span></a>
                        </li>
                    </ul>
                    <!-- <div class="text-center m-t-30">
                        <a href="https://wrappixel.com/templates/materialpro/" class="btn waves-effect waves-light btn-warning hidden-md-down"> Upgrade to Pro</a>
                    </div> -->
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
                <!-- item--><a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
                <!-- item--><a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
                <!-- item--><a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a> </div>
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
           <div class="container-fluid">
           @yield('content')
           </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">© 2020 Material Pro Admin by Kaizen TI</footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('/assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('/assets/plugins/bootstrap/js/tether.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('/style/js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('/style/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('/style/js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('/style/js/custom.min.js')}}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- chartist chart -->
    <script src="{{asset('/assets/plugins/chartist-js/dist/chartist.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js')}}"></script>
    <!--c3 JavaScript -->
    <script src="{{asset('/assets/plugins/d3/d3.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/c3-master/c3.min.js')}}"></script>
    <!-- Chart JS -->
    <script src="{{asset('/style/js/dashboard1.js')}}"></script>
</body>

</html>
