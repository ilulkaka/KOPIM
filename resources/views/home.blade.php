@extends('layout.main')

@section('content')
    <h4>
        Selamat Datang 
        <b>{{ Auth::user()->name }}</b>, 
        Anda Login sebagai 
        <b>{{ Auth::user()->role }}</b>
    </h4>
@endsection