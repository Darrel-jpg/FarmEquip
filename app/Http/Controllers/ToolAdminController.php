<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ToolAdminController extends Controller
{
    private string $baseApi = 'https://farmequip.up.railway.app/alat';

    // ✅ Tampil list tools + filter
    public function index()
    {
        $res = Http::get("https://farmequip.up.railway.app/alat");
        $tools = $res->successful() ? $res->json() : [];

        $catRes = Http::get("https://farmequip.up.railway.app/kategori");
        $categories = $catRes->successful() ? $catRes->json() : [];

        return view('admin.manage.index', [
            'tools' => $tools,
            'categories' => $categories,
            'api' => "https://farmequip.up.railway.app/alat" // ✅ tambahkan ini
        ]);
    }

    // ✅ Buka form create (ambil kategori untuk dropdown dari API)
    public function create()
    {
        $response = Http::get('https://farmequip.up.railway.app/kategori');
        $categories = $response->successful() ? $response->json() : [];

        return view('admin.manage.form', [
            'mode'       => 'create',
            'header'     => 'Add New Tool',
            'categories' => $categories
        ]);
    }

    // ✅ Buka form edit (tool + kategori dari API)
    public function edit($id)
    {
        $response = Http::get("{$this->baseApi}/{$id}");
        $cat      = Http::get('https://farmequip.up.railway.app/kategori');

        if (!$response->successful()) {
            return back()->with('error', 'Tool tidak ditemukan! ❌');
        }

        return view('admin.manage.form', [
            'mode'       => 'edit',
            'header'     => 'Edit Tool',
            'tool'       => $response->json(),
            'categories' => $cat->successful() ? $cat->json() : []
        ]);
    }

    // ✅ Simpan tool baru (POST ke API)
    public function store(Request $request)
    {
        $response = Http::post($this->baseApi, $request->all());

        return back()->with(
            $response->successful() ? 'success' : 'error',
            $response->successful() ? 'Tool berhasil ditambahkan! ✅' : 'Gagal menambah tool! ❌'
        );
    }

    // ✅ Update tool (PUT ke API)
    public function update(Request $request, $id)
    {
        $response = Http::put("{$this->baseApi}/{$id}", $request->all());

        return back()->with(
            $response->successful() ? 'success' : 'error',
            $response->successful() ? 'Tool berhasil diupdate! ✅' : 'Gagal update tool! ❌'
        );
    }

    // ✅ Hapus tool (DELETE ke API)
    public function destroy($id)
    {
        $response = Http::delete("{$this->baseApi}/{$id}");

        return back()->with(
            $response->successful() ? 'success' : 'error',
            $response->successful() ? 'Tool berhasil dihapus! ✅' : 'Gagal menghapus tool! ❌'
        );
    }

    // 🔍 Filter logic (copas dari guest)
    private function applyFilters(Collection $tools, Request $request): Collection
    {
        if ($request->filled('search')) {
            $s = strtolower($request->search);
            $tools = $tools->filter(fn($t) => str_contains(strtolower($t['nama_alat'] ?? ''), $s));
        }

        if ($request->filled('category')) {
            $c = strtolower(str_replace('-', ' ', $request->category));
            $tools = $tools->filter(fn($t) => strtolower($t['nama_kategori'] ?? '') === $c);
        }

        if ($request->filled('status')) {
            $tools = $tools->filter(fn($t) => strtolower($t['status'] ?? '') === strtolower($request->status));
        }

        if ($request->filled('min_price')) {
            $tools = $tools->filter(fn($t) => ($t['harga_per_hari'] ?? 0) >= (float) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $tools = $tools->filter(fn($t) => ($t['harga_per_hari'] ?? 0) <= (float) $request->max_price);
        }

        if ($request->filled('sort')) {
            $tools = match ($request->sort) {
                'newest'     => $tools->sortByDesc('created_at'),
                'price_low'  => $tools->sortBy('harga_per_hari'),
                'price_high' => $tools->sortByDesc('harga_per_hari'),
                'popular'    => $tools->sortByDesc('views'),
                default      => $tools
            };
        }

        return $tools;
    }

    private function getFilters(Request $request): array
    {
        return [
            'search'    => $request->search,
            'category'  => $request->category,
            'status'    => $request->status,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
            'sort'      => $request->sort,
        ];
    }
}
