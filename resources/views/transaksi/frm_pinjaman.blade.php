@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col col-md-7">
            <div class="card card-info">
                <div class="card-header">
                    <h4><b><i class="fas fa-dollar-sign"> Pinjaman</i></b>
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="form_trx" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="role" name="role" value="{{ Auth::user()->name }}">
                            <div class="col col-md-3">
                                <strong><i class="fas fa-caret-square-down"> NIK</i></strong>
                                <select id="trx_nik" name="trx_nik" class="form-control rounded-0" required>
                                    <option value="">Pilih NIK ...</option>
                                </select>
                            </div>
                            <div class="col col-md-9">
                                <strong><i class="fas fa-qrcode"> No Barcode</i></strong>
                                <input type="text" id="trx_nobarcode1" name="trx_nobarcode1"
                                    class="form-control rounded-0" placeholder="Masukkan No Barcode ." required disabled>
                                <input type="hidden" id="trx_nobarcode" name="trx_nobarcode" class="form-control rounded-0"
                                    placeholder="Masukkan No Barcode ." required>
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
                            <div class="col col-md-9">
                                <strong><i class="fas fa-dollar-sign"> Jumlah Pinjaman</i></strong>
                                <input type="number" name="trx_nominal" id="trx_nominal"
                                    class="form-control form-control-lg rounded-0" required>
                            </div>
                            <div class="col col-md-3">
                                <strong><i class="fas fa-dollar-sign"> Tenor (Bulan)</i></strong>
                                <input type="number" name="trx_nominal" id="trx_nominal"
                                    class="form-control form-control-lg rounded-0" required>
                            </div>
                        </div>
                        <p></p>
                        <!--<div class="modal-footer">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </div>-->
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <button type="button" class="btn btn-outline btn-flat float-left" id="btn_detail_trx"
                        style="color: blue"><u> Detail
                            Trx</u></button>
                    <button type="button" class="btn btn-outline btn-flat float-left" id="btn_download_trx"
                        style="color: blue"><u>Download
                            Trx</u></button>
                    <button type="button" class="btn btn-success btn-flat float-right" id="btn_simpan_trx">Simpan</button>
                </div>
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


        });
    </script>
@endsection
