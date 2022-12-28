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
                    <form id="form_pin" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="role" name="role" value="{{ Auth::user()->name }}">
                            <div class="col col-md-3">
                                <strong><i class="fas fa-caret-square-down"> NIK</i></strong>
                                <select id="pin_nik" name="pin_nik" class="form-control rounded-0" required>
                                    <option value="">Pilih NIK ...</option>
                                </select>
                            </div>
                            <div class="col col-md-9">
                                <strong><i class="fas fa-qrcode"> Tgl Realisasi</i></strong>
                                <input type="date" id="pin_tglreal" name="pin_tglreal"
                                    class="form-control rounded-0" placeholder="Masukkan No Barcode ." required>
                                <input type="hidden" id="pin_nobarcode" name="pin_nobarcode" class="form-control rounded-0"
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
                    <button type="button" class="btn btn-outline btn-flat float-left" id="btn_detail_pin"
                        style="color: blue"><u> Detail
                            Trx</u></button>
                    <button type="button" class="btn btn-outline btn-flat float-left" id="btn_download_pin"
                        style="color: blue"><u>Download
                            Trx</u></button>
                    <button type="button" class="btn btn-success btn-flat float-right" id="btn_simpan_pin">Simpan</button>
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
