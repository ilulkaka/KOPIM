@extends('layout.main')
@section('content')
    @if (Auth::user()->role == 'Administrator')
        <button type="button" id="btn_test" name="btn_test">Test</button>
    @endif
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {

            $("#btn_test").click(function() {
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

        });
    </script>
@endsection
