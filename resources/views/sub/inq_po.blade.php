@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-header bg-secondary">
                <i class="fas fa-shopping-cart float-left"> </i>
                <h3 class="card-title" style="font-weight: bold; margin-left:1%"> List PO
                </h3>
            </div>
            <br>
            <div class="col-md-12">
                <div class="row d-flex align-items-center">
                    <!-- Nomor Dokument dan Button Ambil Nomor -->
                    <div class="col-md-6 d-flex">
                        <input type="text" name="l_noDok" id="l_noDok" class="form-control col-md-4 mr-2"
                            placeholder="Nomor Dokument" />
                        <input type="hidden" name="l_tgl" id="l_tgl" value="{{ date('Y-m-d') }}"
                            class="form-control col-md-4 mr-2" />
                        <input type="hidden" id="l_getNoDok" name="l_getNoDok" class="form-control col-md-2 mr-2">

                        <button class="btn btn-danger rounded-pill col-md-4" id="btn_cetak" hidden>
                            <i class="fas fa-print"></i> Cetak Dokumen
                        </button>
                        <button class="btn btn-primary rounded-pill col-md-3" id="btn_ambilNomor">
                            <i class="fab fa-pushed"></i> Ambil Nomor
                        </button>

                    </div>

                    <!-- Status PO dan Button Reload -->
                    <div class="col-md-6 d-flex justify-content-end">
                        <select name="l_statusPO" id="l_statusPO" class="form-control col-md-4 mr-2">
                            <option value="Open">Open</option>
                            <option value="Closed">Closed</option>
                        </select>
                        <button class="btn btn-primary rounded-pill col-md-2" id="btn_reload">
                            <i class="fas fa-sync-alt"></i> Reload
                        </button>
                    </div>
                </div>
            </div>

            <hr>
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

            $("#l_noDok").prop('hidden', false); // Tampilkan l_noDok
            $("#l_tgl").prop('hidden', true); // Sembunyikan l_tgl
            $("#l_getNoDok").prop('hidden', true);
            $("#btn_cetak").prop('hidden', true);

            $("#btn_reload").click(function() {
                l_po.ajax.reload();
                var l_statusPO = $("#l_statusPO").val();

                // Logika untuk menyembunyikan/memunculkan elemen
                if (l_statusPO == 'Closed') {
                    $("#l_noDok").prop('hidden', true); // Sembunyikan l_noDok
                    $("#btn_ambilNomor").prop('hidden', true);

                    // Ubah input l_tgl menjadi type="date" dan tampilkan
                    $("#l_tgl").attr('type', 'date');
                    $("#l_getNoDok").attr('type', 'text');
                    $("#btn_cetak").attr('type', 'date');
                    $("#l_tgl").prop('hidden', false);
                    $("#l_getNoDok").prop('hidden', false);
                    $("#btn_cetak").prop('hidden', false);
                } else {
                    $("#l_noDok").prop('hidden', false); // Tampilkan l_noDok
                    $("#btn_ambilNomor").prop('hidden', false);

                    // Ubah input l_tgl menjadi type="hidden"
                    $("#l_tgl").attr('type', 'hidden');
                    $("#l_getNoDok").attr('type', 'hidden');
                    $("#btn_cetak").prop('hidden', true);
                }
            });

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
                    data: function(d) {
                        d.statusPO = $("#l_statusPO").val();
                    },
                },

                columnDefs: [{
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: [12],
                        data: null,
                        //defaultContent: "<button class='btn btn-success'>Complited</button>"
                        render: function(data, type, row, meta) {
                            if (data.status_po == 'Closed') {
                                return "<a href = '#' style='font-size:14px' class = 'inq_detail'> Detail </a>";
                            } else {
                                return '';
                            }

                        }
                    },
                    {
                        targets: 6, // Index kolom qty_plan
                        width: '50px' // Sesuaikan lebar sesuai kebutuhan
                    },
                    {
                        targets: 7,
                        width: '50px'
                    },
                    {
                        targets: 8,
                        width: '50px'
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
                        data: 'temp_plan',
                        name: 'temp_plan',
                        render: function(data, type, row, meta) {
                            if (type === 'display') {
                                return '<div contenteditable="true" class="form-control plan-input" data-id="' +
                                    (row.id_po || '') + '" data-qty="' + (row.qty || 0) + '">' +
                                    (data || row.qty || 0) + '</div>';
                            }
                            return data;
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

            var newPlan = {};
            $('#tb_open_po').on('blur', '.plan-input[contenteditable="true"]', function() {
                var $this = $(this);
                var id = $this.data('id'); // Ambil ID
                var maxQty = parseFloat($this.data('qty')); // Ambil nilai maksimal dari data-qty
                var newPlanQty = parseFloat($this.text().trim()); // Ambil nilai input

                if (!id) {
                    console.error('ID tidak ditemukan untuk elemen ini.');
                    return;
                }

                l_po.rows().data().each(function(row) {
                    if (!newPlan[row.id_po]) {
                        newPlan[row.id_po] = {
                            temp_plan: row.temp_plan || row.qty ||
                                0 // Ambil `temp_plan` atau default `qty`
                        };
                    }
                });

                // Validasi nilai
                if (isNaN(newPlanQty) || newPlanQty < 0) {
                    alert('Nilai tidak boleh kurang dari 0.');
                    $this.text(0); // Reset ke 0 jika invalid
                    newPlanQty = 0;
                } else if (newPlanQty > maxQty) {
                    alert('Nilai tidak boleh lebih besar dari qty (' + maxQty + ').');
                    $this.text(maxQty); // Reset ke nilai maksimal
                    newPlanQty = maxQty;
                }

                // Perbarui objek `newPlan`
                if (!newPlan[id]) {
                    newPlan[id] = {};
                }

                newPlan[id].temp_plan = newPlanQty;
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
                var noDok = $("#l_noDok").val();

                if (noDok == null || noDok == '') {
                    alert('Ambil Nomor Dokumen terlebih dahulu .');
                } else {
                    var selectedRows = l_po.rows({
                        selected: true
                    }).data().toArray();

                    var selectedIDs = selectedRows.map(function(row) {
                        // Konversi nilai ke angka
                        var planQty = Number(newPlan[row.id_po] && newPlan[row.id_po].temp_plan ?
                            newPlan[row.id_po].temp_plan :
                            row.temp_plan); // Gunakan nilai asli jika belum diperbarui

                        var qtyOut = Number(row.qty_out); // Konversi ke angka

                        var qtyOutTotal = qtyOut + planQty; // Penjumlahan angka
                        var sisa = row.qty - qtyOutTotal;

                        return {
                            id: row.id_po,
                            plan_qty: planQty,
                            sisa: sisa,
                            status: row.status_po,
                        };
                    });

                    if (selectedIDs.length === 0) {
                        alert("Record tidak ada yang dipilih.");
                        return;
                    }

                    // Periksa apakah semua baris yang dipilih memiliki status "Open"
                    var allStatus = selectedIDs.every(function(row) {
                        return row.status === 'Open';
                    });

                    if (!allStatus) {
                        alert("Status PO Harus Open.");
                        return;
                    }

                    $.ajax({
                            url: APP_URL + '/api/sub/upd_kirimPO',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                'selectedIDs': selectedIDs,
                                'noDokumen': noDok,
                            },
                        })
                        .done(function(resp) {
                            if (resp.success) {
                                alert(resp.message);
                                l_po.ajax.reload(null, false); // Refresh DataTable
                                $("#l_noDok").val('');
                            } else {
                                alert(resp.message);
                            }
                        })
                        .fail(function(xhr, status, error) {
                            alert("Terjadi kesalahan saat mengirim data.");
                        });
                }
            });

            $("#btn_ambilNomor").click(function() {
                $.ajax({
                        url: APP_URL + '/api/sub/get_noDok',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            $("#l_noDok").val(resp.new_dok_nomor);
                        } else {
                            alert(resp.message);
                        }
                    })
                    .fail(function(xhr, status, error) {
                        alert("Terjadi kesalahan saat mengirim data.");
                    });
            })

            $("#btn_cetak").click(function() {
                var noDok = $("#l_getNoDok").val();
                window.open(APP_URL + "/sub/cetak_sj/" + noDok, '_blank');
                window.open(APP_URL + "/sub/cetak_inv/" + noDok, '_blank');
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
