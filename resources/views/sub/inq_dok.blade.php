@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-header bg-secondary">
                <i class="fas fa-shopping-cart float-left"> </i>
                <h3 class="card-title" style="font-weight: bold; margin-left:1%"> List No Dokumen
                </h3>
            </div>

            <div class="col-md-12">
                <div class="row d-flex align-items-center">

                </div>
            </div>

            <hr>
            <div class="modal-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" width="100%" id="tb_noDokumen">
                        <thead>
                            <tr>
                                <th>Tanggal Kirim</th>
                                <th>No Dokumen</th>
                                <th>Cetak</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>
    {{-- <script src="{{ asset('/assets/plugins/easy-number-separator/js/easy-number-separator.js') }}"></script> --}}

    <script type="text/javascript">
        $(document).ready(function() {

            var l_noDokumen = $('#tb_noDokumen').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,

                ajax: {
                    url: APP_URL + '/api/sub/inq_noDok',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },

                columnDefs: [{
                    targets: [2],
                    data: null,
                    render: function(data, type, row, meta) {
                        return "<a href = '#' style='font-size:14px' class = 'inq_sj'> Surat Jalan </a>  ||  <a href = '#' style='font-size:14px' class = 'inq_inv'> Invoice </a>";
                    }
                }, ],

                columns: [{
                        data: 'tgl_kirim',
                        name: 'tgl_kirim'
                    },
                    {
                        data: 'no_dokumen',
                        name: 'no_dokumen'
                    },
                ],
            });

            $('#tb_noDokumen').on('click', '.inq_sj', function() {
                var data = l_noDokumen.row($(this).parents('tr')).data();
                window.open(APP_URL + "/sub/cetak_sj/" + data.no_dokumen, '_blank');
            });

            $('#tb_noDokumen').on('click', '.inq_inv', function() {
                var data = l_noDokumen.row($(this).parents('tr')).data();
                window.open(APP_URL + "/sub/cetak_inv/" + data.no_dokumen, '_blank');
            });


        });
    </script>
@endsection
