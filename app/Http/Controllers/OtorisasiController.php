<?php

namespace App\Http\Controllers;

use App\Models\Otorisasi;
use App\Models\Urusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class OtorisasiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::select("SELECT a.id, a.user_id, a.password, a.opd, a.otorisasi, b.nmurusan FROM otorisasi a LEFT JOIN murusan b ON a.opd = b.kdurusan");
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group"><button type="button" data-id="' . $row->user_id . '" class="btn btn-primary btn-sm btn-edit"><i class="fa fa-eye"></i></button><button type="button" data-id="' . $row->user_id . '" data-name="' . $row->user_id . '" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></button></div>';
                    return $btn;
                })
                ->addColumn('nmurusan', function($row){
                    return $row->opd." - ".$row->nmurusan;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $x['title'] = "Data Otorisasi";
        $x['urusan'] = Urusan::where('level', 3)->orderBy('kdurusan')->get();
        return view('admin/otorisasi', $x);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'otorisasi' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('admin/otorisasi')
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'opd' => $request->input('opd'),
            'password' => $request->input('password'),
            'otorisasi' => $request->input('otorisasi')
        ];
        Otorisasi::where('user_id', $request->input('user_id'))->update($data);
        session()->flash('type', 'success');
        session()->flash('notif', 'Data berhasil disimpan');
        return redirect('admin/otorisasi');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:otorisasi',
            'user_id' => 'required|unique:otorisasi',
            'password' => 'required',
            'otorisasi' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('admin/otorisasi')
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'id' => $request->input('id'),
            'user_id' => $request->input('user_id'),
            'opd' => $request->input('opd'),
            'password' => $request->input('password'),
            'otorisasi' => $request->input('otorisasi')
        ];
        Otorisasi::insert($data);
        session()->flash('type', 'success');
        session()->flash('notif', 'Data berhasil ditambah');
        return redirect('admin/otorisasi');
    }

    public function data(Request $request)
    {
        echo json_encode(Otorisasi::where(['user_id' => $request->input('id')])->first());
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        Otorisasi::where(['user_id' => $id])->delete();
        session()->flash('notif', 'Data berhasil dihapus');
        session()->flash('type', 'success');
        return redirect('admin/otorisasi');
    }

    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }
        $user_id = $request->input('user_id');
        $password = $request->input('password');
        $response_key = $request->input('g-recaptcha-response');
        $secret_key = env('GOOGLE_RECHATPTCHA_SECRETKEY');

        $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response_key);
        $response = json_decode($verify);

        $data = Otorisasi::where(['user_id' => $user_id]);
        if ($response->success) {
            if ($data->count() == 1) {
                $data = $data->first();
                if ($password == $data->password) {
                    session([
                        'id' => $data->id,
                        'user_id' => $data->user_id,
                        'password' => $data->password,
                        'opd' => $data->opd,
                        'otorisasi' => $data->otorisasi,
                        'login_status' => true
                    ]);
                    session()->flash('notif', 'Selamat Datang ' . $data->user_id);
                    session()->flash('type', 'info');
                    return redirect('admin');
                } else {
                    session()->flash('type', 'error');
                    session()->flash('notif', 'User ID atau password anda tidak sesuai');
                }
            } else {
                session()->flash('type', 'error');
                session()->flash('notif', 'User ID atau password anda tidak sesuai');
            }
        }else{
            session()->flash('type', 'error');
            session()->flash('notif', 'Ups! Sepertinya ada yang salah');
        }
        return redirect('admin/login');
    }

    public function logout()
    {
        session()->flash('type', 'info');
        session()->flash('notif', 'Sampai jumpa ' . session('user_id'));
        session()->forget(['id', 'user_id', 'password', 'opd', 'otorisasi', 'login_status']);
        return redirect('admin/login');
    }
}
