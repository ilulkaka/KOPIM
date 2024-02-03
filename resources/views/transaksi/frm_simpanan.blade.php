@extends('layout.main')
@section('content')

<!-- <div class="card"> -->
        <div class="card-header bg-secondary">
            <i class="fas fa-cart-plus float-left"> </i>
            <h3 class="card-title" style="font-weight: bold; margin-left:1%"> Entry Simpanan Anggota
            </h3>
        </div>

        <div class="row">
            
            <div class="col-md-7">
                <div class="card">

                    <form id="frm_selected">
                        @csrf
                    <div class="modal-body">
                    <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                        <div class="row">
                            <label style="margin-left: 1%">Periode : </label>
                            <input type="month" name="simPeriode" id="simPeriode" value="{{date('Y-m')}}" class="form-control col-md-4 rounded-0 ml-2">
                            <select name="simNull" id="simNull" class="form-control rounded-0 col-md-3 ml-2"
                                style="border: 1px solid #ced4da">
                                <option value="0">Not Sett</option>
                                <option value="1">Sett</option>
                            </select>
                            <select name="simJenis" id="simJenis" class="form-control rounded-0 col-md-3 ml-2"
                                                            style="border: 1px solid #ced4da" required>
                                                            <option value="Wajib">Wajib</option>
                                                            <option value="Pokok">Pokok</option>
                                                        </select>
                        </div>
                        <br>
                        <div class="row" style="margin-top:-3%">
                            <div class="col-md-8 d-flex ml-auto">
                                <input type="number" name="simJml" id="simJml" class="form-control col-md-8 rounded-0 "
                                    placeholder="Jumlah Simpanan" required>
                                <button id="sendSelected" class="form-control btn-success rounded-0 col-md-4 ">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
                    <div class="modal-body" style="margin-top: -1%">
                        <div class="table-responsive">
                            {{-- <button id="checkAll">Check All</button>
                            <button id="uncheckAll">Uncheck All</button> --}}
                            <table id="tb_selectRow" class="table table-hover text-nowrap" style="width: 100%">
                                <thead>
                                    <th style="width: min-content;"><input type="checkbox" id="selectAll"></th>
                                    <th style="width: min-content;">No Barcode</th>
                                    <th style="width: max-content;">Nama</th>
                                    <th style="width: max-content;">Jumlah</th>
                                    <th style="width: max-content;">Jenis</th>
                                    <th style="width: 10%;">Action</th>
                                </thead>
                            </table>
                        </div>
                        <div class="modal-footer">
    
                        </div>
                    </div>
                </div>
                </div>

            <div class="col-md-5">
                <div class="card">

                    <div class="modal-body">
                        <!-- <button id="btn_addRp" class="form-control rounded-pill col-md-5 ml-auto">Add Range Period</button> -->
                    <label for="">List Total Simpanan</label>
                    </div>
                    <div class="modal-body" style="margin-top: 10%;">
                    <table class="table table-hover text-nowrap" id="tb_simpanan">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Simpanan</th>
                                            <th>Jenis</th>
                                        </tr>
                                    </thead>
                                </table>
                        <div class="modal-footer">
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
    
    <!-- <div class="row">
        <div class="col col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h4><b><i class="fas fa-dollar-sign"> Simpanan</i></b>
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="form_sim" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="role" name="role" value="{{ Auth::user()->role }}">
                            <div class="col-md-7">
                                <strong><i class="fas fa-caret-square-down"> No Anggota</i></strong>
                                <select id="sim_nobarcode" name="sim_nobarcode" class="form-control rounded-0 select2" required>
                                    <option value="">Pilih No Anggota ...</option>
                                    @foreach ($no_anggota as $n)
                                        <option value="{{ $n->no_barcode }}">{{ $n->no_barcode }} - {{$n->nama}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <strong><i class="fas fa-qrcode"> Tgl Simpan</i></strong>
                                <input type="date" id="sim_tgl" name="sim_tgl" class="form-control rounded-0"
                                    placeholder="Masukkan No Barcode ." required>
                                    <input type="hidden" name="sim_nomer" id="sim_nomer">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-7">
                                <strong><i class="fas fa-caret-square-down"> Jenis Simpanan</i></strong>
                                <select name="sim_jenis" id="sim_jenis" class="form-control select2 rounded-0">
                                    <option value="">Pilih Jenis Simpanan ...</option>
                                    <option value="Wajib">Wajib</option>
                                    <option value="Pokok">Pokok</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <strong><i class="fas fa-dollar-sign"> Jml Simpanan</i></strong>
                                <input type="number" name="sim_jml" id="sim_jml"
                                    class="form-control rounded-0" required>
                            </div>
                        </div>
                        <p></p>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <button type="button" class="btn btn-success btn-flat float-right" id="btn_simpan_sim">Simpan</button>
                </div>
            </div>
        </div>
    </div> -->
@endsection

@section('script')
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>


    <script type="text/javascript">
        $(function() {

            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });
        $(document).ready(function() {

            $("#sim_nobarcode").change(function() {
                var no_anggota = $(this).children("option:selected").html();
                var nomer = $(this).children("option:selected").val();

                $("#sim_nobarcode").val(no_anggota);
                $("#sim_nomer").val(nomer);
                $("#sim_nama1").val(no_anggota);
                //    $("#departemen").val(dept);
            });

            $("#btn_simpan_sim").click(function() {
                var data = $("#form_sim").serializeArray();

                var no_anggota = $("#sim_nobarcode").val();
                var tglsim = $("#sim_tgl").val();
                var jenissim = $("#sim_jenis").val();
                var jmlsim = $("#sim_jml").val();

                if (no_anggota == '' || tglsim == '' || jmlsim == '' || jenissim ==
                    '') {
                    alert('Inputan harus terisi semua');
                } else {
                    $("#btn_simpan_pin").prop('disabled', true);
                    $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/transaksi/simpanan/simpan_sim',
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
                                $("#btn_simpan_sim").prop('disabled', false);
                            } else {
                                alert(resp.message);
                            }

                        });

                }
            });

            var selectRow = $('#tb_selectRow').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,

                ajax: {
                    url: APP_URL + '/api/transaksi/simpanan/selectRow',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    data: function(d) {
                        d.simPeriode = $("#simPeriode").val();
                        d.simNull = $("#simNull").val();
                        d.simJenis = $("#simJenis").val();
                    }
                },
                columnDefs: [{
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0 // Kolom yang ingin dijadikan multiple select
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child' // Seleksi berdasarkan kolom pertama
                },
                order: [
                    [1, 'asc']
                ], // Kolom untuk mengurutkan hasil seleksi

                columns: [
                    {
                        data: null,
                        defaultContent: ''
                    },
                    {
                        data: 'no_barcode',
                        name: 'no_barcode'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jml_simpanan',
                        name: 'jml_simpanan',
                        render: $.fn.dataTable.render.number(',', '.')
                    },
                    {
                        data: 'jenis_simpanan',
                        name: 'jenis_simpanan'
                    },
                ]
            });

            $("#simPeriode").change(function() {
                selectRow.ajax.reload();
            });

            $("#simNull").change(function() {
                selectRow.ajax.reload();
            });

            $("#simJenis").change(function() {
                selectRow.ajax.reload();
            });

                 // Event listener untuk checkbox di header
                 $('#selectAll').change(function() {
                var checked = this.checked;

                // Perbarui status seleksi untuk semua baris
                $('.row-select-checkbox').prop('checked', checked);

                // Perbarui seleksi di DataTables
                selectRow.rows().select(checked);
            });

            var list_simpanan = $('#tb_simpanan').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: APP_URL + '/api/transaksi/simpanan/list_sim',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                },

                columns: [
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jml_simpanan',
                        name: 'jml_simpanan',
                        render: $.fn.dataTable.render.number(',', '.')
                    },
                    {
                        data: 'jenis_simpanan',
                        name: 'jenis_simpanan'
                    },
                ]
            });

            $("#frm_selected").submit(function(e){
                e.preventDefault();
                // var data = $(this).serialize();
                var role = $("#role").val();
               var simJml = $("#simJml").val();
               var simPeriode = $("#simPeriode").val();
               var simJenis = $("#simJenis").val();

                var selectedRows = selectRow.rows({
                    selected: true
                }).data().toArray();

                // Ambil nilai NIK dari baris yang dipilih
                var selectedNoAnggota = selectedRows.map(function(row) {
                    return row.no_barcode;
                });

                if (simJml === '') {
                    alert("Jumlah hak Cuti harus diisi.");
                    return;
                }

                // Periksa apakah array selectedNIKs kosong
                if (selectedNoAnggota.length === 0) {
                    alert("No Anggota tidak ada yang dipilih.");
                    return; // Keluar dari fungsi jika tidak ada yang dipilih
                }

                $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/transaksi/simpanan/sendSelected',
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
    
                            data: {'simPeriode': simPeriode, 
                                'simJml':simJml, 
                                'selectedNoAnggota': selectedNoAnggota,
                            'simJenis': simJenis,
                        'role':role},
                            //processData: false,
                            //contentType: false,
                        })
                        .done(function(resp) {
                            if (resp.success) {
                                alert(resp.message);
                                selectRow.ajax.reload(null, false);
                                list_simpanan.ajax.reload(null, false);
                                $("#frm_selected").trigger('reset');
                            } else {
                                alert(resp.message);
                            }

                        });
            });

        });
    </script>
@endsection
