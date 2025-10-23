<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register(Request $request)
    {

        $response = Http::post(config('app.api_url') . '/auth/register', [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'no_hp' => $request->input('no_hp'),
            'email' => $request->input('email'),
            'jk' => $request->input('jk'),
            'tgl_lhr'=> $request->input('tgl_lhr'),
            'role'=> $request->input('role'),
            'kelurahan' =>$request->input('kelurahan'),
            'kecamatan' => $request -> input('kecamatan'),
            'kota_kab' => $request->input('kota_kab'),
            'provinsi'=>$request->input('provinsi')
        ]);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Register successful');
        } else {
            return redirect('/register')->with('error', 'Try again'.$response);
        }
    }
}
