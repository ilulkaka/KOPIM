@extends('layout.main')

@section('content')

    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ asset('/assets/img/chg_pass.png') }}"
                    alt="User profile picture">
            </div>
            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
            <p class="text-muted text-center">{{ Auth::user()->role }}</p>
            <input type="hidden" id="id_user" name="id_user" value="{{ Auth::user()->id }}">
                       <!-- <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-low-vision"> Password Lama</i></strong>
                                <input type="password" id="pass_lama" name="pass_lama" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required>
                            </div>
                        </div>
-->    
                        <p></p>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-low-vision"> Password Baru</i></strong>
                                <input type="password" id="pass_baru" name="pass_baru" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-low-vision"> Konfirmasi Password</i></strong>
                                <input type="password" id="konf_pass" name="konf_pass" class="form-control rounded-0"
                                    placeholder="Masukkan Nama Pengguna ." required>
                            </div>
                        </div>
                        <p></p>
           
            <button type="button" id="btn_detail" class="btn btn-info btn-block btn-flat"><b>Ganti Password</b></button>
        </div>
    </div>

    <!-- Modal Detail (D) -->
    <div class="modal fade" id="modal_detail" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5>Konfirmasi Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="" id="notiferror" name="notiferror">Password harus terisi semua .</label>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_detail_1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5>Konfirmasi Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Password Konfirmasi salah .</label>
                </div>
            </div>
        </div>
    </div>

        <div class="modal fade" id="modal_detail_berhasil" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5>Konfirmasi Password</h5>
                    <button type="button" id="btn_c" name="btn_c" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Password Berhasil dirubah .</label>
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
                    var p_lama = $("#pass_lama").val();
                    var p_baru = $("#pass_baru").val();
                    var konf_pass = $("#konf_pass").val();
                    var id_user = $("#id_user").val();

                     if (p_baru == '' || konf_pass == ''){
                        $("#modal_detail").modal('show');
                    } else if(p_baru != konf_pass){
                        $("#modal_detail_1").modal('show');
                    }else if (p_baru == konf_pass){
                        $.ajax({
                        type: "POST",
                        url: APP_URL + '/api/chg_userProfil',
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: {'id_user':id_user, 'p_baru':p_baru, 'konf_pass':konf_pass},
                        //processData: false,
                        //contentType: false,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            $("#modal_detail_berhasil").modal('show');
                            if($("#btn_c").click(function(){
                                location.reload();
                                window.location.href = APP_URL + "/home";
                            })
                            );
                        } else {
                            alert(resp.message);
                        }
                    })
                    }


                });




            });
        </script>
    @endsection
