<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Validasi input
        $req->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Kirim request ke API
        $response = Http::post($this->apiUrl, [
            'username' => $req->username,
            'password' => $req->password,
        ]);

        // Jika server API tidak bisa diakses
        if ($response->failed()) {
            return back()->with('error', 'Gagal menghubungi server API, coba lagi.');
        }

        $data = $response->json();

        // Jika API tidak mengembalikan status success
        if (!isset($data['status']) || $data['status'] !== 'success') {
            return back()->with('error', 'Username atau password salah.');
        }

        // Data user dari API
        $user = $data['user'];

        // Simpan session
        session([
            'admin_logged_in' => true,
            'admin' => $user,
            'admin.role' => $user['role'] ?? 'admin',   // Biar kompatibel dengan RoleMiddleware
        ]);

        // Jika pakai remember me
        if ($req->has('remember')) {
            session()->put('remember_admin', true);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Berhasil login');
    }

    public function logout(Request $req)
    {
        $req->session()->flush(); // Hapus semua session admin

        return redirect()->route('admin.login')
            ->with('success', 'Berhasil logout');
    }
}