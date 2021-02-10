<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputAnggaranController extends Controller
{
    public function penyusunan(){
        $x['title'] = "Input anggaran penyusunan";
        $x['data'] = DB::SELECT("
        SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, kdsubgiat, kode, uraian, tipe, sum(susun) AS susun from (
            SELECT kdurusan, kdsuburusan, kdprogram, '' AS kdgiat, '' AS kdsubgiat, kdprogram AS kode, nmprogram AS uraian, 'P' AS tipe, 0 AS susun from mprogram WHERE kdurusan = '1.01.2.22.0.00.02.0000'
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, '' AS kdsubgiat, kdgiat AS kode, nmgiat AS uraian, 'K' AS tipe, 0 AS susun from mgiat WHERE kdurusan = '1.01.2.22.0.00.02.0000'
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, kdsub AS kdsubgiat, kdsub AS kkode, nmsub AS uraian, 'S' AS tipe, 0 AS susun from msubgiat WHERE kdurusan = '1.01.2.22.0.00.02.0000'
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, '' AS kdgiat, '' AS kdsubgiat, kdprogram, '' AS uraian, 'P' AS tipe, sum(jumlah) AS susun from drka WHERE kdurusan = '1.01.2.22.0.00.02.0000' GROUP BY 1, 2, 3, 4, 5
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, '' AS kdsubgiat, kdgiat AS kode, '' AS uraian, 'K' AS tipe, sum(jumlah) AS susun from drka WHERE kdurusan = '1.01.2.22.0.00.02.0000' GROUP BY 1, 2, 3, 4, 5
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, kdsub AS kdsubgiat, kdsub AS kode, '' AS uraian, 'S' AS tipe, sum(jumlah) AS susun from drka WHERE kdurusan = '1.01.2.22.0.00.02.0000' GROUP BY 1, 2, 3, 4, 5
        ) x GROUP BY 1, 2, 3, 4, 5");
        return view('admin.input-anggaran.penyusunan', $x);
    }

    public function parsial1()
    {
        $kdurusan = session('opd');
        $x['title'] = "Input anggaran parsial 1";
        $x['data']  = DB::SELECT("
        SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, kdsubgiat, kode, uraian, tipe, sum(susun) AS susun, sum(parsial) AS parsial, sum(parsial-susun) AS selisih FROM (
            SELECT kdurusan, kdsuburusan, kdprogram, '' AS kdgiat, '' AS kdsubgiat, kdprogram AS kode, nmprogram AS uraian, 'P' AS tipe, 0 AS susun, 0 AS parsial FROM mprogram WHERE kdurusan = '$kdurusan'
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, '' AS kdsubgiat, kdgiat AS kode, nmgiat AS uraian, 'K' AS tipe, 0 AS susun, 0 AS parsial FROM mgiat WHERE kdurusan = '$kdurusan'
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, kdsub AS kdsubgiat, kdsub AS kkode, nmsub AS uraian, 'S' AS tipe, 0 AS susun, 0 AS parsial FROM msubgiat WHERE kdurusan = '$kdurusan'
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, '' AS kdgiat, '' AS kdsubgiat, kdprogram, '' AS uraian, 'P' AS tipe, sum(jumlah) AS susun, 0 AS parsial FROM drka WHERE kdurusan = '$kdurusan' GROUP BY 1, 2, 3, 4, 5
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, '' AS kdsubgiat, kdgiat AS kode, '' AS uraian, 'K' AS tipe, sum(jumlah) AS susun, 0 AS parsial FROM drka WHERE kdurusan = '$kdurusan' GROUP BY 1, 2, 3, 4, 5
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, kdsub AS kdsubgiat, kdsub AS kode, '' AS uraian, 'S' AS tipe, sum(jumlah) AS susun, 0 AS parsial FROM drka WHERE kdurusan = '$kdurusan' GROUP BY 1, 2, 3, 4, 5
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, '' AS kdgiat, '' AS kdsubgiat, kdprogram, '' AS uraian, 'P' AS tipe, 0 AS susun, sum(jumlah) AS parsial FROM drka_parsial1 WHERE kdurusan = '$kdurusan' GROUP BY 1, 2, 3, 4, 5
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, '' AS kdsubgiat, kdgiat AS kode, '' AS uraian, 'K' AS tipe, 0 AS susun, sum(jumlah) AS parsial FROM drka_parsial1 WHERE kdurusan = '$kdurusan' GROUP BY 1, 2, 3, 4, 5
            UNION 
            SELECT kdurusan, kdsuburusan, kdprogram, kdgiat, kdsub AS kdsubgiat, kdsub AS kode, '' AS uraian, 'S' AS tipe, 0 AS susun, sum(jumlah) AS parsial FROM drka_parsial1 WHERE kdurusan = '$kdurusan' GROUP BY 1, 2, 3, 4, 5
        ) x GROUP BY 1, 2, 3, 4, 5");
        return view('admin.input-anggaran.parsial1', $x);
    }
}
