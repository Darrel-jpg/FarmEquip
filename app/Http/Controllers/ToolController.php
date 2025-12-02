<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $endpoint = 'https://farmequip.up.railway.app/alat';

        if ($request->filled('category')) {
            $endpoint .= '/' . $request->category;
        }

        $queryParams = [];
        if ($request->filled('sort')) {
            $queryParams['sort'] = $request->sort;
        }

        $response = Http::get($endpoint, $queryParams);

        if ($response->successful()) {
            $tools = collect($response->json());

            $tools = $this->applyFilters($tools, $request);

            return view('catalog', [
                'tools' => $tools->values()->all(),
                'filters' => $this->getFilters($request),
                'sortOptions' => $this->getSortOptions()
            ]);
        }

        return view('catalog', [
            'tools' => [],
            'filters' => $this->getFilters($request),
            'sortOptions' => $this->getSortOptions()
        ]);
    }

    private function applyFilters(Collection $tools, Request $request): Collection
    {
        if (!$request->filled('search')) {
            return $tools;
        }

        $search = strtolower($request->search);

        return $tools->filter(
            fn($tool) =>
            str_contains(strtolower($tool['nama_alat'] ?? ''), $search)
        );
    }

    private function getFilters(Request $request): array
    {
        return $request->only(['search', 'category', 'sort']);
    }

    private function getSortOptions(): array
    {
        return [
            'nama_asc' => 'Nama A-Z',
            'nama_desc' => 'Nama Z-A',
            'harga_asc' => 'Harga Terendah',
            'harga_desc' => 'Harga Tertinggi',
        ];
    }

    public function product($id)
    {
        $response = Http::get("https://farmequip.up.railway.app/alat/{$id}");

        if (!$response->successful()) {
            return redirect()->route('tools')->with('error', 'Tool not found');
        }

        $tool = $response->json();

        if (is_array($tool) && isset($tool[0])) {
            $tool = $tool[0];
        }

        if (!is_array($tool) || empty($tool)) {
            return redirect()->route('tools')->with('error', 'Tool not found');
        }

        return view('product', compact('tool'));
    }
}
