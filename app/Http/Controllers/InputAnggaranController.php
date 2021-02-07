<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputAnggaranController extends Controller
{
    public function penyusunan(){
        $x['title'] = "Input anggaran penyusunan";
        // $x['data']  = DB::select("");
        return view('admin\input-anggaran\penyusunan', $x);
    }
}
