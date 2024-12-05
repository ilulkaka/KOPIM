@extends('layout.main')
@section('content')
    @if (Auth::user()->role == 'Administrator')
        <h5 style="font-family: 'Times New Roman', Times, serif"> * Send ketika tanggal 20</h5>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body box-profile">
                    <form id="frm_st">
                        @csrf
                        <h3 class="profile-username text-center"><b> Send Telegram</b>
                        </h3>
                        <hr>

                        <div class="row">
                            <div class="col col-md-3"><label>Periode Transaksi</label></div>
                            <label class="col col-md-1" style="text-align: right">:</label>
                            <div class="col col-md-4">
                                <input type="date" class="form-control col-md-12 align-self-start"
                                    style="font-size: 18px" name="st_trxAwal" id="st_trxAwal" required>
                            </div>
                            <div class="col col-md-4">
                                <input type="date" class="form-control col-md-12 align-self-start"
                                    style="font-size: 18px" name="st_trxAkhir" id="st_trxAkhir" required>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 1%">
                            <div class="col col-md-3"><label>Periode Angsuran & Simpanan</label></div>
                            <label class="col col-md-1" style="text-align: right">:</label>
                            <div class="col col-md-4">
                                <input type="month" class="form-control col-md-12 align-self-start"
                                    style="font-size: 18px" name="st_perAngsuran" id="st_perAngsuran" required>
                            </div>
                            {{-- <div class="col col-md-4">
                                <input type="date" class="form-control col-md-12 align-self-start"
                                    style="font-size: 18px" name="st_angAkhir" id="st_angAkhir" required>
                            </div> --}}
                        </div>

                        {{-- <div class="row" style="margin-top: 1%">
                            <div class="col col-md-3"><label>Periode Simpanan</label></div>
                            <label class="col col-md-1" style="text-align: right">:</label>
                            <div class="col col-md-4">
                                <input type="month" class="form-control col-md-12 align-self-start"
                                    style="font-size: 18px" name="st_perSimpanan" id="st_perSimpanan" required>
                            </div>
                        </div> --}}
                        <hr>
                        <div class="row" style="margin-top: 1%">
                            <div class="col col-md-3"><label>Anggota</label></div>
                            <label class="col col-md-1" style="text-align: right">:</label>
                            <div class="col col-md-4">
                                <select name="st_anggota" id="st_anggota" class="form-control select2 col-md-12 btn-flat"
                                    required>
                                    <option value="">Pilih Anggota...</option>
                                    <option value="All">All</option>
                                    @foreach ($nama as $n)
                                        <option value="{{ $n->chat_id }}">{{ $n->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br style="padding-top: -1%">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary rounded-pill" id="btn_send"><i
                                    class="fab fa-telegram-plane"> Send</i></button>
                            <button type="button" class="btn btn-danger rounded-pill" data-dismiss="modal"><i
                                    class="far fa-window-close"> Close</i></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                // tags: true,

            })
        })

        $(document).ready(function() {

            $("#btn_sendTelegram").click(function() {
                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/laporan/rekapTransaksi',
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: {
                            'no_barcode': 'test'
                        },
                        //processData: false,
                        //contentType: false,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $("#frm_st").submit(function(e) {
                e.preventDefault();
                var datas = $(this).serialize();

                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/laporan/manual_sendTelegram',
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: datas,
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
            })

        });
    </script>
@endsection
