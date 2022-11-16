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

    <!-- Modal Tambah Anggota (TA) -->
    <div class="modal fade" id="modal_tambah_anggota" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="exampleModalLongTitle"><b><i class="fas fa-user-plus"> Tambah Anggota</i></b> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ta">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-file-prescription"> NIK</i></strong>
                                <input type="text" id="ta_nik" name="ta_nik"
                                    class="form-control rounded-0" placeholder="NIK Perusahaan">
                                </div>
                                <div class="col col-md-6">
                                    <strong padding-top="20%"><i class="fas fa-file-signature"> No KTP</i>
                                    </strong>
                                    <input type="text" id="ta_noktp" name="ta_noktp"
                                        class="form-control rounded-0 col-md-12" placeholder="Masukkan Nomer KTP">
                                </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-quote-left"> Nama</i></strong>
                                <input type="text" id="ta_nama" name="ta_nama" class="form-control rounded-0" placeholder="Masukkan Nama Anda .">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-location-arrow"> alamat</i></strong>
                                    <textarea name="ta_alamat" id="ta_alamat" class="form-control rounded-0" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-location-arrow"> No Telp</i></strong>
                                <input type="tel" id="ta_notelp" name="ta_notelp" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}"
                                    class="form-control rounded-0" placeholder="0811-2453-6789">
                            </div>
                        </div>
                        <p></p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_save_ta">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_ktp',
                        name: 'no_ktp'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'no_telp',
                        name: 'no_telp'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ]
            });

            $("#btn_tambah").click(function(){
                $("#modal_tambah_anggota").modal('show');
            });

            $("#btn_save_ta").click(function(){
                alert('test');
            });

            $("#form_ta").submit(function(){
                //e.preventDefault();
                //var data = $(this).serialize();
                var data = 'test';
                alert(data);
                $.ajax({
                        type: "POST",
                        url: 'master/tambah_anggota',
                        dataType: "json",
                        data: {'data':data},
                        //processData: false,
                        //contentType: false,
                    })
                    /*.done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            location.reload();
                        } else {
                            alert(resp.message);
                        }
                    })*/
            });



        });
    </script>
@endsection
