<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/img/NPMI_Logo.png') }}">
    <title>PT. NPR Mfg Ind</title>
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
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
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
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <!--<img src="{{ asset('/dist/img/NPMI_Logo.png') }}" alt="NPMI Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">-->
                <span class="brand-text font-weight-light" style="text-center"><b> -- Koperasi Insan Mandiri --</b></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('/assets/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ url('/userprofil') }}" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    DASHBOARD

                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Transaksi

                                </p>
                            </a>
                        </li>
                       
                        
                       
                            <li class="nav-item has-treeview {{ Request::is('produksi/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('produksi/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        SIMPANAN
                                        <i class="fas fa-angle-left right"></i>
                                        <!-- <span class="badge badge-info right">6</span> -->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/formmasalah') }}"
                                            class="nav-link {{ Request::is('produksi/formmasalah') ? 'active' : '' }}">
                                            <i class="far fa-keyboard nav-icon"></i>
                                            <p>Informasi Masalah</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/produksi/menu_hasil_produksi') }}"
                                            class="nav-link {{ Request::is('produksi/menu_hasil_produksi') ? 'active' : '' }}">
                                            <i class="far fa-file-alt nav-icon"></i>
                                            <p>Report Produksi</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('produksi/NGreport') }}"
                                            class="nav-link {{ Request::is('produksi/NGreport') ? 'active' : '' }}">
                                            <i class="fas fa-chart-pie nav-icon"></i>
                                            <p>NG Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/lembur') }}"
                                            class="nav-link {{ Request::is('produksi/lembur') ? 'active' : '' }}">
                                            <i class="fas fa-clock nav-icon"></i>
                                            <p>Report Lembur</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview {{ Request::is('maintenance/*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ Request::is('maintenance/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-toolbox"></i>
                                    <p>
                                        PINJAMAN
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/maintenance/perbaikan') }}"
                                            class="nav-link {{ Request::is('maintenance/perbaikan') ? 'active' : '' }}">
                                            <i class="fas fa-hammer nav-icon"></i>
                                            <p>Perbaikan</p>
                                        </a>

                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/maintenance/schedule') }}"
                                            class="nav-link {{ Request::is('maintenance/schedule') ? 'active' : '' }}">
                                            <i class="far fa-calendar-alt nav-icon"></i>
                                            <p>Schedule</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/maintenance/mesin') }}"
                                            class="nav-link {{ Request::is('maintenance/mesin') ? 'active' : '' }}">
                                            <i class="fas fa-cogs nav-icon"></i>
                                            <p>Mesin</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            
                            <li class="nav-item has-treeview {{ Request::is('technical/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('technical/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-drafting-compass"></i>
                                    <p>
                                        LAPORAN
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/undermaintenance') }}"
                                            class="nav-link {{ Request::is('') ? 'active' : '' }}">
                                            <i class="fas fa-plus-square nav-icon"></i>
                                            <p>Jigu Control</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/technical/inquery-permintaan') }}"
                                            class="nav-link {{ Request::is('technical/inquery-permintaan') ? 'active' : '' }}">
                                            <i class="fas fa-plus-square nav-icon"></i>
                                            <p>Request</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/technical/update') }}"
                                            class="nav-link {{ Request::is('technical/update') ? 'active' : '' }}">
                                            <i class="fas fa-clipboard-check nav-icon"></i>
                                            <p>Update Denpyou</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/technical/list_master') }}"
                                            class="nav-link {{ Request::is('technical/list_master') ? 'active' : '' }}">
                                            <i class="fa fa-asterisk nav-icon"></i>
                                            <p>Master Tanegata</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        
                            <li class="nav-item has-treeview {{ Request::is('qa/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('qa/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-ruler-combined"></i>
                                    <p>
                                        MASTER DATA
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/qa/qamenu') }}"
                                            class="nav-link {{ Request::is('qa/qamenu') ? 'active' : '' }}">
                                            <i class="fas fa-plus-square nav-icon"></i>
                                            <p>QA Menu</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            
                        <li class="nav-item has-treeview {{ Request::is('document/*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('document/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    DOCUMENT
                                    <i class="fas fa-angle-left right"></i>
                                    <span class="badge badge-danger right" id="notifdocument"
                                        name="notifdocument"></span>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/document/inquery_document') }}"
                                        class="nav-link {{ Request::is('document/inquery_document') ? 'active' : '' }}">
                                        <i class="fa fa-file-contract nav-icon"></i>
                                        <p>My Document</p>
                                        <!--<span class="badge badge-danger right" id="notifdocument_1"
                                        name="notifdocument_1"></span>-->
                                    </a>
                                </li>
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
                            <a href="{{ url('/calendar') }}"
                                class="nav-link {{ Request::is('calendar') ? 'active' : '' }}">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Calendar
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/petunjuk') }}"
                                class="nav-link {{ Request::is('petunjuk') ? 'active' : '' }}">
                                <i class="nav-icon far fa-question-circle"></i>
                                <p>
                                    HELP
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link" id="logout">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    LOGOUT
                                    <meta name="csrf-token" content="{{ csrf_token() }}">

                                </p>
                            </a>
                        </li>
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

                    @yield('content')
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>

            <!-- /.content -->
            <footer class="p-3 mb-2 bg-light text-dark">
                <strong>Copyright &copy; 2020 <a href="#">PT. NPR Manufacturing Indonesia</a>.</strong>
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

    <script src="{{ asset('/assets/script/aplikasi.js') }}"></script>
    <script src="{{ asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function loadingon() {
            document.getElementById("loadingscreen").style.display = "block";
        }

        function loadingoff() {
            document.getElementById("loadingscreen").style.display = "none";
        }
    </script>
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}



        $("#logout").click(function(event) {
            event.preventDefault();
            var user = localStorage.getItem('npr_id_user');
            $.ajax({
                    url: APP_URL + '/logout',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: user
                    },
                })
                .done(function(resp) {
                    if (resp.success) {
                        localStorage.removeItem('npr_name');
                        localStorage.removeItem('npr_token');
                        localStorage.removeItem('npr_id_user');
                        window.location.href = "{{ route('login') }}";

                    } else
                        $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                })
                .fail(function() {
                    $("#error").html(
                        "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                    );
                    //toastr['warning']('Tidak dapat terhubung ke server !!!');
                });

        });
    </script>

    @if (Session::get('dept') == 'PPIC')
        <script type="text/javascript">
            $(document).ready(function() {

                Echo.channel('mesin')
                    .listen('EventPPIC', (e) => notifikasi(e.message.judul, e.message.sub, e.message.isi));
            });

            function notifikasi(judul, sub, isi) {

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 10000

                });
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: judul,
                    subtitle: sub,
                    body: isi
                })


            }
        </script>
    @endif

    @if (Session::get('level') == 'Supervisor' ||
        Session::get('level') == 'Assisten Manager' ||
        Session::get('level') == 'Manager' ||
        Session::get('level') == 'Admin')
        <script>
            $(document).ready(function() {
                var key = localStorage.getItem('npr_token');
                $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/notifskill",
                        headers: {
                            "token_req": key
                        },
                        dataType: "json",
                    })
                    .done(function(resp) {
                        if (resp.skillmatrik >= 1) {
                            //alert(resp.skillmatrik[0].total);
                            $("#notifskill").html(resp.skillmatrik);
                            $("#notifskill_1").html(resp.skillmatrik);
                        } else {
                            $("#notifskill").html('');
                            $("#notifskill_1").html('');
                        }
                    })
                    .fail(function() {
                        $("#error").html(
                            "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                        );
                    });

            });
        </script>
    @endif

    <script>
                        var key = localStorage.getItem('npr_token');
        $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/notifdocument",
                        headers: {
                            "token_req": key
                        },
                        dataType: "json",
                    })
                    .done(function(resp) {
                        if (resp.document >= 1) {
                            //alert(resp.skillmatrik[0].total);
                            $("#notifdocument").html(resp.document);
                            $("#notifdocument_1").html(resp.document);
                        } else {
                            $("#notifdocument").html('');
                            $("#notifdocument_1").html('');
                        }
                    })
                    .fail(function() {
                        $("#error").html(
                            "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                        );
                    });
    </script>


</body>

</html>
@yield('script')
