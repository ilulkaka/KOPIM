@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h4><b><i class="fas fa-cart-plus"> Purchase Order</i></b>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <strong><i class="fas fa-caret-square-down"> Nomor PO</i></strong>
                            <input type="text" id="tdpo_nopo" name="tdpo_nopo" class="form-control rounded-0" required>
                        </div>
                    </div>
                    <form id="frm_tdpo">
                        @csrf
                        <input type="hidden" id="role" name="role" value="{{ Auth::user()->name }}">
                        <input type="hidden" id="role1" name="role1" value="{{ Auth::user()->role }}">
                        <hr>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-caret-square-down"> Item Cd</i></strong>
                                <input type="text" id="tdpo_itemCd" name="tdpo_itemCd" class="form-control rounded-0"
                                    required>
                            </div>
                        </div>
                        <p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-caret-square-down"> Nama Barang</i></strong>
                                <input type="text" id="tdpo_nama" name="tdpo_nama" class="form-control rounded-0"
                                    readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-caret-square-down"> Spesifikasi</i></strong>
                                <input type="text" id="tdpo_spesifikasi" name="tdpo_spesifikasi"
                                    class="form-control rounded-0" readonly>
                            </div>
                        </div>
                        <p>
                        <div class="row">
                            <div class="col col-md-3">
                                <strong><i class="fas fa-caret-square-down"> Qty</i></strong>
                                <input type="number" id="tdpo_qty" name="tdpo_qty" class="form-control rounded-0"
                                    required>
                            </div>
                            <div class="col col-md-4">
                                <strong><i class="fas fa-caret-square-down"> Harga</i></strong>
                                <input type="number" id="tdpo_harga" name="tdpo_harga" class="form-control rounded-0"
                                    readonly>
                            </div>
                            <div class="col col-md-5">
                                <strong><i class="fas fa-caret-square-down"> Nouki</i></strong>
                                <input type="date" id="tdpo_nouki" name="tdpo_nouki" class="form-control rounded-0"
                                    required>
                            </div>
                        </div>
                        <br>
                    </form>
                    <div class="card-footer text-muted d-flex justify-content-end">
                        <button type="button" id="btn_updPO" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-8">
            <div class="card-header bg-secondary">
                <i class="fas fa-shopping-cart float-left"> </i>
                <h3 class="card-title" style="font-weight: bold; margin-left:1%"> List PO
                </h3>
            </div>


            <div class="modal-body">
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap" width="100%" id="tb_po">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>PO No</th>
                                <th>Item Cd</th>
                                <th>Nama</th>
                                <th>Spesifikasi</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <br>
                <div class="row">
                    <button id="btn_excel" name="btn_excel"
                        class="form-control btn-success rounded-pill col-md-1">Excel</button>
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
            $("#tdpo_nopo").focus();

            var l_po = $('#tb_po').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,

                ajax: {
                    url: APP_URL + '/api/sub/l_po',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.no_po = $("#tdpo_nopo").val();
                    },
                },

                columnDefs: [{
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    // {
                    //     targets: [5],
                    //     data: null,
                    //     //defaultContent: "<button class='btn btn-success'>Complited</button>"
                    //     render: function(data, type, row, meta) {
                    //         return "<a href = '#' style='font-size:14px' class = 'ta_edit'> Edit </a>";
                    //     }
                    // }
                ],

                columns: [{
                        data: 'id_po',
                        name: 'id_po'
                    },
                    {
                        data: 'nomor_po',
                        name: 'nomor_po'
                    },
                    {
                        data: 'item_cd',
                        name: 'item_cd'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'spesifikasi',
                        name: 'spesifikasi'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                ],
            });

            $("#tdpo_nopo").keypress(function(event) {
                var nopo = $("#tdpo_nopo").val();
                if (event.keyCode === 13) {
                    if (nopo == '' || nopo == null) {
                        alert("Masukkan Nomor PO .");
                        return false;
                    } else {
                        $("#tdpo_itemCd").focus();
                        l_po.ajax.reload();
                    }
                }
            });

            $("#tdpo_itemCd").keypress(function(event) {
                var itemCd = $("#tdpo_itemCd").val();
                if (event.keyCode === 13) {
                    if (itemCd == null || itemCd == '') {
                        alert('Masukkan Item Cd .');
                        return false;
                    } else {
                        $.ajax({
                                type: "POST",
                                url: APP_URL + '/api/sub/get_datasMasterPO',
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                data: {
                                    "datas": itemCd,
                                },
                            })
                            .done(function(resp) {
                                if (resp.success) {
                                    $("#tdpo_nama").val(resp.datas.nama);
                                    $("#tdpo_spesifikasi").val(resp.datas.spesifikasi);
                                    $("#tdpo_harga").val(resp.datas.harga);

                                    $("#tdpo_qty").focus();
                                } else {
                                    alert(resp.message);
                                    $("#tdpo_itemCd").focus();
                                }
                            });
                    }
                }
            });

            $("#tdpo_qty").keypress(function(event) {
                var qty = $("#tdpo_qty").val();
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1; //January is 0!
                var yyyy = today.getFullYear();
                var sekarang = yyyy + "-" + mm + "-" + dd;

                if (event.keyCode === 13) {
                    if (qty == '' || qty == null) {
                        alert("Masukkan Qty .");
                        $("#tdpo_qty").focus();
                        return false;
                    } else {
                        $("#tdpo_nouki").focus();
                        $("#tdpo_nouki").val(sekarang);
                    }
                }
            });

            $("#btn_updPO").click(function() {
                // e.preventDefault();
                var nopo = $("#tdpo_nopo").val();
                var itemCd = $("#tdpo_itemCd").val();
                var qty = $("#tdpo_qty").val();
                var nouki = $("#tdpo_nouki").val();

                if (nopo == '' || nopo == null) {
                    alert("Masukkan Nomor PO .");
                    $("#tdpo_nopo").focus();
                    return false;
                } else if (itemCd == '' || itemCd == null) {
                    alert("Masukkan Item Code .");
                    $("#tdpo_itemCd").focus();
                    return false;
                } else if (qty == '' || qty == null) {
                    alert("Masukkan Qty .");
                    $("#tdpo_qty").focus();
                    return false;
                } else if (nouki == '' || nouki == null) {
                    alert("Masukkan Nouki .");
                    $("#tdpo_nouki").focus();
                    return false;
                } else {
                    $.ajax({
                            type: "POST",
                            url: APP_URL + '/api/sub/ins_dataPO',
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                'nopo': nopo,
                                'itemCd': itemCd,
                                'qty': qty,
                                'nouki': nouki
                            },
                        })
                        .done(function(resp) {
                            if (resp.success) {
                                alert(resp.message);
                                $("#frm_tdpo").trigger('reset');
                                $("#tdpo_nopo").focus();
                                l_po.ajax.reload();
                            } else {
                                alert(resp.message);
                            }
                        })
                }
            })
        });
    </script>
@endsection
