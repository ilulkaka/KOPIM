@extends('layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col-12">
                    <h3 class="card-title"><u>Detail Barang keluar</u></h3>
                </div>
            </div>

            <div class="modal-body">
                <!-- /.card-header -->
                <div class="row">
                    <div class="form-group col-md-2">
                        @csrf
                        <strong>Beginning</strong>
                        <input type="date" class="form-control rounded-0" id="tgl_awal" value="{{date('Y-m').'-01'}}">
                    </div>
                    <div class="form-group col-md-2">
                        <strong>Ending</strong>
                        <input type="date" class="form-control rounded-0" id="tgl_akhir" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="form-group col-md-1">
                        <strong>Reload</strong>
                        <br>
                        <button class="btn btn-primary btn-flat" id="btn_reload"><i class="fa fa-sync"></i></button>
                    </div>
                </div>
            </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_barang_keluar">
                        <thead>
                            <tr>
                                <th>Tgl Keluar</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Spesifikasi</th>
                                <!-- <th>Supplier</th> -->
                                <th>Out</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {

            var list_barang_keluar = $('#tb_barang_keluar').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: APP_URL + '/api/laporan/detail_bk',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                    d.tgl_awal = $("#tgl_awal").val();
                    d.tgl_akhir = $("#tgl_akhir").val();
                },
                    dataType: "json",
                },

                columnDefs: [{
                        targets: [0],
                        visible: true,
                        searchable: true
                    },
                ],

                columns: [
                    {
                        data: 'tgl_out',
                        name: 'tgl_out', width:'20px'
                    },
                    {
                        data: 'kode',
                        name: 'kode', width:'30px'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'spesifikasi',
                        name: 'spesifikasi'
                    },
                    // {
                    //     data: 'supplier',
                    //     name: 'supplier'
                    // },
                    {
                        data: 'qty_out',
                        name: 'qty_out', width:'15px'
                    },
                ]
            });

            $("#btn_reload").click(function () {
            list_barang_keluar.ajax.reload();
            });


        });
    </script>
@endsection
