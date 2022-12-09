@extends('layout.main')
@section('content')
    <div>
        <a href="#" id="btn_tambah" name="btn_tambah" style="size: 18px"><i class="fas fa-user-plus"> Tambah
                Anggota</i></a>
        <br>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col-12">
                    <h3 class="card-title"><u>List Anggota</u></h3>
                </div>
            </div>

            <div class="modal-body">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap" id="tb_anggota">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>No Barcode</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>No KTP</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!--<div class="card-footer">
                        <button class="btn btn-secondary btn-flat" id="btn-print">Print</button>
                        <button type="submit" class="btn btn-success btn-flat" id="btn-excel">Download Excel</button>
                        <button type="button" class="btn btn-primary btn-flat" id="btn-report"><a
                                href="{{ url('hse/hhkyrekap') }}" style="color: white;">
                                Rekap
                            </a></button>
                    </div>-->

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Modal Tambah Anggota (TA) -->
    <div class="modal fade" id="modal_tambah_anggota" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-user-plus"> Tambah
                                Anggota</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ta">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-file-prescription"> NIK</i></strong>
                                <input type="text" id="ta_nik" name="ta_nik" class="form-control rounded-0"
                                    placeholder="NIK Perusahaan" required>
                            </div>
                            <div class="col col-md-6">
                                <strong padding-top="20%"><i class="fas fa-file-signature"> No KTP</i>
                                </strong>
                                <input type="text" id="ta_noktp" name="ta_noktp"
                                    class="form-control rounded-0 col-md-12" placeholder="Masukkan Nomer KTP" required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-quote-left"> Nama</i></strong>
                                <input type="text" id="ta_nama" name="ta_nama" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Anda ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-location-arrow"> alamat</i></strong>
                                <textarea name="ta_alamat" id="ta_alamat" class="form-control rounded-0" cols="30" rows="2" required></textarea>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-phone"> No Telp</i></strong>
                                <input type="tel" id="ta_notelp" name="ta_notelp" class="form-control rounded-0"
                                    placeholder="0811-2453-6789" required>
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_save_ta">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Anggota (EA) -->
    <div class="modal fade" id="modal_edit_anggota" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-user-edit"> Edit Data
                                Anggota</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ea">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-file-prescription"> NIK</i></strong>
                                <input type="text" id="ea_nik" name="ea_nik" class="form-control rounded-0"
                                    placeholder="NIK Perusahaan" required>
                                <input type="hidden" id="ea_id_anggota" name="ea_id_anggota">
                                <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                            </div>
                            <div class="col col-md-6">
                                <strong padding-top="20%"><i class="fas fa-file-signature"> No KTP</i>
                                </strong>
                                <input type="text" id="ea_noktp" name="ea_noktp"
                                    class="form-control rounded-0 col-md-12" placeholder="Masukkan Nomer KTP" required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-quote-left"> Nama</i></strong>
                                <input type="text" id="ea_nama" name="ea_nama" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Anda ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-location-arrow"> alamat</i></strong>
                                <textarea name="ea_alamat" id="ea_alamat" class="form-control rounded-0" cols="30" rows="2" required></textarea>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-phone"> No Telp</i></strong>
                                <input type="tel" id="ea_notelp" name="ea_notelp" class="form-control rounded-0"
                                    placeholder="0811-2453-6789" required>
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-adjust"> Status</i></strong>
                                <select name="ea_status" id="ea_status" class="form-control rounded-0" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Off">Off </option>
                                </select>
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_save_ea">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Anggota (HA) -->
    <div class="modal fade" id="modal_hapus_anggota" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-trash"> Hapus Data
                                Anggota</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ha">
                        @csrf
                        <h5>Apakah Data berikut akan dihapus ?</h5>
                        <div class="row">
                            <div class="col col-md-6">
                                <input type="hidden" id="ha_id_anggota" name="ha_id_anggota">
                                <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong> No Barcode</strong>
                                <input type="text" id="ha_nobarcode" name="ha_nobarcode"
                                    class="form-control rounded-0" disabled>
                            </div>
                            <div class="col col-md-12">
                                <strong> Nama</i></strong>
                                <input type="text" id="ha_nama" name="ha_nama" class="form-control rounded-0"
                                    disabled>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong> Status</i></strong>
                                <input type="text" name="ha_status" id="ha_status" class="form-control rounded-0"
                                    disabled>
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger btn-flat" id="btn_save_ha">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            /*$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });*/

            var list_anggota = $('#tb_anggota').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: APP_URL + '/api/master/list_anggota',
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
                    },
                    {
                        targets: [8],
                        data: null,
                        //defaultContent: "<button class='btn btn-success'>Complited</button>"
                        render: function(data, type, row, meta) {
                            return "<a href = '#' style='font-size:14px' class = 'ta_edit'> Edit </a> || <a href = '#' style='font-size:14px' class ='ta_hapus' > Hapus </a>";
                        }
                    }
                ],

                columns: [{
                        data: 'id_anggota',
                        name: 'id_anggota'
                    },
                    {
                        data: 'no_barcode',
                        name: 'no_barcode'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_ktp',
                        name: 'no_ktp'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'no_telp',
                        name: 'no_telp'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ]
            });

            $("#btn_tambah").click(function() {
                $("#modal_tambah_anggota").modal('show');
            });


            $("#form_ta").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/master/tambah_anggota',
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
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $('#tb_anggota').on('click', '.ta_edit', function() {
                var data = list_anggota.row($(this).parents('tr')).data();
                $("#ea_id_anggota").val(data.id_anggota);
                $("#ea_nama").val(data.nama);
                $("#ea_nik").val(data.nik);
                $("#ea_noktp").val(data.no_ktp);
                $("#ea_alamat").val(data.alamat);
                $("#ea_notelp").val(data.no_telp);
                $("#ea_status").val(data.status);
                $("#modal_edit_anggota").modal('show');
            });

            $("#form_ea").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/master/edit_anggota',
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
                            $("#modal_edit_anggota").modal('toggle');
                            list_anggota.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $('#tb_anggota').on('click', '.ta_hapus', function() {
                var data = list_anggota.row($(this).parents('tr')).data();
                $("#ha_id_anggota").val(data.id_anggota);
                $("#ha_nama").val(data.nama);
                $("#ha_noktp").html(data.no_ktp);
                $("#ha_nobarcode").val(data.no_barcode);
                $("#ha_status").val(data.status);
                $("#modal_hapus_anggota").modal('show');
            });

            $("#form_ha").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/master/hapus_anggota',
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
                            $("#modal_hapus_anggota").modal('toggle');
                            list_anggota.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });



        });
    </script>
@endsection
