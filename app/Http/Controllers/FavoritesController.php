<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoritesController extends Controller
{
    public function index(Request $request): View
    {
        $favoriteIds = $request->input('ids', []);

        if (empty($favoriteIds)) {
            $products = collect();
        } else {
            $products = Product::with(['boutique', 'variants'])
                ->where('is_active', true)
                ->whereIn('id', $favoriteIds)
                ->get()
                ->sortBy(function ($product) use ($favoriteIds) {
                    return array_search($product->id, $favoriteIds);
                });
        }

        return view('pages.favorites.index', compact('products'));
    }
}
