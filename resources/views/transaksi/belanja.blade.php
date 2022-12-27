@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col col-md-7">
            <div class="card card-info">
                <div class="card-header">
                    <h4><b><i class="fas fa-cart-plus"> Transaksi</i></b>
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="form_trx" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="role" name="role" value="{{ Auth::user()->name }}">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-caret-square-down"> Kategori</i></strong>
                                <select id="trx_kategori" name="trx_kategori" class="form-control rounded-0" required>
                                    <option value="">Kategori ...</option>
                                    <option value="Anggota">Anggota</option>
                                    <option value="Umum">Umum</option>
                                </select>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-qrcode"> No Barcode</i></strong>
                                <input type="text" id="trx_nobarcode" name="trx_nobarcode" class="form-control rounded-0"
                                    placeholder="Masukkan No Barcode ." required>
                                <input type="hidden" id="trx_nobarcode1" name="trx_nobarcode1"
                                    class="form-control rounded-0" placeholder="Masukkan No Barcode ." required>
                            </div>
</div>
<div class="row">
                            <div class="col col-md-12">
                                <strong disabled><i class="fas fa-quote-left"> Nama</i></strong>
                                <input type="text" id="trx_nama1" name="trx_nama1" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required disabled>
                                <input type="hidden" id="trx_nama" name="trx_nama" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required>
                                    <input type="hidden" name="trx_nik" id="trx_nik">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-dollar-sign"> Nominal</i></strong>
                                <input type="number" name="trx_nominal" id="trx_nominal"
                                    class="form-control form-control-lg rounded-0" required>  
                            </div>
                            <div class="col col-md-6">
                                <br>
                                <button type="button" class="btn btn-success btn-flat btn-lg float-right"
                                    id="btn_simpan_trx">Simpan</button>

                            </div>
                        </div>
                        <p></p>
                        <!--<div class="modal-footer">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </div>-->
                    </form>
                </div>
                <div class="card-footer text-muted">
                                <button type="button" class="btn btn-outline btn-flat float-right" id="btn_detail_trx"
                                    style="color: blue"><u> Detail
                                        Trx</u></button>
                                <button type="button" class="btn btn-outline btn-flat float-right" id="btn_download_trx"
                                    style="color: blue"><u>Download
                                        Trx</u></button>
                </div>
            </div>
        </div>

        <div class="col col-md-5">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><u> Transaksi Hari ini</u></span>
                    <div class="row">
                        <div class="col col-md-4">
                            <span class="info-box-number">Anggota</span>
                            <span class="info-box-number">{{ number_format($hasil_anggota->nominal, 0) }}</span>
                        </div>
                        <div class="col col-md-4">
                            <span class="info-box-number">Umum</span>
                            <span class="info-box-number">{{ number_format($hasil_umum->nominal, 0) }}</span>
                        </div>
                    </div>
                </div>
                <!-- /.info-box-content -->
            </div>
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><u> Total Transaksi</u></span>
                    <span class="info-box-number"><b
                            style="font-size: 24px; color:red">{{ number_format($hasil_total, 0) }}</b></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    </div>

    <!-- Modal Detail Transaksi (DT) -->
    <div class="modal fade" id="modal_detail_trx" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-cart"> Detail
                                Transaksi</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body table-responsive p-0">

                        <table class="table table-hover text-nowrap" width="100%" id="tb_detail_trx">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Tanggal Trx</th>
                                    <th>No Barcode</th>
                                    <th>Nama</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="1" style="text-align:center; ">TOTAL</th>
                                    <th style="text-align:center; font-size: large;">TOTAL</th>
                                    <th style="text-align:center; font-size: large;"></th>
                                    <th style="text-align:center; font-size: large;"></th>
                                    <th style="text-align:center; font-size: large;"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Download Transaksi (DoT) -->
    <div class="modal fade" id="modal_download_trx" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-cart"> Download
                                Transaksi</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-md-4">
                            <strong><i class="fas fa-caret-square-down"> Format</i></strong>
                            <select id="dot_format" name="dot_format" class="form-control rounded-0" required>
                                <option value="">Kategori ...</option>
                                <option value="Excel">Excel</option>
                                <option value="Pdf">Pdf</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-6">
                            <strong><i class="fas fa-date"> Beginning</i></strong>
                            <input type="date" id="tgl_awal" name="tgl_awal" class="form-control rounded-0"
                                required>
                        </div>

                        <div class="col col-md-6">
                            <strong><i class="fas fa-date"> Ending</i></strong>
                            <input type="date" id="tgl_akhir" name="tgl_akhir" class="form-control rounded-0"
                                required>
                        </div>
                    </div>
                    <hr>
                    <div class="row float-right">
                        <button type="button" id="btn_preview" name="btn_preview">Preview</button>
                        <button type="button" id="btn_download" name="btn_download"> Download </button>
                        <button type="button" data-dismiss="modal"> Close </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#trx_kategori").focus();

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 50000
            });

            var fg = 0;

            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    type: 'success',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });

            $("#trx_kategori").change(function(event) {
                var no_barcode = $("#trx_nobarcode").val('');
                if ($("#trx_kategori").val() == 'Anggota') {
                    $("#trx_nobarcode").removeAttr("disabled");
                    $("#trx_nama").val('');
                    $("#trx_nama1").val('');
                    $("#trx_nik").val('');
                    $("#trx_nobarcode").val('');
                    $("#trx_nobarcode1").val('');
                    $("#trx_nobarcode").focus();
                } else if ($("#trx_kategori").val() == 'Umum') {
                    $("#trx_nobarcode").val('999999');
                    $("#trx_nobarcode1").val('999999');
                    $("#trx_nama").val('Client Umum');
                    $("#trx_nama1").val('Client Umum');
                    $("#trx_nik").val('CU00');
                    $("#trx_nominal").val('');
                    $("#trx_nominal").focus();
                    $("#trx_nobarcode").attr("disabled", "disabled");
                } else {
                    alert('Masukkan Type .');
                }
            });

            $("#trx_kategori").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#trx_nobarcode").focus();
                }
            });

            $("#trx_nobarcode").keypress(function(event) {
                var no_barcode = $("#trx_nobarcode").val();
                if (event.keyCode === 13) {
                    if (no_barcode == null || no_barcode == '') {
                        alert('Masukkan Nomer Barcode .');
                    } else {
                        $.ajax({
                                type: "POST",
                                url: APP_URL + '/api/transaksi/get_barcode',
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                data: {
                                    'no_barcode': no_barcode
                                },
                                //processData: false,
                                //contentType: false,
                            })
                            .done(function(resp) {
                                if (resp.success) {
                                    $("#trx_nama").val(resp.nama);
                                    $("#trx_nama1").val(resp.nama);
                                    $("#trx_nik").val(resp.nik);
                                    $("#trx_nominal").val('');
                                    $("#trx_nominal").focus();
                                } else {
                                    alert(resp.message);
                                    $("#trx_nama").val('');
                                    $("#trx_nama1").val('');
                                    $("#trx_nobarcode").val('');
                                    $("#trx_nobarcode").focus();
                                }
                            })
                    }
                }
            });

            $("#trx_nobarcode").keydown(function(e) {
                var no_barcode = $("#trx_nobarcode").val();
                var code = (e.keyCode || e.which);
                if (code === 9) {
                    if (no_barcode == null || no_barcode == '') {
                        alert('Masukkan Nomer Barcode .');
                        $("#trx_nobarcode").val('');
                        $("#trx_nobarcode").focus();
                    } else {
                        $.ajax({
                                type: "POST",
                                url: APP_URL + '/api/transaksi/get_barcode',
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                data: {
                                    'no_barcode': no_barcode
                                },
                                //processData: false,
                                //contentType: false,
                            })
                            .done(function(resp) {
                                if (resp.success) {
                                    $("#trx_nama").val(resp.nama);
                                    $("#trx_nama1").val(resp.nama);
                                    $("#trx_nik").val(resp.nik);
                                    $("#trx_nominal").val('');
                                    $("#trx_nominal").focus();
                                } else {
                                    alert(resp.message);
                                    $("#trx_nama").val('');
                                    $("#trx_nama1").val('');
                                    $("#trx_nobarcode").val('');
                                    $("#trx_nobarcode").focus();
                                }
                            })
                    }
                }
            });

            $("#trx_nominal").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#btn_simpan_trx").focus();
                }
            });

            //$("#form_trx").submit(function(e) {
            //    e.preventDefault();
            $("#btn_simpan_trx").click(function() {
                var data = $("#form_trx").serializeArray();
                //var data = $(this).serialize();
                var kategori = $("#trx_kategori").val();
                var nobarcode = $("#trx_nobarcode").val();
                var nominal = $("#trx_nominal").val();
                if (kategori == '' || nobarcode == '' || nominal == '') {
                    alert('Inputan harus terisi semua');
                } else {
                    $("#btn_simpan_trx").prop('disabled', true);
                    $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/transaksi/trx_simpan',
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: data,
                            //processData: false,
                            //contentType: false,
                        })
                        .done(function(resp) {
                            if (resp.success) {
                                alert(resp.message);
                                location.reload();
                                $("#btn_simpan_trx").prop('disabled', false);
                                $("#trx_kategori").focus();
                            } else {
                                alert(resp.message);
                            }

                        });
                }
            });

            $("#btn_detail_trx").click(function() {
                get_detail_trx();
                $("#modal_detail_trx").modal('show');
            });

            function get_detail_trx() {
                var list_detail_trx = $('#tb_detail_trx').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    searching: true,
                    lengthChange: false,

                    ajax: {
                        url: APP_URL + '/api/transaksi/detail_trx',
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                    },

                    columnDefs: [{
                        targets: [0],
                        visible: false,
                        searchable: false
                    }, ],

                    columns: [{
                            data: 'id_trx_belanja',
                            name: 'id_trx_belanja'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'no_barcode',
                            name: 'no_barcode'
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            width: '40%'
                        },
                        {
                            data: 'nominal',
                            name: 'nominal',
                            render: $.fn.dataTable.render.number(',', '.', 0, '')
                        },
                    ],
                    "footerCallback": function(row, data, start, end, display) {
                        var api = this.api(),
                            data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column(1)
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Total over this page
                        TotalNominal = api
                            .column(4, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $(api.column(4).footer()).html(
                            TotalNominal.toLocaleString("en-US")
                        );

                    }
                });
            }

            $("#btn_download_trx").click(function() {
                $("#modal_download_trx").modal('show');
            });

            $("#btn_download").click(function() {
                var format = $("#dot_format").val();
                var tgl_awal = $("#tgl_awal").val();
                var tgl_akhir = $("#tgl_akhir").val();

                if (format == '' || tgl_awal == '' || tgl_akhir == '') {
                    alert('Kolom Harus terisi semua .');
                } else if (format == 'Pdf') {
                    alert('Format PDF Belum tersedia .');
                } else {
                    $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/transaksi/download',
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content'),
                        },
                        data: {
                            'format': format,
                            'tgl_awal': tgl_awal,
                            'tgl_akhir': tgl_akhir
                        },
                        //processData: false,
                        //contentType: false,
                        success: function(response) {
                            if (response.file) {
                                var fpath = response.file;
                                window.open(fpath, '_blank');
                            } else {
                                alert(response.message);
                            }
                        }
                    })
                }

            });



        });
    </script>
@endsection
