<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ToolAdminController extends Controller
{
    private string $baseApi = 'http://localhost:8080/alat';

    // ✅ Tampil dashboard admin (list + filter)
    public function index(Request $request)
    {
        $response = Http::get($this->baseApi);

        $tools = [];
        $filters = $this->getFilters($request);

        if ($response->successful()) {
            $tools = collect($response->json());

            // Pakai filter yang sama logic nya seperti guest (boleh juga copas method jika mau)
            $tools = $this->applyFilters($tools, $request);
        }

        return view('admin.catalog', [
            'tools'   => $tools instanceof Collection ? $tools->values()->all() : $tools,
            'filters' => $filters
        ]);
    }

    // ✅ View form create
    public function create()
    {
        return view('admin.create');
    }

    // ✅ Simpan data (Create)
    public function store(Request $request)
    {
        $request->validate([
            'nama_alat'      => 'required|string',
            'nama_kategori'  => 'required|string',
            'harga_per_hari' => 'required|numeric',
            'status'         => 'required|string'
        ]);

        $response = Http::post($this->baseApi, $request->all());

        if (!$response->successful()) {
            return back()->with('error', 'Gagal menambah tool!');
        }

        return redirect()->route('admin.tools')->with('success', 'Tool berhasil ditambahkan!');
    }

    // ✅ View form edit
    public function edit($id)
    {
        $response = Http::get("{$this->baseApi}/{$id}");

        if (!$response->successful()) {
            return redirect()->route('admin.tools')->with('error', 'Tool tidak ditemukan!');
        }

        $tool = $response->json();

        return view('admin.edit', compact('tool'));
    }

    // ✅ Update data (Edit)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_alat'      => 'required|string',
            'nama_kategori'  => 'required|string',
            'harga_per_hari' => 'required|numeric',
            'status'         => 'required|string'
        ]);

        $response = Http::put("{$this->baseApi}/{$id}", $request->all());

        if (!$response->successful()) {
            return back()->with('error', 'Gagal update tool!');
        }

        return redirect()->route('admin.tools')->with('success', 'Tool berhasil diupdate!');
    }

    // ✅ Hapus data (Delete)
    public function destroy($id)
    {
        $response = Http::delete("{$this->baseApi}/{$id}");

        if (!$response->successful()) {
            return back()->with('error', 'Gagal menghapus tool!');
        }

        return back()->with('success', 'Tool berhasil dihapus!');
    }

    // 👉 Optional jika mau admin filter pakai method yang sama persis seperti guest
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
                'reviews'    => $tools->sortByDesc('rating'),
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
