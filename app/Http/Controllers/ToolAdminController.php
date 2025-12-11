<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;


class ToolAdminController extends Controller
{
    private string $baseApi = 'https://farmequip.up.railway.app/alat';
    
    public function index(Request $request)
    {
        $res = Http::get($this->baseApi);
        $tools = collect($res->successful() ? $res->json() : []);

        $tools = $this->applyFilters($tools, $request);

        $catRes = Http::get("https://farmequip.up.railway.app/kategori");
        $categories = $catRes->successful() ? $catRes->json() : [];

        return view('admin.manage.index', [
            'tools'      => $tools,
            'categories' => $categories,
            'api'        => $this->baseApi
        ]);
    }

    public function create()
    {
        $categoryRes = Http::get('https://farmequip.up.railway.app/kategori');
        $categories = $categoryRes->successful() ? $categoryRes->json() : [];

        return view('admin.manage.form', [
            'mode'       => 'create',
            'header'     => 'Add New Tool',
            'tool'       => null,
            'categories' => $categories,
            'api'        => $this->baseApi
        ]);
    }

    public function edit($id)
    {
        $res = Http::get("{$this->baseApi}/{$id}");

        if (!$res->successful()) {
            return back()->with('error', 'Tool tidak ditemukan! ❌');
        }

        $data = collect($res->json())->first();

        return view('admin.manage.form', [
            'mode'       => 'edit',
            'header'     => 'Edit Tool',
            'tool'       => $data,
            'categories' => Http::get('https://farmequip.up.railway.app/kategori')->json() ?? []
        ]);
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'nama_alat'         => 'required|string|max:255',
            'category_id'       => 'required',
            'deskripsi'         => 'required|string',
            'spesifikasi'       => 'required|string',
            'harga_per_hari'    => 'required|numeric|min:0',
            'harga_per_minggu'  => 'required|numeric|min:0',
            'harga_per_bulan'   => 'required|numeric|min:0',
            'gambar'            => 'required|file|mimes:jpg,png,jpeg',
        ]);

        $kategoriId = $request->category_id;

        if ($request->category_id === 'other' && $request->new_category) {
            $slug = Str::slug($request->new_category);

            $categoryResponse = Http::post('https://farmequip.up.railway.app/kategori', [
                'nama_kategori' => $request->new_category,
                'slug' => $slug,
                'deskripsi' => 'kategori tambahan',
            ]);

            if (!$categoryResponse->successful()) {
                return back()->withInput()->with('error', 'Gagal membuat kategori baru!');
            }

            $categoryResponse = Http::get("https://farmequip.up.railway.app/kategori");
            $categories = $categoryResponse->json();
            $last = end($categories);
            $kategoriId = $last['id'] ?? null;
            if (!$kategoriId) {
                return back()->withInput()->with('error', 'Gagal mendapatkan ID kategori baru!');
            }
        }

        $image = $request->file('gambar');
        $post = Http::asMultipart()->post('https://farmequip.up.railway.app/alat', [
            [
                'name' => 'nama_alat',
                'contents' => $request->nama_alat,
            ],
            [
                'name' => 'kategori_id',
                'contents' => $kategoriId,
            ],
            [
                'name' => 'deskripsi',
                'contents' => $request->deskripsi,
            ],
            [
                'name' => 'spesifikasi',
                'contents' => $request->spesifikasi,
            ],
            [
                'name' => 'harga_per_hari',
                'contents' => $request->harga_per_hari,
            ],
            [
                'name' => 'harga_per_minggu',
                'contents' => $request->harga_per_minggu,
            ],
            [
                'name' => 'harga_per_bulan',
                'contents' => $request->harga_per_bulan,
            ],
            [
                'name' => 'gambar',
                'contents' => fopen($image->getPathname(), 'r'),
                'filename' => $image->getClientOriginalName(),
            ],
        ]);

        if (!$post->successful()) {
            return back()->withInput()->with('error', 'Gagal menambah alat ke API! Error: ' . $post->status());
        }

        return redirect()->route('admin.tools')->with('success', 'Alat berhasil ditambahkan!');
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'nama_alat'         => 'required|string|max:255',
            'category_id'       => 'required',
            'deskripsi'         => 'required|string',
            'spesifikasi'       => 'required|string',
            'harga_per_hari'    => 'required|numeric|min:0',
            'harga_per_minggu'  => 'required|numeric|min:0',
            'harga_per_bulan'   => 'required|numeric|min:0',
            'gambar'            => 'nullable|file|mimes:jpg,png,jpeg|max:2048', // nullable untuk update
        ]);

        // Handle New Category
        $kategoriId = $req->category_id;

        if ($req->category_id === 'other' && $req->new_category) {
            $slug = Str::slug($req->new_category);
            $categoryResponse = Http::post('https://farmequip.up.railway.app/kategori', [
                'nama_kategori' => $req->new_category,
                'slug' => $slug,
                'deskripsi' => 'kategori tambahan',
            ]);

            if (!$categoryResponse->successful()) {
                return back()->withInput()->with('error', 'Gagal membuat kategori baru!');
            }

            $categoryResponse = Http::get("https://farmequip.up.railway.app/kategori");
            $categories = $categoryResponse->json();
            $last = end($categories);
            $kategoriId = $last['id'] ?? null;

            if (!$kategoriId) {
                return back()->withInput()->with('error', 'Gagal mendapatkan ID kategori baru!');
            }
        }

        $multipartData = [
            [
                'name' => 'nama_alat',
                'contents' => $req->nama_alat,
            ],
            [
                'name' => 'kategori_id',
                'contents' => $kategoriId,
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
        ];

        if ($req->hasFile('gambar')) {
            $image = $req->file('gambar');
            $multipartData[] = [
                'name' => 'gambar',
                'contents' => fopen($image->getPathname(), 'r'),
                'filename' => $image->getClientOriginalName(),
            ];
        }

        $response = Http::asMultipart()->put("https://farmequip.up.railway.app/alat?id={$id}", $multipartData);

        if (!$response->successful()) {
            return back()->withInput()->with('error', 'Gagal mengupdate alat! Error: ' . $response->status());
        }

        return redirect()->route('admin.tools')->with('success', 'Alat berhasil diupdate!');
    }

    public function destroy($id)
    {
        $response = Http::delete("https://farmequip.up.railway.app/alat?id={$id}");

        if (!$response->successful()) {
            return back()->with('error', 'Gagal menghapus alat! Status: ' . $response->status());
        }

        return back()->with('success', 'Alat berhasil dihapus!');
    }

    public function destroyCategory($id)
    {
        $categoryResponse = Http::get('https://farmequip.up.railway.app/kategori');
        if (!$categoryResponse->successful()) {
            return back()->with('error', 'Gagal mengambil data kategori!');
        }

        $categories = $categoryResponse->json()['data'] ?? $categoryResponse->json();
        $categoryToDelete = collect($categories)->firstWhere('id', $id);

        if (!$categoryToDelete) {
            return back()->with('error', 'Kategori tidak ditemukan!');
        }

        $uncategorizedCategory = collect($categories)->first(function ($cat) {
            return strtolower($cat['nama_kategori']) === 'uncategorized';
        });

        if (!$uncategorizedCategory) {
            $createCategoryResponse = Http::asForm()->post('https://farmequip.up.railway.app/kategori', [
                'nama_kategori' => 'Uncategorized',
            ]);

            if (!$createCategoryResponse->successful()) {
                return back()->with('error', 'Gagal membuat kategori Uncategorized!');
            }

            $uncategorizedData = $createCategoryResponse->json();
            $uncategorizedId = $uncategorizedData['id'] ?? $uncategorizedData['data']['id'] ?? null;
        } else {
            $uncategorizedId = $uncategorizedCategory['id'];
        }

        if (!$uncategorizedId) {
            return back()->with('error', 'Gagal mendapatkan ID kategori Uncategorized!');
        }

        $toolsResponse = Http::get("https://farmequip.up.railway.app/alat/{$categoryToDelete['slug']}");

        if (!$toolsResponse->successful()) {
            return back()->with('error', 'Gagal mengambil data tools!');
        }

        $toolsToMove = $toolsResponse->json()['data'] ?? $toolsResponse->json();

        if (empty($toolsToMove)) {
            $deleteResponse = Http::delete("https://farmequip.up.railway.app/kategori?id={$id}");

            if ($deleteResponse->successful()) {
                return back()->with('success', 'Kategori berhasil dihapus!');
            }

            return back()->with('error', 'Gagal menghapus kategori! Status: ' . $deleteResponse->status());
        }

        $movedCount = 0;
        foreach ($toolsToMove as $tool) {
            $updateResponse = Http::asMultipart()->put("https://farmequip.up.railway.app/alat?id={$tool['id']}", [
                [
                    'name' => '_method',
                    'contents' => 'PUT'
                ],
                [
                    'name' => 'nama_alat',
                    'contents' => $tool['nama_alat']
                ],
                [
                    'name' => 'kategori_id',
                    'contents' => $uncategorizedId
                ],
                [
                    'name' => 'deskripsi',
                    'contents' => $tool['deskripsi']
                ],
                [
                    'name' => 'spesifikasi',
                    'contents' => $tool['spesifikasi']
                ],
                [
                    'name' => 'harga_per_hari',
                    'contents' => $tool['harga_per_hari']
                ],
                [
                    'name' => 'harga_per_minggu',
                    'contents' => $tool['harga_per_minggu']
                ],
                [
                    'name' => 'harga_per_bulan',
                    'contents' => $tool['harga_per_bulan']
                ],
                [
                    'name' => 'gambar',
                    'contents' => $tool['gambar']
                ],
            ]);

            if ($updateResponse->successful()) {
                $movedCount++;
            } else {
                $movedCount--;
            }
        }

        $deleteResponse = Http::delete("https://farmequip.up.railway.app/kategori?id={$id}");

        if (!$deleteResponse->successful()) {
            return back()->with('error', 'Gagal menghapus kategori! Status: ' . $deleteResponse->status());
        }
        if ($movedCount > 0) {
            return back()->with('success', "Kategori berhasil dihapus! {$movedCount} alat dipindahkan ke Uncategorized.");
        } elseif ($movedCount < 0) {
            return back()->with('error', "Kategori gagal dihapus!");
        } else {
            return back()->with('success', 'Kategori berhasil dihapus!');
        }
    }

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

        return $tools;
    }
}
