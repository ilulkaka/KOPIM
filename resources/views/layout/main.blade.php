<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/img/NPMI_Logo.png') }}">
    <title>KOPIM</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">



    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


    <link href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/datatables-select/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-slider/css/bootstrap-slider.min.css') }}">
    @yield('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-teal navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>


            </ul>



            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <!-- Notifications Dropdown Menu -->

                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"></b> Selamat
                        datang : <b> {{ Auth::user()->name }} </b>
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!--<aside class="main-sidebar sidebar-dark-primary elevation-4">-->
        <aside class="main-sidebar  sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <!--<img src="{{ asset('/dist/img/NPMI_Logo.png') }}" alt="NPMI Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">-->
                <span class="brand-text font-weight-light" style="text-center"><b> -- Koperasi Insan Mandiri
                        --</b></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('/assets/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ url('/userProfil') }}" class="d-block">{{ Auth::user()->email }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        @if (Auth::user()->role == 'Anggota')
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        DASHBOARD

                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logoutaksi') }}" class="nav-link" id="logout">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        LOGOUT
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->role != 'Anggota')
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        DASHBOARD

                                    </p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview {{ Request::is('transaksi/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('transaksi/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cart-plus"></i>
                                    <p>
                                        Transaksi
                                        <i class="fas fa-angle-left right"></i>
                                        <!-- <span class="badge badge-info right">6</span> -->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('transaksi/belanja') }}"
                                            class="nav-link {{ Request::is('transaksi/belanja') ? 'active' : '' }}">
                                            <i class="fas fa-cart-arrow-down nav-icon"></i>
                                            <p>Belanja</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('transaksi/frm_simpanan') }}"
                                            class="nav-link {{ Request::is('transaksi/frm_simpanan') ? 'active' : '' }}">
                                            <i class="fas fa-shopping-bag nav-icon"></i>
                                            <p>Simpanan</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('transaksi/frm_pinjaman') }}"
                                            class="nav-link {{ Request::is('transaksi/frm_pinjaman') ? 'active' : '' }}">
                                            <i class="fas fa-shopping-bag nav-icon"></i>
                                            <p>Pinjaman</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('transaksi/frm_pembayaran') }}"
                                            class="nav-link {{ Request::is('transaksi/frm_pembayaran') ? 'active' : '' }}">
                                            <i class="far fa-credit-card nav-icon"></i>
                                            <p>Pembayaran</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview {{ Request::is('sub/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('sub/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cash-register"></i>
                                    <p>
                                        SUB
                                        <i class="fas fa-angle-left right"></i>
                                        <!-- <span class="badge badge-info right">6</span> -->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('sub/po') }}"
                                            class="nav-link {{ Request::is('sub/po') ? 'active' : '' }}">
                                            <i class="fas fa-directions nav-icon"></i>
                                            <p>PO</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview {{ Request::is('laporan/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('laporan/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-folder-open"></i>
                                    <p>
                                        Laporan
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/laporan/stock_barang') }}"
                                            class="nav-link {{ Request::is('laporan/stock_barang') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt nav-icon"></i>
                                            <p>Stock Barang</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('laporan/lap_transaksi') }}"
                                            class="nav-link {{ Request::is('') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt nav-icon"></i>
                                            <p>Transaksi</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('') }}"
                                            class="nav-link {{ Request::is('laporan/#') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt nav-icon"></i>
                                            <p>SHU</p>
                                        </a>

                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('') }}"
                                            class="nav-link {{ Request::is('laporan/#') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt nav-icon"></i>
                                            <p>Simpanan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('') }}"
                                            class="nav-link {{ Request::is('laporan/#') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt nav-icon"></i>
                                            <p>Pinjaman</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item has-treeview {{ Request::is('grafik/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('grafik/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Grafik
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('') }}"
                                            class="nav-link {{ Request::is('') ? 'active' : '' }}">
                                            <i class="fas fas fa-handshake nav-icon"></i>
                                            <p>Simpanan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('') }}"
                                            class="nav-link {{ Request::is('grafik/#') ? 'active' : '' }}">
                                            <i class="fas fa-hand-holding-usd nav-icon"></i>
                                            <p>Pinjaman</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('') }}"
                                            class="nav-link {{ Request::is('grafik/#') ? 'active' : '' }}">
                                            <i class="fab fa-bitcoin nav-icon"></i>
                                            <p>SHU</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item has-treeview {{ Request::is('master/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('master/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-code"></i>
                                    <p>
                                        Master Data
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/master/frm_barang') }}"
                                            class="nav-link {{ Request::is('master/frm_barang') ? 'active' : '' }}">
                                            <i class="fab fa-codepen nav-icon"></i>
                                            <p>Barang</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/master/frm_anggota') }}"
                                            class="nav-link {{ Request::is('master/frm_anggota') ? 'active' : '' }}">
                                            <i class="fas fa-users nav-icon"></i>
                                            <p>Anggota</p>
                                        </a>
                                    </li>
                                    @if (Auth::user()->role == 'Administrator')
                                        <li class="nav-item">
                                            <a href="{{ url('/master/frm_pengguna') }}"
                                                class="nav-link {{ Request::is('master/pengguna') ? 'active' : '' }}">
                                                <i class="fas fa-user-lock nav-icon"></i>
                                                <p>Pengguna</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            @if (Session('nik') == '000000')
                            @elseif(Session::get('level') == 'Admin')
                                <li class="nav-item has-treeview {{ Request::is('admin/*') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link {{ Request::is('admin/*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>
                                            Admin
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/register') }}"
                                                class="nav-link {{ Request::is('admin/register') ? 'active' : '' }}">
                                                <i class="fas fa-user-plus nav-icon"></i>
                                                <p>Register</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/list-user') }}"
                                                class="nav-link {{ Request::is('admin/list-user') ? 'active' : '' }}">
                                                <i class="fas fa-portrait nav-icon"></i>
                                                <p>List User</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/tools') }}"
                                                class="nav-link {{ Request::is('admin/tools') ? 'active' : '' }}">
                                                <i class="fas fa-tools nav-icon"></i>
                                                <p>Tools</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/log') }}"
                                                class="nav-link {{ Request::is('admin/log') ? 'active' : '' }}">
                                                <i class="fas fa-clipboard-list nav-icon"></i>
                                                <p>Log</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif


                            <li class="nav-item">
                                <a href="{{ url('') }}"
                                    class="nav-link {{ Request::is('calendar') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-calendar-alt"></i>
                                    <p>
                                        Calendar
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('') }}"
                                    class="nav-link {{ Request::is('petunjuk') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-question-circle"></i>
                                    <p>
                                        HELP
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('logoutaksi') }}" class="nav-link" id="logout">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        LOGOUT
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                    </p>
                                </a>
                            </li>
                        @endif
                        <!-- /.sidebar-menu -->
                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">

                        <div class="col-sm-6">

                        </div>

                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Main row -->
                    <input type="hidden" id="userr" name="userr" value="{{ Auth::user() }}">

                    @yield('content')
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>

            <!-- /.content -->
            <footer class="p-3 mb-2 bg-light text-dark">
                <strong>Copyright &copy; 2023 <a href="#">Koperasi Insan Mandiri.</a>.</strong>
                <!-- All rights reserved.-->
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 3.0.2
                </div>
            </footer>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <div id="sidebar-overlay"></div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>





    <!-- AdminLTE App -->
    <script src="{{ asset('/dist/js/adminlte.js') }}"></script>

    <!--<script src="{{ asset('/assets/script/aplikasi.js') }}"></script>-->
    <script src="{{ asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!--<script src="{{ asset('js/app.js') }}"></script>-->
    <!--<script>
        function loadingon() {
            document.getElementById("loadingscreen").style.display = "block";
        }

        function loadingoff() {
            document.getElementById("loadingscreen").style.display = "none";
        }
    </script>-->
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}

        var us = $("#userr").val();
    </script>


</body>

</html>
@yield('script')
