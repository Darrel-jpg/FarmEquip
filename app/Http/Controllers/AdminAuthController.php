<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class AdminAuthController extends Controller
{
    private string $apiUrl = 'https://farmequip.up.railway.app/login';

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
            return back()->with('error', 'Gagal menghubungi server API, coba lagi.');
        }

        $data = $response->json();

        if (!isset($data['status']) || $data['status'] !== 'success') {
            return back()->with('error', 'Username atau password salah.');
        }

        $user = $data['user'];

        session([
            'admin_logged_in' => true,
            'admin' => $user,
            'admin.role' => $user['role'] ?? 'admin',
        ]);

        if ($req->has('remember')) {
            session()->put('remember_admin', true);
        }

        return redirect()->route('home')->with('success', 'Berhasil login');
    }

    public function logout(Request $req)
    {
        $req->session()->flush(); 

        return redirect()->route('admin.login')
            ->with('success', 'Berhasil logout');
    }
}