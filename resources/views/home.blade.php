@extends('layout.main')

@section('content')
    <h4>
        Selamat Datang 
        <b>{{ Auth::user()->name }}</b>, 
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
<b>Tagihan Aktif</b> <a class="float-right">{{$aktif}}</a>
</li>
<li class="list-group-item">
<b>Tagihan bulan lalu</b> <a class="float-right">543</a>
</li>
<li class="list-group-item">
<b>Transaksi tahun ini</b> <a class="float-right">13,287</a>
</li>
</ul>
<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
</div>

</div>

@endsection