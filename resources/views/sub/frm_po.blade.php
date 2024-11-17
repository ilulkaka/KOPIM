@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4><b><i class="fas fa-cart-plus"> Purchase Order</i></b>
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="frm_tdpo" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="role" name="role" value="{{ Auth::user()->name }}">
                            <input type="hidden" id="role1" name="role1" value="{{ Auth::user()->role }}">

                            {{-- @if (Auth::user()->role == 'Administrator')
                                <div class="col col-md-6">
                                    <strong><i class="fas fa-caret-square-down"> Tgl Transaksi</i></strong>
                                    <input type="date" id="tgl_trx" name="tgl_trx" class="form-control rounded-0">
                                </div>
                            @endif --}}

                            <div class="col col-md-2">
                                <strong><i class="fas fa-caret-square-down"> Nomor PO</i></strong>
                                <input type="text" id="tdpo_nopo" name="tdpo_nopo" class="form-control rounded-0">
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col col-md-2">
                                <strong><i class="fas fa-caret-square-down"> Item Cd</i></strong>
                                <input type="text" id="tdpo_itemCd" name="tdpo_itemCd" class="form-control rounded-0">
                            </div>
                            <div class="col col-md-2">
                                <strong><i class="fas fa-caret-square-down"> Nama Barang</i></strong>
                                <input type="text" id="tdpo_namaBarang" name="tdpo_namaBarang"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <strong><i class="fas fa-caret-square-down"> Spesifikasi</i></strong>
                                <input type="text" id="tdpo_spesifikasi" name="tdpo_spesifikasi"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-1">
                                <strong><i class="fas fa-caret-square-down"> Qty</i></strong>
                                <input type="number" id="tdpo_qty" name="tdpo_qty" class="form-control rounded-0">
                            </div>
                            <div class="col col-md-2">
                                <strong><i class="fas fa-caret-square-down"> Harga</i></strong>
                                <input type="number" id="tdpo_harga" name="tdpo_harga" class="form-control rounded-0">
                            </div>
                            <div class="col col-md-2">
                                <strong><i class="fas fa-caret-square-down"> Nouki</i></strong>
                                <input type="date" id="tdpo_nouki" name="tdpo_nouki" class="form-control rounded-0">
                            </div>
                        </div>
                        <input type="hidden" name="trx_kategori" id="trx_kategori">
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
    </div>


    <div class="card-header bg-secondary">
        <i class="fas fa-shopping-cart float-left"> </i>
        <h3 class="card-title" style="font-weight: bold; margin-left:1%"> List PO
        </h3>
    </div>


    <div class="modal-body">
        <div class="row">
            <label style="margin-left: 1%">End Stock : </label>
            <input type="date" name="endDate" id="endDate" value="{{ date('Y-m-d') }}"
                class="form-control col-md-2 rounded-0 ml-2">
        </div>
        <br>

        <div class="card-body table-responsive p-0">

            <table class="table table-hover text-nowrap" id="tb_po">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Item Cd</th>
                        <th>Nama</th>
                        <th>Spesifikasi</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <br>
        <div class="row">
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
    <div class="modal fade" id="modal_kurang_stock" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/easy-number-separator/js/easy-number-separator.js') }}"></script>


    <script type="text/javascript">
        easyNumberSeparator({
            selector: '.number-separator',
            separator: ',',
            resultInput: '#trx_nominal',
        })
        $(document).ready(function() {




        });
    </script>
@endsection
