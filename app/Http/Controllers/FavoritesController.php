<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class FavoritesController extends Controller
{
    public function index(Request $request): View
    {
        $favoriteIds = $request->input('ids', []);

        if (empty($favoriteIds)) {
            $allProducts = collect();
        } else {
            $allProducts = Product::with(['boutique', 'variants'])
                ->where('is_active', true)
                ->whereIn('id', $favoriteIds)
                ->get()
                ->sortBy(function ($product) use ($favoriteIds) {
                    return array_search($product->id, $favoriteIds);
                })
                ->values();
        }

        $validIds = $allProducts->pluck('id')->values();

        $perPage = 9;
        $page = (int) $request->input('page', 1);
        $products = new LengthAwarePaginator(
            $allProducts->forPage($page, $perPage),
            $allProducts->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pages.favorites.index', compact('products', 'validIds'));
    }
}
