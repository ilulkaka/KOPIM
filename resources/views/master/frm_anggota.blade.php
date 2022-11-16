@extends('layout.main')
@section('content')
    <div>
        <a href="#" id="btn_tambah" name="btn_tambah" style="size: 18px"><i class="fas fa-user-plus"> Tambah
                Anggota</i></a>
        <br>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col-12">
                    <h3 class="card-title"><u>List Anggota</u></h3>
                </div>
            </div>

            <div class="modal-body">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap" id="tb_anggota">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>No KTP</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn btn-secondary btn-flat" id="btn-print">Print</button>
                    <button type="submit" class="btn btn-success btn-flat" id="btn-excel">Download Excel</button>
                    <button type="button" class="btn btn-primary btn-flat" id="btn-report"><a
                            href="{{ url('hse/hhkyrekap') }}" style="color: white;">
                            Rekap
                        </a></button>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var list_anggota = $('#tb_anggota').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: '/master/list_anggota',
                    type: "POST",
                    dataType: "json",
                },

                columnDefs: [{
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    /*{
                        targets: [8],
                        data: null,
                        //defaultContent: "<button class='btn btn-success'>Complited</button>"
                        render: function(data, type, row, meta) {
                            return "<button class='btn btn-primary btn-xs'>Detail</button>";
                        }
                    }*/
                ],

                columns: [{
                        data: 'id_anggota',
                        name: 'id_anggota'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    }
                ]
            });

            $("#btn_tambah").click(function() {
                alert('test');
            })


        });
    </script>
@endsection
