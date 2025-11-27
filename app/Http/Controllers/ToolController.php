<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        // Ambil SEMUA data dari API
        $response = Http::get('http://localhost:8080/alat');

        if ($response->successful()) {
            $tools = collect($response->json());
            
            // Filter di Laravel
            $tools = $this->applyFilters($tools, $request);

            return view('catalog', [
                'tools' => $tools->values()->all(), // Reset array keys
                'filters' => $this->getFilters($request)
            ]);
        }

        return view('catalog', [
            'tools' => [],
            'filters' => $this->getFilters($request)
        ]);
    }

    private function applyFilters(Collection $tools, Request $request): Collection
    {
        // Filter: Search (nama_alat)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $tools = $tools->filter(function ($tool) use ($search) {
                return str_contains(strtolower($tool['nama_alat'] ?? ''), $search);
            });
        }

        // Filter: Category (nama_kategori)
        if ($request->filled('category')) {
            $category = $request->category;
            $tools = $tools->filter(function ($tool) use ($category) {
                return strtolower($tool['nama_kategori'] ?? '') === strtolower(str_replace('-', ' ', $category));
            });
        }

        // Filter: Status
        if ($request->filled('status')) {
            $status = $request->status;
            $tools = $tools->filter(fn($tool) => strtolower($tool['status'] ?? '') === $status);
        }

        // Filter: Price Range
        if ($request->filled('min_price')) {
            $minPrice = (float) $request->min_price;
            $tools = $tools->filter(fn($tool) => ($tool['harga_per_hari'] ?? 0) >= $minPrice);
        }

        if ($request->filled('max_price')) {
            $maxPrice = (float) $request->max_price;
            $tools = $tools->filter(fn($tool) => ($tool['harga_per_hari'] ?? 0) <= $maxPrice);
        }

        // Sort
        if ($request->filled('sort')) {
            $tools = match($request->sort) {
                'newest' => $tools->sortByDesc('created_at'),
                'price_low' => $tools->sortBy('harga_per_hari'),
                'price_high' => $tools->sortByDesc('harga_per_hari'),
                'popular' => $tools->sortByDesc('views'),
                'reviews' => $tools->sortByDesc('rating'),
                default => $tools
            };
        }

        return $tools;
    }

    private function getFilters(Request $request): array
    {
        return [
            'search' => $request->search,
            'category' => $request->category,
            'status' => $request->status,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
            'sort' => $request->sort,
        ];
    }

    public function product($id)
    {
        $response = Http::get("http://localhost:8080/alat/{$id}");

        if ($response->successful()) {
            $tool = $response->json();

            return view('product', compact('tool'));
        }

        return redirect()->route('tools')->with('error', 'Tool not found');
    }
}