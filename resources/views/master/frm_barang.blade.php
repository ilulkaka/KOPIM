@extends('layout.main')
@section('content')
    <div>
        <a href="#" id="btn_tambah" name="btn_tambah" style="size: 18px"><i class="fab fa-codepen"> Tambah Master
                Barang</i></a>
        <br>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col-12">
                    <h3 class="card-title"><u>Master Barang</u></h3>
                </div>
            </div>

            <div class="modal-body">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap" id="tb_barang">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>type</th>
                                <th>Supplier</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Modal Tambah Barang (TB) -->
    <div class="modal fade" id="modal_tambah_barang" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-user-plus"> Tambah
                                Barang</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_tb">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                                <strong> Kode Barang</strong>
                                <input type="text" id="tb_kode" name="tb_kode" class="form-control rounded-0"
                                    placeholder="Masukkan Kode Barang ." required>
                            </div>
                            <div class="col col-md-6">
                                <strong> Supplier</strong>
                                <input type="text" id="tb_supplier" name="tb_supplier" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Supplier ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong> Nama Barang</strong>
                                <input name="tb_nama" id="tb_nama" class="form-control rounded-0" placeholder="Masukkan Nama Barang ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-7">
                                <strong> Spesifikasi</strong>
                                <input type="type" id="tb_spesifikasi" name="tb_spesifikasi" class="form-control rounded-0"
                                    placeholder="Masukkan Spesifikasi Barang ." required>
                            </div>
                            <div class="col col-md-5">
                                <strong> Harga</strong>
                                <input type="type" id="tb_harga" name="tb_harga" class="form-control rounded-0"
                                    placeholder="Masukkan Harga Barang ." >
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_save_tp">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengguna (EP) -->
    <div class="modal fade" id="modal_edit_pengguna" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-user-edit"> Edit Data
                                Pengguna</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ep">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <input type="hidden" id="ep_id_pengguna" name="ep_id_pengguna">
                                <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-quote-left"> Email</i></strong>
                                <input type="text" id="ep_email" name="ep_email" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Anda ." required disabled>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-low-vision"> Password</i></strong>
                                <input type="password" id="ep_password" name="ep_password"
                                    class="form-control rounded-0" required>
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-adjust"> Level</i></strong>
                                <select name="ep_level" id="ep_level" class="form-control rounded-0" required>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Staff">Staff </option>
                                    <option value="Kasir">Kasir</option>
                                </select>
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_save_ep">Simpan</button>
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

            var list_barang = $('#tb_barang').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: '/master/list_barang',
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
                        targets: [7],
                        data: null,
                        //defaultContent: "<button class='btn btn-success'>Complited</button>"
                        render: function(data, type, row, meta) {
                            return "<a href = '#' style='font-size:14px' class = 'ta_edit'> Edit </a>";
                        }
                    }
                ],

                columns: [{
                        data: 'id_barang',
                        name: 'id_barang'
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'spesifikasi',
                        name: 'spesifikasi'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'supplier',
                        name: 'supplier'
                    },
                ]
            });

            $("#btn_tambah").click(function() {
                $("#modal_tambah_barang").modal('show');
            });


            $("#form_tb").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/master/tambah_barang',
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

            $('#tb_pengguna').on('click', '.ta_edit', function() {
                var data = list_pengguna.row($(this).parents('tr')).data();
                $("#ep_id_pengguna").val(data.id);
                $("#ep_email").val(data.email);
                $("#ep_password").val(data.password);
                $("#ep_level").val(data.role);
                $("#modal_edit_pengguna").modal('show');
            });

            $("#form_ep").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/master/edit_pengguna',
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
                            $("#modal_edit_pengguna").modal('toggle');
                            list_pengguna.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            /*$('#tb_anggota').on('click', '.ta_hapus', function() {
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
            });*/



        });
    </script>
@endsection
