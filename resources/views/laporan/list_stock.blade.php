@extends('layout.main')
@section('content')

<div class="card">
<div class="card-header bg-secondary">
            <i class="fas fa-shopping-cart float-left"> </i>
            <h3 class="card-title" style="font-weight: bold; margin-left:1%"> List Stock Barang
            </h3>
        </div>


            <div class="modal-body">
                        <div class="row">
                            <label style="margin-left: 1%">End Stock : </label>
                            <input type="date" name="endDate" id="endDate" value="{{date('Y-m-d')}}" class="form-control col-md-2 rounded-0 ml-2">
                        </div>
        <br>
     
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap" id="tb_stock">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Spesifikasi</th>
                                <!-- <th>Supplier</th> -->
                                <th>In</th>
                                <th>Out</th>
                                <th>Stock Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <br>
                <div class="row">
                    <button id="btn_bm" name="btn_bm" class="form-control rounded-pill col-md-2">Detail Barang Masuk</button>
                    <button id="btn_bk" name="btn_bk" class="form-control rounded-pill col-md-2">Detail Barang Keluar</button>
                    <button id="btn_excel" name="btn_excel" class="form-control btn-success rounded-pill col-md-1">Excel</button>
                </div>
            </div>
            <!-- /.card-body -->

        <!-- /.card -->
    </div>

    <!-- Modal Tambah Stock (TS) -->
    <div class="modal fade" id="modal_tambah_stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-plus"> Tambah
                                Stock</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ts">
                        @csrf
                        <div class="row">
                            <div class="col col-md-12">
                                <strong> Tanggal Masuk</strong>
                                <input type="date" name="ts_tglmsk" id="ts_tglmsk" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Barang ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-9">
                                <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                                <strong> Kode Barang</strong>
                                <input type="hidden" id="ts_kode" name="ts_kode" class="form-control rounded-0"
                                    placeholder="Masukkan Kode Barang ." required>
                                <input type="text" id="ts_kode1" name="ts_kode1" class="form-control rounded-0"
                                    placeholder="Masukkan Kode Barang ." required disabled>
                            </div>
                            <div class="col col-md-3">
                                <strong> Qty In</strong>
                                <input type="text" id="ts_qty" name="ts_qty" class="form-control rounded-0"
                                    placeholder="Qty In ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-flat" id="btn_simpan_ts">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kurang Stock (KS) -->
    <div class="modal fade" id="modal_kurang_stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-minus"> Kurang
                                Stock</i></b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ks">
                        @csrf
                        <div class="row">
                            <div class="col col-md-12">
                                <input type="hidden" id="ks_stock" name="ks_stock">
                                <strong> Tanggal Keluar</strong>
                                <input type="date" name="ks_tglklr" id="ks_tglklr" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Barang ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-9">
                                <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                                <strong> Kode Barang</strong>
                                <input type="hidden" id="ks_kode" name="ks_kode" class="form-control rounded-0"
                                    placeholder="Masukkan Kode Barang ." required>
                                <input type="text" id="ks_kode1" name="ks_kode1" class="form-control rounded-0"
                                    placeholder="Masukkan Kode Barang ." required disabled>
                            </div>
                            <div class="col col-md-3">
                                <strong> Qty Out</strong>
                                <input type="text" id="ks_qty" name="ks_qty" class="form-control rounded-0"
                                    placeholder="Qty Out ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-flat" id="btn_simpan_ks">Simpan</button>
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

            var list_stock = $('#tb_stock').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: APP_URL + '/api/laporan/list_stock_barang',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    data: function(d) {
                        d.endDate = $("#endDate").val();
                    }
                },

                columnDefs: [{
                        targets: [0],
                        visible: true,
                        searchable: true
                    },
                    {
                        targets: [6],
                        data: null,
                        //defaultContent: "<button class='btn btn-success'>Complited</button>"
                        render: function(data, type, row, meta) {
                            if (data.stock <= 0) {
                                return "<a href = '#' style='font-size:14px' class = 'ts_tambah'> Tambah </a> || <a href = '#' style='font-size:14px' class = 'ts_minus' enabled> Kurang </a>";
                            } else {
                                return "<a href = '#' style='font-size:14px' class = 'ts_tambah'> Tambah </a> || <a href = '#' style='font-size:14px' class = 'ts_kurang'> Kurang </a>";
                            }

                        }
                    }
                ],

                columns: [{
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
                    // {
                    //     data: 'supplier',
                    //     name: 'supplier'
                    // },
                    {
                        data: 'qty_in',
                        name: 'qty_in',
                        /*render: function(data, type, row, meta) {
                            if (data > 0) {
                                return "<a href='' class='detailIn'>" + data + "</a>";
                            } else {
                                return data;
                            }
                        }*/
                    },
                    {
                        data: 'qty_out',
                        name: 'qty_out'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                ]
            });

            $("#endDate").change(function() {
                list_stock.ajax.reload();
            });

            $('#tb_stock').on('click', '.ts_tambah', function() {
                var data = list_stock.row($(this).parents('tr')).data();
                $("#ts_kode").val(data.kode);
                $("#ts_kode1").val(data.kode);
                get_ts();
                $("#modal_tambah_stock").modal('show');
            });

            $("#btn_simpan_ts").click(function() {
                var data = $("#form_ts").serializeArray();
                var tglmsk = $("#ts_tglmsk").val();
                var qty = $("#ts_qty").val();

                if (tglmsk == '' || tglmsk == null) {
                    alert('Tanggal Masuk harus diisi .');
                } else if (qty == '' || qty == null) {
                    alert('Qty harus terisi .');
                } else {
                    $("#btn_simpan_ts").prop('disabled', true);
                    $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/laporan/tambah_stock',
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
                                //location.reload();
                                $("#btn_simpan_ts").prop('disabled', false);
                                $("#modal_tambah_stock").modal('toggle');
                                list_stock.ajax.reload(null, false);
                            } else {
                                alert(resp.message);
                            }

                        });
                }

            });

            function get_ts() {
                $("#ts_tglmsk").val('');
                $("#ts_qty").val('');
            }

            $('#tb_stock').on('click', '.ts_minus', function() {
                alert('Stock 0 ');
            });

            $('#tb_stock').on('click', '.ts_kurang', function() {
                var data = list_stock.row($(this).parents('tr')).data();
                $("#ks_kode").val(data.kode);
                $("#ks_kode1").val(data.kode);
                $("#ks_stock").val(data.stock);
                get_ks();
                $("#modal_kurang_stock").modal('show');
            });

            $("#btn_simpan_ks").click(function() {
                var data = $("#form_ks").serializeArray();
                var tglklr = $("#ks_tglklr").val();
                var qty = $("#ks_qty").val();
                var sto = $("#ks_stock").val();

                if (tglklr == '' || tglklr == null) {
                    alert('Tanggal Masuk harus diisi .');
                } else if (qty == '' || qty == null) {
                    alert('Qty harus terisi .');
                } else {
                    $("#btn_simpan_ks").prop('disabled', true);
                    $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/laporan/kurang_stock',
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
                                //location.reload();
                                $("#btn_simpan_ks").prop('disabled', false);
                                $("#modal_kurang_stock").modal('toggle');
                                list_stock.ajax.reload(null, false);
                            } else {
                                alert(resp.message);
                                $("#btn_simpan_ks").prop('disabled', false);
                            }

                        });
                }

            });

            $("#btn_bm").click(function() {
                window.location.href = APP_URL + "/laporan/barang_masuk";
            });

            $("#btn_bk").click(function() {
                window.location.href = APP_URL + "/laporan/barang_keluar";
            });

            $("#btn_excel").click(function() {
               var endDate = $("#endDate").val();
                $.ajax({
                    url: APP_URL + '/api/laporan/stock_excel',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: 'POST',
                    dataType: 'json',
                    data:  {
                        'endDate': endDate
                    },

                    success: function(response) {
                        if (response.file) {
                            var fpath = response.file;
                            window.open(fpath, '_blank');
                        } else {
                            alert(response.message);
                        }
                    }
                })
            });

            function get_ks() {
                $("#ks_tglmsk").val('');
                $("#ks_qty").val('');
            }

        });
    </script>
@endsection
