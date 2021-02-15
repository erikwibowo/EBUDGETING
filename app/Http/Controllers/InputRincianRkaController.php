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
            select kdurusan,kdsuburusan,kdprogram,kdgiat,kdsub,kdrek,nourut,tipe,uraian,urut,jumlah as susun,0 as ubah,'T' as kunci from drka_rinci where
                kdurusan='$request->kdurusan' and kdsuburusan='$request->kdsuburusan' and kdprogram = '$request->kdprogram' and kdgiat= '$request->kdgiat' and 
                    kdsub='$request->kdsub' and kdrek = '$request->kdrek' 
        union
            select kdurusan,kdsuburusan,kdprogram,kdgiat,kdsub,kdrek,nourut,tipe,uraian,urut,0 as susun,jumlah as ubah,kunci from drka_rinci_parsial1 where
                kdurusan='$request->kdurusan' and kdsuburusan='$request->kdsuburusan' and kdprogram = '$request->kdprogram' and kdgiat= '$request->kdgiat' and
                    kdsub='$request->kdsub' and kdrek = '$request->kdrek' 
        ) x group by 1,2,3,4,5,6,7,8,9,10 order by 1,2,3,4,5,6,7,8,9,10");
        return view('admin.input-rincian-rka.parsial1', $x);
    }

    public function create_header_parsial1(Request $request){
        $urut = DrkaRinciParsial1::where([
            'kdurusan'      => $request->kdurusan,
            'kdsuburusan'   => $request->kdsuburusan,
            'kdprogram'     => $request->kdprogram,
            'kdgiat'        => $request->kdgiat,
            'kdsub'         => $request->kdsub,
            'kdrek'         => $request->kdrek,
            'tipe'          => 'H'
        ])->orderBy('nourut', 'desc');
        if ($urut->count() == 0) {
            $fn_urut = "0001";
        }else{
            $dt_urut = $urut->first()->nourut + 1;
            if (strlen($dt_urut) == 1) {
                $fn_urut = "000" . $dt_urut;
            } elseif (strlen($dt_urut) == 2) {
                $fn_urut = "00" . $dt_urut;
            } elseif (strlen($dt_urut) == 3) {
                $fn_urut = "0" . $dt_urut;
            } elseif (strlen($dt_urut) == 4) {
                $fn_urut = $dt_urut;
            }
        }
        DrkaRinciParsial1::insert([
            'kdurusan'      => $request->kdurusan,
            'kdsuburusan'   => $request->kdsuburusan,
            'kdprogram'     => $request->kdprogram,
            'kdgiat'        => $request->kdgiat,
            'kdsub'         => $request->kdsub,
            'kdrek'         => $request->kdrek,
            'jenis'         => "",
            'metode'        => "",
            'nourut'        => $fn_urut,
            'tipe'          => "H",
            'uraian'        => $request->uraian,
            'kdbl'          => "",
            'idssh'         => "",
            'spesifikasi'   => "",
            'vol1'          => 0,
            'sat1'          => "",
            'vol2'          => 0,
            'sat2'          => "",
            'vol3'          => 0,
            'sat3'          => "",
            'vol4'          => 0,
            'sat4'          => "",
            'volume'        => 0,
            'satuan'        => "",
            'harga'         => 0,
            'jumlah'        => 0,
            'urut'          => "",
            'kunci'         => 'F'
        ]);
        session()->flash('notif', 'Data berhasil disimpan');
        session()->flash('type', 'success');
        return redirect('admin/input-rincian-rka/parsial1' . '?kdurusan=' . $request->kdurusan . '&kdsuburusan=' . $request->kdsuburusan . '&kdprogram=' . $request->kdprogram . '&kdgiat=' . $request->kdgiat . '&kdsub=' . $request->kdsub . '&tipe=' . $request->tipe . '&kdrek=' . $request->kdrek);
    }

    public function update_header_parsial1(Request $request){
        DrkaRinciParsial1::where([
            'kdurusan'      => $request->kdurusan,
            'kdsuburusan'   => $request->kdsuburusan,
            'kdprogram'     => $request->kdprogram,
            'kdgiat'        => $request->kdgiat,
            'kdsub'         => $request->kdsub,
            'kdrek'         => $request->kdrek,
            'nourut'        => $request->nourut,
            'tipe'          => 'H',
        ])->update(['uraian' => $request->uraian]);
        session()->flash('notif', 'Data berhasil disimpan');
        session()->flash('type', 'success');
        return redirect('admin/input-rincian-rka/parsial1' . '?kdurusan=' . $request->kdurusan . '&kdsuburusan=' . $request->kdsuburusan . '&kdprogram=' . $request->kdprogram . '&kdgiat=' . $request->kdgiat . '&kdsub=' . $request->kdsub . '&tipe=' . $request->tipe . '&kdrek=' . $request->kdrek);
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

    public function create_parsial1(Request $request){
        $urut = DrkaRinciParsial1::where([
            'kdurusan'      => $request->kdurusan,
            'kdsuburusan'   => $request->kdsuburusan,
            'kdprogram'     => $request->kdprogram,
            'kdgiat'        => $request->kdgiat,
            'kdsub'         => $request->kdsub,
            'kdrek'         => $request->kdrek,
            'nourut'        => $request->nourut,
            'tipe'          => 'S'
        ])->orderBy('urut', 'desc');
        if ($urut->count() == 0) {
            $fn_urut = "0001";
        } else {
            $dt_urut = $urut->first()->urut + 1;
            if (strlen($dt_urut) == 1) {
                $fn_urut = "000" . $dt_urut;
            } elseif (strlen($dt_urut) == 2) {
                $fn_urut = "00" . $dt_urut;
            } elseif (strlen($dt_urut) == 3) {
                $fn_urut = "0" . $dt_urut;
            } elseif (strlen($dt_urut) == 4) {
                $fn_urut = $dt_urut;
            }
        }
        // dd($fn_urut);
        DrkaRinciParsial1::insert([
            'kdurusan'      => $request->kdurusan,
            'kdsuburusan'   => $request->kdsuburusan,
            'kdprogram'     => $request->kdprogram,
            'kdgiat'        => $request->kdgiat,
            'kdsub'         => $request->kdsub,
            'kdrek'         => $request->kdrek,
            'jenis'         => "",
            'metode'        => "",
            'nourut'        => $request->nourut,
            'tipe'          => "S",
            'uraian'        => $request->uraian,
            'kdbl'          => "",
            'idssh'         => $request->idssh,
            'spesifikasi'   => $request->spesifikasi,
            'vol1'          => 0,
            'sat1'          => "",
            'vol2'          => 0,
            'sat2'          => "",
            'vol3'          => 0,
            'sat3'          => "",
            'vol4'          => 0,
            'sat4'          => "",
            'volume'        => 0,
            'satuan'        => $request->satuan,
            'harga'         => $request->harga,
            'jumlah'        => 0,
            'urut'          => $fn_urut,
            'kunci'         => 'F'
        ]);
        session()->flash('notif', 'Data berhasil disimpan');
        session()->flash('type', 'success');
        return redirect( 'admin/input-rincian-rka/parsial1' .'?kdurusan=' . $request->kdurusan . '&kdsuburusan=' . $request->kdsuburusan . '&kdprogram=' . $request->kdprogram . '&kdgiat=' . $request->kdgiat . '&kdsub=' . $request->kdsub . '&tipe=' . $request->tipe . '&kdrek=' . $request->kdrek);
    }

    public function delete_parsial1(Request $request){
        DrkaRinciParsial1::where([
            'kdurusan'      => $request->kdurusan,
            'kdsuburusan'   => $request->kdsuburusan,
            'kdprogram'     => $request->kdprogram,
            'kdgiat'        => $request->kdgiat,
            'kdsub'         => $request->kdsub,
            'kdrek'         => $request->kdrek,
            'nourut'        => $request->nourut,
            'urut'          => $request->urut,
            'tipe'          => 'S'
        ])->delete();
        session()->flash('notif', 'Data berhasil dihapus');
        session()->flash('type', 'success');
        return redirect('admin/input-rincian-rka/parsial1' . '?kdurusan=' . $request->kdurusan . '&kdsuburusan=' . $request->kdsuburusan . '&kdprogram=' . $request->kdprogram . '&kdgiat=' . $request->kdgiat . '&kdsub=' . $request->kdsub . '&tipe=' . $request->tipe . '&kdrek=' . $request->kdrek);
    }
}
