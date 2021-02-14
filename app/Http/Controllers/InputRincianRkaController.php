<?php

namespace App\Http\Controllers;

use App\Models\DrkaRinciParsial1;
use App\Models\Mrekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputRincianRkaController extends Controller
{
    public function parsial1(Request $request){
        $x['title']     = "Input Rincian RKA Parsial 1";
        $x['rek']       = Mrekening::where(['kdrek' => $request->kdrek])->first();
        $x['data']      = DB::select("
        select kdurusan,kdsuburusan,kdprogram,kdgiat,kdsub,kdrek,nourut,tipe,uraian,urut,sum(susun) as susun,sum(ubah) as ubah,sum(ubah-susun) as selisih,kunci from (
            select kdurusan,kdsuburusan,kdprogram,kdgiat,kdsub,kdrek,nourut,tipe,uraian,urut,jumlah as susun,0 as ubah,'T' as kunci from drka_rinci where kdurusan='$request->kdurusan' and kdsuburusan='$request->kdsuburusan' and kdprogram = '$request->kdprogram' and kdgiat= '$request->kdgiat' and 
                kdsub='$request->kdsub' and kdrek = '$request->kdrek' 
        union 
            select kdurusan,kdsuburusan,kdprogram,kdgiat,kdsub,kdrek,nourut,tipe,uraian,urut,0 as susun,jumlah as ubah,kunci from drka_rinci_parsial1 where kdurusan='$request->kdurusan' and kdsuburusan='$request->kdsuburusan' and kdprogram = '$request->kdprogram' and kdgiat= '$request->kdgiat' and 
                kdsub='$request->kdsub' and kdrek = '$request->kdrek' 	
        ) x group by 1,2,3,4,5,6,7,9");
        return view('admin.input-rincian-rka.parsial1', $x);
    }

    public function data_rinci_parsial1(Request $request){
        echo json_encode(DrkaRinciParsial1::where([
            'kdurusan'      => $request->kdurusan,
            'kdsuburusan'   => $request->kdsuburusan,
            'kdprogram'     => $request->kdprogram,
            'kdgiat'        => $request->kdgiat,
            'kdsub'         => $request->kdsub,
            'kdrek'         => $request->kdrek,
            'nourut'        => $request->nourut,
            'urut'          => $request->urut,
            'tipe'          => 'S'
        ])->first());
    }
}
