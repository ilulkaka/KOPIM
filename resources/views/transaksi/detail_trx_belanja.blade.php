@extends('layout.main')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col-12">
                    <h3 class="card-title"><u>Detail Transaksi Belanja</u></h3>
                </div>
            </div>

            <div class="modal-body">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap" id="tb_detail_trx">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>No Barcode</th>
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
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
