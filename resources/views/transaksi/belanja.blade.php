@extends('layout.main')
@section('content')
    <style>
        @import url(https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
        @import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);


        fieldset,
        label {
            margin: 0;
            padding: 0;
        }

        /****** Style Star Rating Widget *****/

        .rating {
            border: 1px;
            margin-right: 50px;
        }

        .myratings {

            font-size: 30px;
            color: green;
        }

        .rating>[id^="star"] {
            display: none;
        }

        .rating>label:before {
            margin: 5px;
            font-size: 5em;
            font-family: FontAwesome;
            display: inline-block;
            content: "\f005";
        }

        .rating>.half:before {
            content: "\f089";
            position: center;
        }

        .rating>label {
            color: #ddd;
            float: right;
        }

        /***** CSS Magic to Highlight Stars on Hover *****/

        .rating>[id^="star"]:checked~label,
        /* show gold star when clicked */
        .rating:not(:checked)>label:hover,
        /* hover current star */
        .rating:not(:checked)>label:hover~label {
            color: orange;
        }

        /* hover previous stars in list */

        .rating>[id^="star"]:checked+label:hover,
        /* hover current star when changing rating */
        .rating>[id^="star"]:checked~label:hover,
        .rating>label:hover~[id^="star"]:checked~label,
        /* lighten current selection */
        .rating>[id^="star"]:checked~label:hover~label {
            color: rebeccapurple;
        }

        .btn:hover {
            color: darkred;
            background-color: white !important
        }

        .reset-option {
            display: none;
            font-family: FontAwesome;
        }

        .reset-button {
            margin: 6px 12px;
            background-color: rgb(255, 255, 255);
            text-transform: uppercase;
        }

        .custom-margin {
            margin-left: 50px;
            /* Sesuaikan nilai sesuai kebutuhan */
        }
    </style>

    <div class="row">
        <div class="col-md-7">
            <div class="card card-info">
                <div class="card-header">
                    <h4><b><i class="fas fa-cart-plus"> Transaksi</i></b>
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="form_trx" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="role" name="role" value="{{ Auth::user()->name }}">
                            <input type="hidden" id="role1" name="role1" value="{{ Auth::user()->role }}">

                            @if (Auth::user()->role == 'Administrator')
                                <div class="col col-md-6">
                                    <strong><i class="fas fa-caret-square-down"> Tgl Transaksi</i></strong>
                                    <input type="date" id="tgl_trx" name="tgl_trx" class="form-control rounded-0">
                                </div>
                            @endif
                            <!--<div class="col col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <strong><i class="fas fa-caret-square-down"> Kategori</i></strong>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <select id="trx_kategori" name="trx_kategori" class="form-control rounded-0" required>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <option value="">Kategori ...</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <option value="Anggota">Anggota</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <option value="Umum">Umum</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </select>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>-->
                        </div>
                        <!-- radio -->
                        <br>
                        <div class="form-group">
                            <label class="form-label fw-bold mb-2">Status Anggota:</label>
                            <div class="form-check d-flex align-items-center">
                                <div class="me-4">
                                    <input class="form-check-input" type="radio" name="r1" id="r_ang"
                                        value="Anggota" checked>
                                    <label class="form-check-label" for="r_ang">Anggota</label>
                                </div>
                                <div class="custom-margin">
                                    <input class="form-check-input" type="radio" name="r1" id="r_non"
                                        value="Non Anggota">
                                    <label class="form-check-label" for="r_non">Non Anggota</label>
                                </div>
                            </div>
                            <input type="hidden" name="fil" id="fil" value="">
                        </div>
                        <hr>
                        <input type="hidden" name="trx_kategori" id="trx_kategori">
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-qrcode"> No Barcode</i></strong>
                                <input type="password" id="trx_nobarcode" name="trx_nobarcode"
                                    class="form-control rounded-0" placeholder="Masukkan No Barcode ." required>
                                <input type="hidden" id="trx_nobarcode1" name="trx_nobarcode1"
                                    class="form-control rounded-0" placeholder="Masukkan No Barcode ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong disabled><i class="fas fa-quote-left"> Nama</i></strong>
                                <input type="text" id="trx_nama1" name="trx_nama1"
                                    style="font-size: 24px; font-weight:bold" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required disabled>
                                <input type="hidden" id="trx_nama" name="trx_nama" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required>
                                <input type="hidden" name="trx_nik" id="trx_nik">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-dollar-sign"> Nominal</i></strong>
                                <input type="text" name="result_input" id="result_input"
                                    class="number-separator form-control form-control-lg rounded-0"
                                    placeholder="Masukkan Nominal..."
                                    style="font-size: 30px; color:blue; font-weight: bold " required>
                                <input type="hidden" id="trx_nominal" name="trx_nominal">
                            </div>
                            <div class="col col-md-6">
                                <br>
                                <button type="button" class="btn btn-app float-right" id="btn_cancel_trx">
                                    <i class="far fa-window-close"></i> Cancel</button>
                                <button type="button" class="btn btn-app btn-success float-right" id="btn_simpan_trx">
                                    <i class="fas fa-save"></i> Save</button>
                                {{-- <button type="button" class="btn btn-danger btn-flat float-right"
                                    id="btn_cancel_trx">Cancel</button> --}}
                                {{-- <button type="button" class="btn btn-success btn-flat float-right mr-2"
                                    id="btn_simpan_trx">Simpan</button> --}}
                            </div>

                        </div>
                        <p></p>
                        <!--<div class="modal-footer">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </div>-->
                    </form>
                </div>
                <div class="card-footer text-muted">
                    {{-- <button type="button" class="btn btn-outline btn-flat float-left" id="btn_upd_telegram"
                        style="color: blue"><u> Update Telegram</u></button> --}}
                    <button type="button" class="btn btn-outline btn-flat float-right" id="btn_detail_trx"
                        style="color: blue"><u> Detail
                            Trx</u></button>
                    <button type="button" class="btn btn-outline btn-flat float-right" id="btn_download_trx"
                        style="color: blue"><u>Download
                            Trx</u></button>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><u> Transaksi Hari ini</u></span>
                    <div class="row">
                        <div class="col col-md-4">
                            <span class="info-box-number">Anggota</span>
                            <span class="info-box-number">{{ number_format($hasil_anggota->nominal, 0) }}</span>
                        </div>
                        <div class="col col-md-4">
                            <span class="info-box-number">Umum</span>
                            <span class="info-box-number">{{ number_format($hasil_umum->nominal, 0) }}</span>
                        </div>
                    </div>
                </div>
                <!-- /.info-box-content -->
            </div>
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><u> Total Transaksi</u></span>
                    <span class="info-box-number"><b
                            style="font-size: 24px; color:red">{{ number_format($hasil_total, 0) }}</b></span>
                </div>
                <!-- /.info-box-content -->
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
                    <div class="row">
                        <div class="col col-md-5">
                            <strong> From</strong>
                            <input type="date" class="form-control rounded-0" id="tgl_awal"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col col-md-5">
                            <strong> End</strong>
                            <input type="date" class="form-control rounded-0" id="tgl_akhir"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col col-md-2">
                            <strong> Refs</strong>
                            <button class="btn btn-primary rounded-pill col-md-12 " id="btn_reload"><i
                                    class="fa fa-sync"></i></button>
                        </div>
                    </div>
                    <br>

                    <div class="table-responsive">
                        <table id="tb_detail_trx" class="table table-hover text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Tanggal Trx</th>
                                    <th>No Barcode</th>
                                    <th>Nama</th>
                                    <th>Nominal</th>
                                    <th>Act</th>
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
                            <input type="date" id="tgl_awal1" name="tgl_awal1" class="form-control rounded-0"
                                required>
                        </div>

                        <div class="col col-md-6">
                            <strong><i class="fas fa-date"> Ending</i></strong>
                            <input type="date" id="tgl_akhir1" name="tgl_akhir1" class="form-control rounded-0"
                                required>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <div class="row">

                            <button type="button" id="btn_preview" name="btn_preview"
                                class="form-control col-md-4 rounded-pill">Preview</button>
                            <button type="button" id="btn_download" name="btn_download"
                                class="form-control col-md-4 rounded-pill"> Download </button>
                            <button type="button" data-dismiss="modal" class="form-control col-md-4 rounded-pill"> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Transaksi (ET) -->
    <div class="modal fade" id="modal_edit_trx" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="exampleModalLongTitle"><b>Edit Transaksi</b> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_et">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-file-prescription"> Tgl Transaksi</i></strong>
                                <input type="hidden" name="et_id" id="et_id">
                                <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                                <input type="text" id="et_tgl" name="et_tgl" class="form-control rounded-0"
                                    disabled>
                                <p>
                                </p>
                                <strong padding-top="20%"><i class="fas fa-file-signature"> No Barcode</i>
                                </strong>
                                <input type="text" id="et_no" name="et_no"
                                    class="form-control rounded-0 col-md-12" disabled>
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-location-arrow"> Nama</i></strong>
                                <input type="text" id="et_nama" name="et_nama" class="form-control rounded-0"
                                    disabled>
                                <p></p>
                                <strong padding-top="20%"><i class="fas fa-file-signature"> Nominal</i>
                                </strong>
                                <input type="number" id="et_nominal" name="et_nominal"
                                    class="form-control rounded-0 col-md-12"
                                    style="font-size: 24px; color:red; font-weight:bold">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" id="btn_save_et">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Sending Mail (SM) -->
    <div class="modal fade" id="modal_sending_mail" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLongTitle"><b><i class="fa fa-qrcode"> Sending Mail</i></b>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_sm">
                        @csrf
                        <input type="hidden" id="m_tgl_awal" name="m_tgl_awal" class="form-control rounded-0">
                        <input type="hidden" id="m_tgl_akhir" name="m_tgl_akhir" class="form-control rounded-0">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="col col-md-12">
                                    <h10>Send To :</h10>
                                </div>
                                <div class="form-group">
                                    <input type="mail" id="sm_to" name="sm_to" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="col col-md-12">
                                    <h10>CC :</h10>
                                </div>
                                <div class="form-group">
                                    <input type="mail" id="sm_cc" name="sm_cc" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_send">Send</button>
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


            get_load();

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 50000
            });

            var fg = 0;

            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    type: 'success',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });

            /*$("#trx_kategori").change(function(event) {
                var no_barcode = $("#trx_nobarcode").val('');
                if ($("#trx_kategori").val() == 'Anggota') {
                    $("#trx_nobarcode").removeAttr("disabled");
                    $("#trx_nama").val('');
                    $("#trx_nama1").val('');
                    $("#trx_nik").val('');
                    $("#trx_nobarcode").val('');
                    $("#trx_nobarcode1").val('');
                    $("#trx_nobarcode").focus();
                } else if ($("#trx_kategori").val() == 'Umum') {
                    $("#trx_nobarcode").val('999999');
                    $("#trx_nobarcode1").val('999999');
                    $("#trx_nama").val('Client Umum');
                    $("#trx_nama1").val('Client Umum');
                    $("#trx_nik").val('CU00');
                    $("#trx_nominal").val('');
                    $("#trx_nominal").focus();
                    $("#trx_nobarcode").attr("disabled", "disabled");
                } else {
                    alert('Masukkan Type .');
                }
            });*/

            $("#r_ang, #r_non").change(function() {
                if ($("#r_ang").is(":checked")) {
                    $("#trx_nobarcode").removeAttr("disabled");
                    $("#trx_nama").val('');
                    $("#trx_nama1").val('');
                    $("#trx_nik").val('');
                    $("#trx_nobarcode").val('');
                    $("#trx_nobarcode1").val('');
                    $("#trx_kategori").val('Anggota');
                    $("#trx_nobarcode").focus();
                } else {
                    $("#trx_nobarcode").val('999999');
                    $("#trx_nobarcode1").val('999999');
                    $("#trx_nama").val('Client Umum');
                    $("#trx_nama1").val('Client Umum');
                    $("#trx_nik").val('CU00');
                    $("#trx_nominal").val('');
                    $("#result_input").val('');
                    $("#trx_kategori").val('Umum');
                    $("#result_input").focus();
                    $("#trx_nobarcode").attr("disabled", "disabled");
                }
            })

            $("#trx_kategori").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#trx_nobarcode").focus();
                }
            });

            $("#trx_nobarcode").keypress(function(event) {
                var no_barcode = $("#trx_nobarcode").val();
                if (event.keyCode === 13) {
                    if (no_barcode == null || no_barcode == '') {
                        alert('Masukkan Nomer Barcode .');
                    } else {
                        $.ajax({
                                type: "POST",
                                url: APP_URL + '/api/transaksi/get_barcode',
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                data: {
                                    'no_barcode': no_barcode
                                },
                                //processData: false,
                                //contentType: false,
                            })
                            .done(function(resp) {
                                if (resp.success) {
                                    $("#trx_nama").val(resp.nama);
                                    $("#trx_nama1").val(resp.nama);
                                    $("#trx_nik").val(resp.nik);
                                    $("#result_input").val('');
                                    $("#trx_nominal").val('');
                                    $("#result_input").focus();
                                    $("#trx_nobarcode").prop("readonly", true);
                                } else {
                                    alert(resp.message);
                                    $("#trx_nama").val('');
                                    $("#trx_nama1").val('');
                                    $("#trx_nobarcode").val('');
                                    $("#trx_nobarcode").focus();
                                }
                            })
                    }
                }
            });

            $("#trx_nobarcode").keydown(function(e) {
                var no_barcode = $("#trx_nobarcode").val();
                var code = (e.keyCode || e.which);
                if (code === 9) {
                    if (no_barcode == null || no_barcode == '') {
                        alert('Masukkan Nomer Barcode .');
                        $("#trx_nobarcode").val('');
                        $("#trx_nobarcode").focus();
                    } else {
                        $.ajax({
                                type: "POST",
                                url: APP_URL + '/api/transaksi/get_barcode',
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                data: {
                                    'no_barcode': no_barcode
                                },
                                //processData: false,
                                //contentType: false,
                            })
                            .done(function(resp) {
                                if (resp.success) {
                                    $("#trx_nama").val(resp.nama);
                                    $("#trx_nama1").val(resp.nama);
                                    $("#trx_nik").val(resp.nik);
                                    $("#result_input").val('');
                                    $("#trx_nominal").val('');
                                    $("#result_input").focus();
                                    $("#trx_nobarcode").prop("readonly", true);
                                } else {
                                    alert(resp.message);
                                    $("#trx_nama").val('');
                                    $("#trx_nama1").val('');
                                    $("#trx_nobarcode").val('');
                                    $("#trx_nobarcode").focus();
                                }
                            })
                    }
                }
            });

            $("#result_input").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#btn_simpan_trx").focus();
                }
            });

            //$("#form_trx").submit(function(e) {
            //    e.preventDefault();
            $("#btn_simpan_trx").click(function() {
                var data = $("#form_trx").serializeArray();
                //var data = $(this).serialize();
                var kategori = $("#trx_kategori").val();
                var nobarcode = $("#trx_nobarcode").val();
                var nominal = $("#trx_nominal").val();
                var result = $("#result_input").val();
                if (kategori == '' || nobarcode == '' || result == '') {
                    alert('Inputan harus terisi semua');
                } else {
                    $("#btn_simpan_trx").prop('disabled', true);
                    $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/transaksi/trx_simpan',
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
                                /*$("#trx_kategori").focus();*/
                                $("#btn_simpan_trx").prop('disabled', false);
                                get_load();
                            } else {
                                alert(resp.message);
                            }

                        });
                }
            });

            /*$("#btn_upd_telegram").click(function() {
                // Melakukan permintaan GET ke route getUpdates
                $.ajax({
                    url: '/getUpdates', // URL route yang mengarah ke TransaksiController@getUpdates
                    type: 'GET', // Method permintaan
                    success: function(response) {
                        // Tangani respons sukses dari server
                        alert('Update berhasil!'); // Beri tahu pengguna jika sukses
                    },
                    error: function(xhr, status, error) {
                        // Tangani jika terjadi error
                        alert('Terjadi kesalahan.'); // Beri tahu pengguna jika error
                    }
                });
            });*/


            $("#btn_detail_trx").click(function() {
                // get_detail_trx();
                $("#modal_detail_trx").modal('show');
            });

            var list_detail_trx = $('#tb_detail_trx').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: true,
                lengthChange: false,

                ajax: {
                    url: APP_URL + '/api/transaksi/detail_trx',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    data: function(d) {
                        d.tgl_awal = $("#tgl_awal").val();
                        d.tgl_akhir = $("#tgl_akhir").val();
                    },
                },

                columnDefs: [{
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: [5],
                        data: null,
                        // width: '10%',
                        render: function(data, type, row, meta) {
                            return "<a href = '#' style='font-size:14px' class = 'editTrx'> Edit </a> || <a href = '#' style='font-size:14px' class ='delTrx' > Deleted </a>";
                        }
                    },
                ],

                columns: [{
                        data: 'id_trx_belanja',
                        name: 'id_trx_belanja'
                    },
                    {
                        data: 'tgl_trx',
                        name: 'tgl_trx'
                    },
                    {
                        data: 'no_barcode',
                        name: 'no_barcode'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        width: '40%'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal',
                        render: $.fn.dataTable.render.number(',', '.', 0, '')
                    },
                ],
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(1)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    TotalNominal = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    $(api.column(4).footer()).html(
                        TotalNominal.toLocaleString("en-US")
                    );

                }
            });

            $('#tb_detail_trx').on('click', '.editTrx', function() {
                var datas = list_detail_trx.row($(this).parents('tr')).data();
                $("#et_id").val(datas.id_trx_belanja);
                $("#et_tgl").val(datas.tgl_trx);
                $("#et_no").val(datas.no_barcode);
                $("#et_nama").val(datas.nama);
                $("#et_nominal").val(datas.nominal);

                $('#modal_edit_trx').modal('show');
            });

            $('#tb_detail_trx').on('click', '.delTrx', function() {
                var datas = list_detail_trx.row($(this).parents('tr')).data();
                var id_trx = datas.id_trx_belanja;
                var role = $("#role1").val();

                var conf = confirm("Apakah data dengan " + "\n" + "Nama      : " + datas.nama + "\n" +
                    "Nominal  : " + datas.nominal + "\n" + "\n" + "akan dihapus?");

                if (conf) {
                    $.ajax({
                            type: "POST",
                            url: APP_URL + "/api/transaksi/del_trx",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content'),
                            },
                            data: {
                                'id_trx': id_trx,
                                'role': role
                            },
                        })
                        .done(function(resp) {
                            if (resp.success) {
                                alert(resp.message);
                                list_detail_trx.ajax.reload(null, false);
                            } else {
                                alert(resp.message);
                            }
                        })
                }
            });

            $("#btn_reload").click(function() {
                // get_detail_trx();
                list_detail_trx.ajax.reload();
            });

            $("#btn_download_trx").click(function() {
                $("#modal_download_trx").modal('show');
            });

            $("#btn_cancel_trx").click(function() {
                get_load();
            });

            $("#btn_download").click(function() {
                var format = $("#dot_format").val();
                var tgl_awal = $("#tgl_awal1").val();
                var tgl_akhir = $("#tgl_akhir1").val();

                if (format == '' || tgl_awal == '' || tgl_akhir == '') {
                    alert('Kolom Harus terisi semua .');
                } else if (format == 'Pdf') {
                    alert('Format PDF Belum tersedia .');
                } else {
                    $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/transaksi/download',
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content'),
                        },
                        data: {
                            'format': format,
                            'tgl_awal': tgl_awal,
                            'tgl_akhir': tgl_akhir
                        },
                        //processData: false,
                        //contentType: false,
                        success: function(response) {
                            if (response.file) {
                                var fpath = response.file;
                                window.open(fpath, '_blank');
                                $("#modal_download_trx").modal('hide');

                                $("#modal_sending_mail").modal('show');
                                var m_tgl_awal = $("#m_tgl_awal").val(tgl_awal);
                                var m_tgl_akhir = $("#m_tgl_akhir").val(tgl_akhir);
                                //location.reload();
                            } else {
                                alert(response.message);
                            }
                        }
                    })
                }

            });

            $("#form_et").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                //alert(data);
                $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/transaksi/edit_trx",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content'),
                        },
                        data: data,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $('#modal_edit_trx').modal('toggle');
                            list_detail_trx.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $("#form_sm").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/transaksi/send_mail",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content'),
                        },
                        data: data,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            location.reload();
                            //$('#modal_sending_mail').modal('toggle');
                            // list_detail_trx.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });


            function get_load() {
                $("#r_ang").is(":checked");
                $("#trx_nobarcode").removeAttr("disabled");
                $("#trx_nama").val('');
                $("#trx_nama1").val('');
                $("#trx_nik").val('');
                $("#trx_nobarcode").val('');
                $("#trx_nobarcode1").val('');
                $("#trx_kategori").val('Anggota');
                $("#trx_nominal").val('');
                $("#result_input").val('');
                $("#trx_nobarcode").focus();
            }



        });
    </script>
@endsection
