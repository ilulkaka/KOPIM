@extends('layout.main')
@section('content')
    <style>
        /* Atur teks merah pada dropdown Select2 */
        .select2-container--default .select2-selection--single {
            color: red !important;
            /* Warna teks merah */
        }

        .select2-container--default .select2-results__option {
            color: red !important;
            /* Warna teks merah pada opsi */
        }
    </style>
    <div class="row">
        <div class="col col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h4><b><i class="fas fa-dollar-sign"> Angsuran</i></b>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <strong style="color: red">
                                <i class="fas fa-filter"> Type</i>
                            </strong>
                            <select id="pem_type" name="pem_type" style="color: red" class="form-control rounded-0"
                                required>
                                {{-- <option value="">Pilih Type ...</option> --}}
                                <option value="Angsuran">Angsuran</option>
                                <option value="Pelunasan">Pelunasan</option>
                            </select>
                        </div>
                    </div>
                    <form id="form_pem" autocomplete="off">
                        @csrf
                        <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                        <hr>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-caret-square-down"> No Pinjaman</i></strong>
                                <select id="pem_nopin" name="pem_nopin" class="form-control rounded-0 select2" required>
                                    <option value="">Pilih No Pinjaman ...</option>
                                    @foreach ($no_pin as $n)
                                        <option value="{{ $n->no_pinjaman }}">{{ $n->no_pinjaman }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-qrcode"> No Anggota</i></strong>
                                <input type="text" id="pem_nobarcode1" name="pem_nobarcode1"
                                    class="form-control rounded-0" placeholder="Masukkan No Barcode ." required disabled>
                                <input type="hidden" id="pem_nobarcode" name="pem_nobarcode" class="form-control rounded-0"
                                    placeholder="Masukkan No Barcode ." required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong disabled><i class="fas fa-quote-left"> Nama</i></strong>
                                <input type="text" id="pem_nama1" name="pem_nama1" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required disabled>
                                <input type="hidden" id="pem_nama" name="pem_nama" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-qrcode"> Periode Ang</i></strong>
                                <input type="date" id="pem_perang" name="pem_perang" class="form-control rounded-0"
                                    placeholder="Masukkan No Barcode ." required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-9">
                                <strong><i class="fas fa-dollar-sign"> Jumlah Angsuran</i></strong>
                                <input type="number" name="pem_jmlang" id="pem_jmlang"
                                    class="form-control form-control-lg rounded-0" required>
                            </div>
                            <div class="col col-md-3">
                                <strong><i class="fas fa-dollar-sign"> Ke</i></strong>
                                <input type="number" name="pem_angke1" id="pem_angke1"
                                    class="form-control form-control-lg rounded-0" required disabled>
                                <input type="hidden" name="pem_angke" id="pem_angke"
                                    class="form-control form-control-lg rounded-0" required>
                                <input type="hidden" name="pem_tenor" id="pem_tenor" required>
                            </div>
                        </div>
                        <p></p>
                        <!--<div class="modal-footer">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </div>-->
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <button type="button" class="btn btn-danger btn-flat" id="btn_cancel_pem">Cancel</button>
                    <button type="button" class="btn btn-success btn-flat float-right" id="btn_simpan_pem">Simpan</button>
                </div>
            </div>
        </div>
        <div class="col col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12">
                        {{-- <div class="card card-secondary card-outline"> --}}
                        <div class="card-header">
                            <h5 class="d-flex">
                                <i class="fa fa-address-book"></i>
                                <b style="margin-left: 1%"><u> Data Angsuran Terakhir </u></b>
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row" style=" margin-left:1%">
                            <div class="form-group col-md-4">
                                <strong>Status</strong>
                                <select name="f_status" id="f_status" class="form-control select2">
                                    <option value="Open">Open</option>
                                    <option value="Close">Close</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <strong> Reload </strong>
                                <br>
                                <button class="btn btn-primary rounded-pill" id="btn_reload"><i
                                        class="fa fa-sync"></i></button>
                            </div>
                        </div>
                    </div>
                    <hr style="margin-top: -5px">
                    <div class="card-body" style="margin-top:-30px">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover text-nowrap" id="tb_angsuran">
                                <thead>
                                    <tr>
                                        <th>No Pinjaman</th>
                                        <th>Nama</th>
                                        <th>Jml Ang</th>
                                        <th>Ke</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
        $(function() {

            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });
        $(document).ready(function() {

            // get_load();
            $("#pem_type").focus();
            var isResetting = false; // Flag untuk menandakan sedang mereset

            $("#pem_type").change(function() {
                get_load_filter();
            });

            $("#pem_nopin").change(function() {
                if (isResetting) {
                    isResetting = false; // Reset flag
                    return; // Jangan jalankan fungsi get_nopinjaman
                }
                get_nopinjaman();
            });


            $("#btn_simpan_pin").click(function() {
                var data = $("#form_pin").serializeArray();

                var no_anggota = $("#pin_nobarcode").val();
                var tglreal = $("#pin_tglreal").val();
                var nama = $("#pin_nama").val();
                var jmlpin = $("#pin_jmlpin").val();
                var tenor = $("#pin_tenor").val();

                if (no_anggota == '' || tglreal == '' || nama == '' || jmlpin == '' || tenor ==
                    '') {
                    alert('Inputan harus terisi semua');
                } else {
                    $("#btn_simpan_pin").prop('disabled', true);
                    $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/transaksi/pinjaman/simpan_pin',
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
                                $("#btn_simpan_pin").prop('disabled', false);
                            } else {
                                alert(resp.message);
                            }

                        });

                }
            });

            var list_angsuran = $('#tb_angsuran').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: APP_URL + '/api/transaksi/pembayaran/list_ang',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.f_status = $("#f_status").val();
                    },
                },

                //columnDefs: [{
                //    targets: [0],
                //    visible: false,
                //    searchable: false
                //}, ],

                columns: [{
                        data: 'no_pinjaman',
                        name: 'no_pinjaman'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jml_angsuran',
                        name: 'jml_angsuran',
                        render: $.fn.dataTable.render.number(',', '.')
                    },
                    {
                        data: 'angsuran_ke',
                        name: 'angsuran_ke'
                    },
                    {
                        data: 'status_angsuran',
                        name: 'status_angsuran'
                    },
                ],

                fnRowCallback: function(nRow, data, iDisplayIndex, iDisplayIndexFull) {
                    if (data.status_angsuran == 'Close') {
                        $('td', nRow).css('color', 'red');
                    }
                }
            });

            $("#btn_reload").click(function() {
                list_angsuran.ajax.reload();
            });

            // $("#btn_simpan_pem").prop('disabled', true);
            $("#btn_simpan_pem").click(function() {
                var data = $("#form_pem").serializeArray();

                var f_type = $("#pem_type").val();
                var nopin = $("#pem_nopin").val();
                var per = $("#pem_perang").val();
                var jmlang = $("#pem_jmlang").val();

                // Gabungkan data form dan nilai f_type ke dalam satu objek
                data.push({
                    name: 'f_type',
                    value: f_type
                });

                if (nopin == '' || per == '' || jmlang == '') {
                    alert('Inputan harus terisi semua');
                } else {
                    $("#btn_simpan_pem").prop('disabled', true);
                    $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/transaksi/pembayaran/simpan_pem',
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
                                // location.reload();
                                list_angsuran.ajax.reload(null, false);
                                get_load_filter();
                                $("#btn_simpan_pem").prop('disabled', false);
                            } else {
                                alert(resp.message);
                            }

                        });

                }
            });

            $("#btn_cancel_pem").click(function() {
                get_load_filter();
            });

            function get_load_filter() {
                isResetting = true; // Tandai sedang mereset
                $("#form_pem").trigger('reset');
                $("#pem_nopin").val('').trigger('change');

                $("#pem_nopin").prop('disabled', false);
                $("#pem_perang").prop('disabled', false);
                $("#pem_jmlang").prop('disabled', false);

                $("#pem_nopin").select2('focus');
            }

        });

        function get_nopinjaman() {
            var nopin = $("#pem_nopin").val();
            var f_type = $("#pem_type").val();
            if (nopin == '' || nopin == null) {
                alert('Masukkan Nomer Pinjaman .');
            } else {
                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/transaksi/pembayaran/get_nopin',
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: {
                            'nopin': nopin
                        },
                        //processData: false,
                        //contentType: false,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            //alert(resp.message);
                            $("#pem_nobarcode").val(resp.datas[0].no_anggota);
                            $("#pem_nobarcode1").val(resp.datas[0].no_anggota);
                            $("#pem_nama").val(resp.datas[0].nama);
                            $("#pem_nama1").val(resp.datas[0].nama);

                            if (f_type == 'Angsuran') {
                                $("#pem_angke1").val(resp.angsuran_ke + 1);
                                $("#pem_angke").val(resp.angsuran_ke + 1);
                            } else if (f_type == 'Pelunasan') {
                                $("#pem_angke1").val(resp.datas[0].tenor);
                                $("#pem_angke").val(resp.datas[0].tenor);
                            } else {
                                return;
                            }

                            $("#pem_tenor").val(resp.datas[0].tenor);

                            $("#pem_perang").focus();
                        } else {
                            alert(resp.message);
                        }

                    });
            }
        }

        function get_load() {
            $("#pem_nopin").prop('disabled', true);
            $("#pem_perang").prop('disabled', true);
            $("#pem_jmlang").prop('disabled', true);
        }
    </script>
@endsection
