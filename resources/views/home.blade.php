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
<ul class="list-group list-group-unbordered mb-3">
<li class="list-group-item">
<b>Tagihan Bulan ini</b> <a class="float-right">{{number_format($aktif,0)}}</a>
</li>
<li class="list-group-item">
<b>SHU Tahun {{$thn}}</b> <a class="float-right" style="font-size:14px; color:red;"><i> Under Maintenance</i></a>
</li>
</ul>
<a href="#" class="btn btn-primary btn-block btn-flat"><b>Detail Tagihan</b></a>
</div>

</div>

@endsection