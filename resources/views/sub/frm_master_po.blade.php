@extends('layout.main')
@section('content')
    <div>
        <a href="#" id="btn_tambah" name="btn_tambah" style="size: 18px"><i class="fab fa-codepen"> Tambah Master
                PO</i></a>
        <br>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col-12">
                    <h3 class="card-title"><u>Master PO</u></h3>
                </div>
            </div>

            <div class="modal-body">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap" id="tb_masterPO">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Item Cd</th>
                                <th>Nama</th>
                                <th>Spesifikasi</th>
                                <th>Harga</th>
                                <th>Uom</th>
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

    <!-- Modal Tambah Master PO (TMPO) -->
    <div class="modal fade" id="modal_tmpo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fab fa-opencart"> Tambah
                                Master PO</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_tmpo">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                                <strong> Item Cd</strong>
                                <input type="text" id="tmpo_itemCd" name="tmpo_itemCd" class="form-control rounded-0"
                                    placeholder="Masukkan Kode Barang ." required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong> Nama Barang</strong>
                                <input name="tmpo_nama" id="tmpo_nama" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Barang ." required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong> Spesifikasi</strong>
                                <input type="type" id="tmpo_spesifikasi" name="tmpo_spesifikasi"
                                    class="form-control rounded-0" placeholder="Masukkan Spesifikasi Barang .">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-8">
                                <strong> Harga</strong>
                                <input type="type" id="tmpo_harga" name="tmpo_harga" class="form-control rounded-0"
                                    placeholder="Masukkan Harga Barang ." required>
                            </div>
                            <div class="col col-md-4">
                                <strong> Uom</strong>
                                <select name="tmpo_uom" id="tmpo_uom" class="form-control" required>
                                    <option value="">Pilih...</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Rim">Rim</option>
                                    <option value="Psg">Pasang</option>
                                </select>
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

    <!-- Modal Edit Master PO (EMPO) -->
    <div class="modal fade" id="modal_empo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-user-edit"> Edit Master
                                PO</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_empo">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <input type="hidden" id="empo_id" name="empo_id">
                                <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-quote-left"> Item Cd</i></strong>
                                <input type="text" id="empo_itemCd" name="empo_itemCd" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Anda ." required disabled>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-low-vision"> Nama Barang</i></strong>
                                <input type="text" id="empo_nama" name="empo_nama" class="form-control rounded-0"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-low-vision"> Spesifikasi</i></strong>
                                <input type="text" id="empo_spesifikasi" name="empo_spesifikasi"
                                    class="form-control rounded-0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-8">
                                <strong><i class="fas fa-low-vision"> Harga</i></strong>
                                <input type="text" id="empo_harga" name="empo_harga" class="form-control rounded-0"
                                    required>
                            </div>
                            <div class="col col-md-4">
                                <strong><i class="fas fa-low-vision"> Satuan</i></strong>
                                <select name="empo_satuan" id="empo_satuan" class="form-control" required>
                                    <option value="">Pilih...</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Rim">Rim</option>
                                    <option value="Psg">Pasang</option>
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

            var l_masterPO = $('#tb_masterPO').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: APP_URL + '/api/sub/l_masterPO',
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
                        targets: [6],
                        data: null,
                        //defaultContent: "<button class='btn btn-success'>Complited</button>"
                        render: function(data, type, row, meta) {
                            return "<a href = '#' style='font-size:14px' class = 'ta_edit'> Edit </a>";
                        }
                    }
                ],

                columns: [{
                        data: 'id_master_po',
                        name: 'id_master_po'
                    },
                    {
                        data: 'item_cd',
                        name: 'item_cd'
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
                        data: 'satuan',
                        name: 'satuan'
                    },
                ]
            });

            $("#btn_tambah").click(function() {
                $("#modal_tmpo").modal('show');
            });


            $("#frm_tmpo").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/sub/add_masterPO',
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
                            $("#modal_tmpo").modal('toggle');
                            l_masterPO.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $('#tb_masterPO').on('click', '.ta_edit', function() {
                var data = l_masterPO.row($(this).parents('tr')).data();
                $("#empo_id").val(data.id_master_po);
                $("#empo_itemCd").val(data.item_cd);
                $("#empo_nama").val(data.nama);
                $("#empo_spesifikasi").val(data.spesifikasi);
                $("#empo_satuan").val(data.satuan);
                $("#empo_harga").val(data.harga);
                $("#empo_level").val(data.role);
                $("#modal_empo").modal('show');
            });

            $("#frm_empo").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/sub/upd_masterPO',
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
                            $("#modal_empo").modal('toggle');
                            l_masterPO.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });

        });
    </script>
@endsection
