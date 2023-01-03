@extends('layout.main')

@section('content')
    <h4>
        Anda Login sebagai 
        <b>{{ Auth::user()->role }}</b>
    </h4>

    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{asset('/assets/img/userweb.png')}}" alt="User profile picture">
            </div>
            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
            <p class="text-muted text-center">{{ Auth::user()->nik }}</p>
            <input type="hidden" id="nik" name="nik" value="{{ Auth::user()->nik }}">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                    <b>Tagihan Bulan ini</b> <a class="float-right">{{number_format(($aktif + $angsuran->jml_angsuran),0)}}</a>
                    </li>
                    <li class="list-group-item">
                    <i> - Barcode</i> <a class="float-right">{{number_format($aktif,0)}}</a>
                    </li>
                    <li class="list-group-item">
                    <i> - Pinjaman</i> <a class="float-right">{{number_format($angsuran->jml_angsuran,0)}}</a>
                    </li>
                    <li class="list-group-item">
                    <b>SHU Tahun {{$thn}}</b> <a class="float-right" style="font-size:14px; color:red;"><i> Under Maintenance</i></a>
                    </li>
                </ul>
                <button type="button" id="btn_detail" class="btn btn-primary btn-block btn-flat"><b>Detail Tagihan</b></button>
        </div>
    </div>

    <!-- Modal Detail (D) -->
    <div class="modal fade" id="modal_detail" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                        <table class="table table-hover text-nowrap" width="100%" id="tb_detail">
                            <thead>
                                <tr>
                                    <th>Tanggal Trx</th>
                                    <th style="text-align:center">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="1" style="text-align:left; ">TOTAL</th>
                                    <th style="text-align:right; font-size: large;"></th>
                                </tr>
                            </tfoot>
                        </table>
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

            $("#btn_detail").click(function() {
                get_detail();
                $("#modal_detail").modal('show');
            });

            function get_detail() {
                var nik = $("#nik").val();
                var list_detail = $('#tb_detail').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    searching: false,
                    lengthChange: false,

                    ajax: {
                        url: APP_URL + '/api/home/detail_tag',
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        data :{'nik':nik},
                    },
                    'columnDefs': [
                        {
                        "targets": 1,
                        "className": "text-right",
                        }
                    ],

                    columns: [
                        {
                            data: 'tgl_trx',
                            name: 'tgl_trx'
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
                            .column(0)
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Total over this page
                        TotalNominal = api
                            .column(1, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $(api.column(1).footer()).html(
                            TotalNominal.toLocaleString("en-US")
                        );

                    }
                });
            }



        });
    </script>
@endsection