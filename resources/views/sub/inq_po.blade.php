@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-header bg-secondary">
                <i class="fas fa-shopping-cart float-left"> </i>
                <h3 class="card-title" style="font-weight: bold; margin-left:1%"> List PO
                </h3>
            </div>
            <div class="modal-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" width="100%" id="tb_open_po">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th style="width: min-content;"><input type="checkbox" id="selectAll"></th>
                                <th>PO No</th>
                                <th>Item Cd</th>
                                <th>Nama</th>
                                <th>Spesifikasi</th>
                                <th>Qty In</th>
                                <th>Qty Out</th>
                                <th>Plan Qty</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <button type="button" class="btn btn-primary btn-flat" id="btn_proKirim" name="btn_proKirim"><u
                        style="color: white">
                        Proses Kirim</u></button>
                {{-- <button type="button" class="btn btn-primary btn-flat" id="btn_updSelected" name="btn_updSelected"><u
                        style="color: white">
                        Movement</u></button>
                <button type="button" class="btn btn-primary btn-flat" id="btn_penarikan" name="btn_penarikan"><u
                        style="color: white">
                        Penarikan Alat Ukur</u></button>
                <button class="btn btn-secondary btn-flat" id="btn-print" disabled>Print PDF</button>
                <button type="button" class="btn btn-success btn-flat" id="btn-excel" disabled>Download
                    Excel</button> --}}
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

            var l_po = $('#tb_open_po').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,

                ajax: {
                    url: APP_URL + '/api/sub/inq_openPo',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },

                columnDefs: [{
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: 8, // Index kolom qty_plan
                        width: '50px' // Sesuaikan lebar sesuai kebutuhan
                    },
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 1
                    },
                ],

                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                order: [
                    [1, 'asc']
                ],

                columns: [{
                        data: 'id_po',
                        name: 'id_po'
                    },
                    {
                        data: null,
                        defaultContent: ''
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
                        data: 'qty_out',
                        name: 'qty_out',
                        render: function(data, type, row) {
                            return data ? data :
                                0; // Mengatur default menjadi 0 jika null/undefined
                        }
                    },
                    {
                        data: null,
                        name: 'qty_plan',
                        render: function(data, type, row) {
                            // Menggunakan qty sebagai nilai awal qty_plan
                            return `<input type="number" class="form-control qty-plan-input" value="${row.qty}" data-id="${row.id}" data-qty="${row.qty}" />`;
                        }
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, row) {
                            if (!data) return 0; // Mengatur default menjadi 0 jika null/undefined
                            return new Intl.NumberFormat('id-ID', {
                                style: 'decimal',
                                minimumFractionDigits: 0
                            }).format(data);
                        }
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: function(data, type, row) {
                            if (!data) return 0; // Mengatur default menjadi 0 jika null/undefined
                            return new Intl.NumberFormat('id-ID', {
                                style: 'decimal',
                                minimumFractionDigits: 0
                            }).format(data);
                        }
                    },
                ],
            });

            $('#tb_open_po').on('draw.dt', function() {
                // Ketika DataTable selesai merender ulang, tambahkan event listener
                $('.qty-plan-input').on('input', function() {
                    var inputQtyPlan = $(this); // Input yang sedang diubah
                    var qtyPlan = parseFloat(inputQtyPlan.val()) ||
                        0; // Ambil nilai qty_plan yang dimasukkan
                    var qty = parseFloat(inputQtyPlan.data('qty')) ||
                        0; // Ambil nilai qty dari data-qty

                    // Periksa apakah qty_plan lebih besar dari qty
                    if (qtyPlan > qty) {
                        // Tampilkan alert jika qty_plan lebih besar dari qty
                        alert("Qty Plan tidak boleh lebih besar dari Qty.");
                        // Reset nilai qty_plan menjadi qty
                        inputQtyPlan.val(qty);
                    }
                });
            });


            // Event listener untuk pemilihan dan pembatalan pemilihan baris
            $('#tb_open_po').on('select.dt', function(e, dt, type, indexes) {
                var row = dt.rows(indexes).nodes().to$();
                row.addClass('selected-row');
            });

            $('#tb_open_po').on('deselect.dt', function(e, dt, type, indexes) {
                var row = dt.rows(indexes).nodes().to$();
                row.removeClass('selected-row');
            });

            // Event listener untuk checkbox di header
            $('#selectAll').change(function() {
                var checked = this.checked;
                $('.row-select-checkbox').prop('checked', checked);
                l_po.rows().select(checked);
            });

            // Event listener untuk checkbox di setiap baris
            $('#tb_selectRow').on('change', '.row-select-checkbox', function() {
                var allChecked = $('.row-select-checkbox:checked').length === l_po.rows().count();
                $('#selectAll').prop('checked', allChecked);
            });

            $('#btn_proKirim').on('click', function() {
                var selectedRows = l_po.rows({
                    selected: true
                }).data().toArray();

                // Ambil nilai id_po dan qty_plan dari baris yang dipilih
                var selectedData = selectedRows.map(function(row) {
                    // Cek input qty_plan berdasarkan id_po
                    var inputQtyPlan = $(`input[data-id="${row.id_po}"]`);
                    var planQty = parseFloat(inputQtyPlan.val()) || 0; // Ambil qty_plan dari input

                    console.log(
                    `ID: ${row.id_po}, Plan Qty (from input): ${planQty}`); // Pastikan nilai plan_qty diambil

                    return {
                        id: row.id_po,
                        plan_qty: planQty // Tambahkan plan_qty ke data
                    };
                });

                // Cek apakah data tidak kosong
                if (selectedData.length === 0) {
                    alert("Record tidak ada yang dipilih.");
                    return;
                }

                // Debugging untuk memastikan data yang akan dikirim
                console.log('Data yang akan dikirim:', selectedData);

                $.ajax({
                        url: APP_URL + '/api/sub/upd_kirimPO',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'selectedData': selectedData, // Kirim data id dan plan_qty
                        },
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            listMeas.ajax.reload(null, false); // Refresh DataTable
                            listMove.ajax.reload(null, false); // Refresh DataTable
                        } else {
                            alert(resp.message);
                        }
                    })
                    .fail(function(xhr, status, error) {
                        alert("Terjadi kesalahan saat mengirim data.");
                    });
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
