<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class AdminAuthController extends Controller
{
    private string $apiUrl = 'http://localhost:8080/login';

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $req)
    {
        $req->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $response = Http::post($this->apiUrl, [
            'username' => $req->username,
            'password' => $req->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors(['msg' => 'Gagal menghubungi server API']);
        }

        $data = $response->json();

        if (!isset($data['status']) || $data['status'] !== 'success') {
            return back()->withErrors(['msg' => 'Username / password salah']);
        }

        // Simpan session admin
        session([
            'admin_logged_in' => true,
            'admin' => $data['user'],
            'admin.role' => 'admin',   // << WAJIB untuk RoleMiddleware
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $req)
    {
        $req->session()->forget('admin_logged_in');
        $req->session()->forget('admin');

        return redirect()->route('admin.login')->with('msg', 'Berhasil logout');
    }
}
