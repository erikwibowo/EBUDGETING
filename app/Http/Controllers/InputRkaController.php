<?php

namespace App\Http\Controllers;

use App\Models\DrkaParsial1;
use App\Models\Mrekening;
use App\Models\Msubgiat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class InputRkaController extends Controller
{
    public function parsial1(Request $request){
        $x['title']     = "Input RKA Parsial 1";
        $x['sub']       = Msubgiat::where(['kdsub' => $request->kdsub, 'kdsuburusan' => $request->kdsuburusan])->first();
        if($request->tipe == "00"){
            $x['rekening'] = DB::select("SELECT * FROM mrekening WHERE LEFT(kdrek, 1) IN (4,6) AND tipe = 'S' AND kdrek NOT IN (SELECT kdrek FROM drka_parsial1 WHERE kdsub = '$request->kdsub' AND kdsuburusan = '$request->kdsuburusan')");
        }else{
            $x['rekening'] = DB::select("SELECT * FROM mrekening WHERE LEFT(kdrek, 1) IN (5) AND tipe = 'S' AND kdrek NOT IN (SELECT kdrek FROM drka_parsial1 WHERE kdsub = '$request->kdsub' AND kdsuburusan = '$request->kdsuburusan')");
        }
        $x['data']      = DB::select("SELECT a.kdsub, a.kdsuburusan, a.kdrek, b.nmrek, a.jumlah FROM drka_parsial1 a JOIN mrekening b ON a.kdrek = b.kdrek AND a.kdsuburusan = a.kdsuburusan WHERE a.kdsub = '$request->kdsub' AND a.kdsuburusan = '$request->kdsuburusan'");
        return view('admin.input-rka.parsial1', $x);
    }

    public function create_parsial1(Request $request){
        $validator = Validator::make($request->all(), [
            'kdrek' => 'required'
        ],[
            'required' => 'Harap pilih 1 atau lebih rekening'
        ]);

        if ($validator->fails()) {
            return redirect('admin/input-rka/parsial1?kdsub='.$request->kdsub.'&kdsuburusan='.$request->kdsuburusan.'&tipe='.$request->tipe)
                ->withErrors($validator)
                ->withInput();
        }
        for ($i=0; $i < count($request->kdrek) ; $i++) { 
            DrkaParsial1::insert([
                'kdurusan'      => $request->kdurusan,
                'kdsuburusan'   => $request->kdsuburusan,
                'kdprogram'     => $request->kdprogram,
                'kdgiat'        => $request->kdgiat,
                'kdsub'         => $request->kdsub,
                'kdrek'         => $request->kdrek[$i],
                'jumlah'        => 0,
                'jumlahlalu'    => 0,
                'jumlahdtg'     => 0
            ]);
        }
        session()->flash('type', 'success');
        session()->flash('notif', 'Data berhasil disimpan');
        return redirect('admin/input-rka/parsial1?kdsub='.$request->kdsub.'&kdsuburusan='.$request->kdsuburusan.'&tipe='.$request->tipe);
    }

    public function delete_parsial1(Request $request){
        DrkaParsial1::where([
            'kdrek'         => $request->kdrek,
            'kdsub'         => $request->kdsub,
            'kdsuburusan'   => $request->kdsuburusan
        ])->delete();
        session()->flash('type', 'success');
        session()->flash('notif', 'Data berhasil dihapus');
        return redirect('admin/input-rka/parsial1?kdsub='.$request->kdsub.'&kdsuburusan='.$request->kdsuburusan.'&tipe='.$request->tipe);
    }
}
