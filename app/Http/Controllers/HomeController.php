<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\BelanjaModel;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $nama = Auth::user()->name;
        $nik = Auth::user()->nik;

        $aktif = BelanjaModel::select(DB::raw('sum(nominal)as nominal'))
            ->where('nik', $nik)
            ->get();
        //dd($aktif);
        return view('home', ['aktif' => $aktif]);
        //return view('/dashboard/javascript');
    }
}
