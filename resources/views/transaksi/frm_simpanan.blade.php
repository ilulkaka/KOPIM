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
                    <form id="form_sim" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                            <div class="col-md-7">
                                <strong><i class="fas fa-caret-square-down"> No Anggota</i></strong>
                                <select id="sim_nobarcode" name="sim_nobarcode" class="form-control rounded-0 select2" required>
                                    <option value="">Pilih No Anggota ...</option>
                                    @foreach ($no_anggota as $n)
                                        <option value="{{ $n->no_barcode }}">{{ $n->no_barcode }} - {{$n->nama}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <strong><i class="fas fa-qrcode"> Tgl Simpan</i></strong>
                                <input type="date" id="sim_tgl" name="sim_tgl" class="form-control rounded-0"
                                    placeholder="Masukkan No Barcode ." required>
                                    <input type="hidden" name="sim_nomer" id="sim_nomer">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-7">
                                <strong><i class="fas fa-caret-square-down"> Jenis Simpanan</i></strong>
                                <select name="sim_jenis" id="sim_jenis" class="form-control select2 rounded-0">
                                    <option value="">Pilih Jenis Simpanan ...</option>
                                    <option value="Wajib">Wajib</option>
                                    <option value="Pokok">Pokok</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <strong><i class="fas fa-dollar-sign"> Jml Simpanan</i></strong>
                                <input type="number" name="sim_jml" id="sim_jml"
                                    class="form-control rounded-0" required>
                            </div>
                        </div>
                        <p></p>
                        <!--<div class="modal-footer">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </div>-->
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <button type="button" class="btn btn-success btn-flat float-right" id="btn_simpan_sim">Simpan</button>
                </div>
            </div>
        </div>
        <div class="col col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-12">
                            <h3 class="card-title"><u>Data Simpanan</u></h3>
                        </div>
                    </div>

                    <div class="modal-body">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover text-nowrap" id="tb_simpanan">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Simpanan</th>
                                        <th>Jenis</th>
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

            $("#sim_nobarcode").change(function() {
                var no_anggota = $(this).children("option:selected").html();
                var nomer = $(this).children("option:selected").val();

                $("#sim_nobarcode").val(no_anggota);
                $("#sim_nomer").val(nomer);
                $("#sim_nama1").val(no_anggota);
                //    $("#departemen").val(dept);
            });

            $("#btn_simpan_sim").click(function() {
                var data = $("#form_sim").serializeArray();

                var no_anggota = $("#sim_nobarcode").val();
                var tglsim = $("#sim_tgl").val();
                var jenissim = $("#sim_jenis").val();
                var jmlsim = $("#sim_jml").val();

                if (no_anggota == '' || tglsim == '' || jmlsim == '' || jenissim ==
                    '') {
                    alert('Inputan harus terisi semua');
                } else {
                    $("#btn_simpan_pin").prop('disabled', true);
                    $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/transaksi/simpanan/simpan_sim',
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
                                $("#btn_simpan_sim").prop('disabled', false);
                            } else {
                                alert(resp.message);
                            }

                        });

                }
            });

            var list_simpanan = $('#tb_simpanan').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: APP_URL + '/api/transaksi/simpanan/list_sim',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                },

                columns: [
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jml_simpanan',
                        name: 'jml_simpanan',
                        render: $.fn.dataTable.render.number(',', '.')
                    },
                    {
                        data: 'jenis_simpanan',
                        name: 'jenis_simpanan'
                    },
                ]
            });

        });
    </script>
@endsection
