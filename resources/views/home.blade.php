@extends('layout.main')

@section('content')
    <h4>
        Anda Login sebagai
        <b>{{ Auth::user()->role }}</b>
    </h4>

    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ asset('/assets/img/userweb.png') }}"
                    alt="User profile picture">
            </div>
            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
            <p class="text-muted text-center">{{ $no_barcode }}</p>
            <input type="hidden" id="no_barcode" name="no_barcode" value="{{ $no_barcode }}">
            <input type="hidden" id="nik" name="nik" value="{{ Auth::user()->nik }}">
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b style="color:red">Tagihan Bulan ini</b> <a style="color:red"
                        class="float-right">{{ number_format($aktif[0]->nominal + $angsuran + $iuran, 0) }}</a>
                </li>
                <li class="list-group-item">
                    <i> - Barcode</i> <a class="float-right">{{ number_format($aktif[0]->nominal, 0) }}</a>
                </li>
                <li class="list-group-item">
                    <i> - Pinjaman, Angsuran Ke-{{ $angke }}</i> <a
                        class="float-right">{{ number_format($angsuran, 0) }}</a>
                </li>
                <li class="list-group-item">
                    <i> - Iuran KOPIM</i> <a class="float-right">{{ number_format($iuran, 0) }}</a>
                </li>

                <li class="list-group-item">
                    <b style="color:green">Simpanan</b> <a style="color:green" class="float-right"></a>
                </li>
                <li class="list-group-item">
                    <i> - Pokok</i> <a class="float-right">{{ number_format($simpok, 0) }}</a>
                </li>
                <li class="list-group-item">
                    <i> - Wajib</i> <a class="float-right">{{ number_format($simwa, 0) }}</a>
                </li>
                <li class="list-group-item">
                    <b>SHU Tahun {{ $thn }}</b> <a class="float-right" style="font-size:14px; color:red;"><i>
                            Under
                            Maintenance</i></a>
                </li>

            </ul>
            <button type="button" id="btn_detail" class="btn btn-primary btn-block rounded-pill"><b>Detail
                    Tagihan Barcode</b></button>
        </div>
    </div>

    <!-- Modal Detail (D) -->
    <div class="modal fade" id="modal_detail" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

                    <div class="row">
                        <div class="col col-md-5">
                            <strong> From</strong>
                            <input type="date" class="form-control rounded-0" id="tgl_awal"
                                value="{{ date('Y-m') . '-01' }}">
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
                    <div class="row" style="margin-top:-1%">
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

                $("#btn_reload").click(function() {
                    //listhk.ajax.reload();
                    get_detail();
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
                            data: function(d) {
                                d.nik = $("#nik").val();
                                d.tgl_awal = $("#tgl_awal").val();
                                d.tgl_akhir = $("#tgl_akhir").val();
                                d.no_barcode = $("#no_barcode").val();
                            },
                        },
                        'columnDefs': [{
                            "targets": 1,
                            "className": "text-right",
                        }],

                        columns: [{
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
