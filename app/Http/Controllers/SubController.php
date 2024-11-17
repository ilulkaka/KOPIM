<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubController extends Controller
{
    public function frm_po (){
        return view ('sub/frm_po');
    }
}
