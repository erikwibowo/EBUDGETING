<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputRkaController extends Controller
{
    public function parsial1(Request $request){
        $x['title']     = "Input RKA Parsial 1";
        return view('admin.input-rka.parsial1', $x);
    }
}
