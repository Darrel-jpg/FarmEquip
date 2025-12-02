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
    public function index(Request $request)
    {
        $res = Http::get($this->baseApi);
        $tools = collect($res->successful() ? $res->json() : []);

        // APPLY FILTER
        $tools = $this->applyFilters($tools, $request);

        $catRes = Http::get("https://farmequip.up.railway.app/kategori");
        $categories = $catRes->successful() ? $catRes->json() : [];

        return view('admin.manage.index', [
            'tools'      => $tools,
            'categories' => $categories,
            'api'        => $this->baseApi
        ]);
    }

    // ✅ Buka form create (ambil kategori untuk dropdown dari API)
    public function create()
    {
        $categoryRes = Http::get('https://farmequip.up.railway.app/kategori');
        $categories = $categoryRes->successful() ? $categoryRes->json() : [];

        return view('admin.manage.form', [
            'mode'       => 'create',
            'header'     => 'Tambah Data Tool',
            'tool'       => null,        // ✅ biar Blade aman saat edit
            'categories' => $categories, // ✅ jangan pakai $cat di sini
            'api'        => $this->baseApi
        ]);
    }

    // ✅ Buka form edit (tool + kategori dari API)
    public function edit($id)
    {
        $res = Http::get("{$this->baseApi}/{$id}");

        if (!$res->successful()) {
            return back()->with('error', 'Tool tidak ditemukan! ❌');
        }

        // Karena JSON berupa array, kita ambil index pertama
        $data = collect($res->json())->first();

        return view('admin.manage.form', [
            'mode'       => 'edit',
            'header'     => 'Edit Tool',
            'tool'       => $data,      // ✅ langsung kirim data tool
            'categories' => Http::get('https://farmequip.up.railway.app/kategori')->json() ?? []
        ]);
    }

    // ✅ Simpan tool baru (POST ke API)
    public function store(Request $req)
    {
        $req->validate([
            'nama_alat'     => 'required',
            'kategori_id'   => 'required|integer',
            'gambar'        => 'required|file|mimes:jpg,png,jpeg',
        ]);

        $image = $req->file('gambar');

        // Kirim FILE langsung ke API Go
        $post = Http::asMultipart()->post('https://farmequip.up.railway.app/alat', [
            [
                'name' => 'nama_alat',
                'contents' => $req->nama_alat,
            ],
            [
                'name' => 'kategori_id',
                'contents' => $req->kategori_id,
            ],
            [
                'name' => 'deskripsi',
                'contents' => $req->deskripsi,
            ],
            [
                'name' => 'spesifikasi',
                'contents' => $req->spesifikasi,
            ],
            [
                'name' => 'harga_per_hari',
                'contents' => $req->harga_per_hari,
            ],
            [
                'name' => 'harga_per_minggu',
                'contents' => $req->harga_per_minggu,
            ],
            [
                'name' => 'harga_per_bulan',
                'contents' => $req->harga_per_bulan,
            ],

            // 📌 Yang paling penting
            [
                'name' => 'gambar',
                'contents' => fopen($image->getPathname(), 'r'),
                'filename' => $image->getClientOriginalName(),
            ],
        ]);

        if (!$post->successful()) {
            dd($post->status(), $post->body()); // Kalau gagal tampilkan error API
            return back()->with('error', 'Gagal menambah alat ke API!');
        }

        return redirect()->route('admin.tools')
            ->with('success', 'Alat berhasil ditambahkan!');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|integer',
            'nama_tools' => 'required',
            'kondisi' => 'required',
            'stok' => 'required|integer',
        ]);

        // Kirim ke API
        $response = Http::put("http://farmequip.up.railway.app/alat/$id", $validated);

        if ($response->successful()) {
            return redirect()->route('tools')
                ->with('success', 'Data berhasil diperbarui!');
        }

        return back()->with('error', 'Gagal memperbarui data.');
    }

    // ✅ Hapus tool (DELETE ke API)
    public function destroy($id)
    {
        $response = Http::delete("https://farmequip.up.railway.app/alat?id={$id}");

        if ($response->successful()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Gagal menghapus'], 500);
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
