@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h4><b><i class="fas fa-dollar-sign"> Simpanan</i></b>
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="form_pin" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                            <div class="col col-md-3">
                                <strong><i class="fas fa-caret-square-down"> No Anggota</i></strong>
                                <select id="pin_no" name="pin_no" class="form-control rounded-0 select2" required>
                                    <option value="">Pilih No Anggota ...</option>
                                    @foreach ($no_anggota as $n)
                                        <option value="{{ $n->no_barcode }}">{{ $n->no_barcode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-md-9">
                                <strong><i class="fas fa-qrcode"> Tgl Simpan</i></strong>
                                <input type="date" id="sim_tglsim" name="sim_tglsim" class="form-control rounded-0"
                                    placeholder="Masukkan No Barcode ." required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong disabled><i class="fas fa-quote-left"> Nama</i></strong>
                                <input type="text" id="pin_nama1" name="pin_nama1" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required disabled>
                                <input type="hidden" id="pin_nama" name="pin_nama" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-9">
                                <strong><i class="fas fa-dollar-sign"> Jumlah Pinjaman</i></strong>
                                <input type="number" name="pin_jmlpin" id="pin_jmlpin"
                                    class="form-control form-control-lg rounded-0" required>
                            </div>
                            <div class="col col-md-3">
                                <strong><i class="fas fa-dollar-sign"> Tenor (Bulan)</i></strong>
                                <input type="number" name="pin_tenor" id="pin_tenor"
                                    class="form-control form-control-lg rounded-0" required>
                            </div>
                        </div>
                        <p></p>
                        <!--<div class="modal-footer">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </div>-->
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <!--<button type="button" class="btn btn-outline btn-flat float-left" id="btn_detail_pin"
                                    style="color: blue"><u> Detail
                                        Trx</u></button>
                                <button type="button" class="btn btn-outline btn-flat float-left" id="btn_download_pin"
                                    style="color: blue"><u>Download
                                        Trx</u></button>-->
                    <button type="button" class="btn btn-success btn-flat float-right" id="btn_simpan_pin">Simpan</button>
                </div>
            </div>
        </div>
        <div class="col col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-12">
                            <h3 class="card-title"><u>Data Pinjaman</u></h3>
                        </div>
                    </div>

                    <div class="modal-body">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover text-nowrap" id="tb_pinjaman">
                                <thead>
                                    <tr>
                                        <th>No Pinjaman</th>
                                        <th>Nama</th>
                                        <th>Pinjaman</th>
                                        <th>Tenor</th>
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

            $("#pin_no").change(function() {
                var no_anggota = $(this).children("option:selected").html();
                var nama = $(this).children("option:selected").val();
                //    var dept = $(this).children("option:selected").val();

                $("#pin_nobarcode").val(no_anggota);
                $("#pin_nama").val(nama);
                $("#pin_nama1").val(nama);
                //    $("#departemen").val(dept);
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

            var list_pinjaman = $('#tb_pinjaman').DataTable({
                processing: true,
                serverSide: true,
                searching: false,

                ajax: {
                    url: APP_URL + '/api/transaksi/pinjaman/list_pin',
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
                        data: 'no_pinjaman',
                        name: 'no_pinjaman'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jml_pinjaman',
                        name: 'jml_pinjaman',
                        render: $.fn.dataTable.render.number(',', '.')
                    },
                    {
                        data: 'tenor',
                        name: 'tenor'
                    },
                ]
            });

        });
    </script>
@endsection
