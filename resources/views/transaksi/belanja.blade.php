@extends('layout.main')
@section('content')

<div class="card card-info">
  <div class="card-header">
  <h4><b><i class="fas fa-cart-plus"> Transaksi</i></b></h4>
  </div>
  <div class="modal-body">
                    <form id="form_trx" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="role" name="role" value="{{ Auth::user()->name }}">
                        <div class="col col-md-2">
                                <strong><i class="fas fa-caret-square-down"> Kategori</i></strong>
                                <select id="trx_kategori" name="trx_kategori" class="form-control rounded-0"
                                     required>
                                    <option value="">Kategori ...</option>
                                <option value="Anggota">Anggota</option>    
                                <option value="Umum">Umum</option>
                                </select>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-4">
                                <strong><i class="fas fa-qrcode"> No Barcode</i></strong>
                                <input type="text" id="trx_nobarcode" name="trx_nobarcode" class="form-control rounded-0"
                                    placeholder="Masukkan No Barcode ." required>
                                    <input type="hidden" id="trx_nobarcode1" name="trx_nobarcode1" class="form-control rounded-0"
                                    placeholder="Masukkan No Barcode ." required>
                            </div>
                            <div class="col col-md-8">
                                <strong disabled><i class="fas fa-quote-left"> Nama</i></strong>
                                <input type="text" id="trx_nama1" name="trx_nama1" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required disabled>
                                    <input type="hidden" id="trx_nama" name="trx_nama" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-4">
                                <strong><i class="fas fa-dollar-sign"> Nominal</i></strong>
                                <input type="number" name="trx_nominal" id="trx_nominal" class="form-control form-control-lg rounded-0" required>
                            </div>
                            <div class="col col-md-4">
                                <br>
                                <button type="submit" class="btn btn-success btn-flat btn-lg" id="btn_simpan_trx">Simpan</button>
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                        </div>
                    </form>
                </div>
  <div class="card-footer text-muted">
    {{date('d-M-Y')}}
  </div>
</div>

@endsection

@section('script')
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#trx_kategori").focus();

            $("#trx_kategori").change(function(event) {
                var no_barcode = $("#trx_nobarcode").val('');
                if ($("#trx_kategori").val() == 'Anggota'){
                    $("#trx_nobarcode").removeAttr("disabled"); 
                    $("#trx_nama").val('');
                    $("#trx_nama1").val('');
                    $("#trx_nobarcode").val('');
                    $("#trx_nobarcode1").val('');
                    $("#trx_nobarcode").focus();
                } else if ($("#trx_kategori").val() == 'Umum') {
                    $("#trx_nobarcode").val('999999');
                    $("#trx_nobarcode1").val('999999');
                    $("#trx_nama").val('Client Umum');
                    $("#trx_nama1").val('Client Umum');
                    $("#trx_nominal").val('');
                    $("#trx_nominal").focus();
                    $("#trx_nobarcode").attr("disabled", "disabled"); 
                } else {
                    alert('Masukkan Type .');
                }
            });
            
            $("#trx_kategori").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#trx_nobarcode").focus();
                }
            });

            $("#trx_nobarcode").keypress(function(event){
                var no_barcode = $("#trx_nobarcode").val();
                if(event.keyCode === 13){
                    if (no_barcode == null || no_barcode == ''){
                        alert('Masukkan Nomer Barcode .');
                    } else {
                        $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/transaksi/get_barcode',
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {'no_barcode':no_barcode},
                            //processData: false,
                            //contentType: false,
                        })
                        .done(function(resp) {
                            if (resp.success) {
                                $("#trx_nama").val(resp.nama);
                                $("#trx_nama1").val(resp.nama);
                                $("#trx_nominal").val('');
                                $("#trx_nominal").focus();
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

            $("#form_trx").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

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
                        } else {
                            alert(resp.message);
                        }
                    })
            });



        });
    </script>
@endsection