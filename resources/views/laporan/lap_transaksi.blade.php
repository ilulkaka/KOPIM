@extends('layout.main')
@section('content')
    @if (Auth::user()->role == 'Administrator')
        <h5 style="font-family: 'Times New Roman', Times, serif"> * Send ketika tanggal 20</h5>
        <button type="button" id="btn_sendTelegram" name="btn_sendTelegram" class="form-control btn-flat col-md-2"><i
                class="fab fa-telegram-plane"> Send
                Telegram</i></button>

        <h5 style="font-family: 'Times New Roman', Times, serif"> </h5>
        <button type="button" id="btn_testsend" name="btn_testsend" class="form-control btn-flat col-md-2"><i
                class="fab fa-telegram-plane"> TEST</i></button>
    @endif
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
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

            $("#btn_testsend").click(function() {
                $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/testsend',
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
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

        });
    </script>
@endsection
