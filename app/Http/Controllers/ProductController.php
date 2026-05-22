<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Occasion;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['boutique', 'variants'])
            ->where('is_active', true)
            ->whereHas('boutique', fn ($q) => $q->where('is_active', true))
            ->when($request->query('category'), fn ($q, $slug) => $q->whereHas('categories', fn ($cq) => $cq->where('slug', $slug)))
            ->when($request->query('colour'), fn ($q, $slug) => $q->whereHas('colours', fn ($cq) => $cq->where('slug', $slug)))
            ->when($request->query('occasion'), fn ($q, $slug) => $q->whereHas('occasions', fn ($cq) => $cq->where('slug', $slug)))
            ->when($request->query('boutique'), fn ($q, $slug) => $q->whereHas('boutique', fn ($bq) => $bq->where('slug', $slug)))
            ->when($request->query('size'), fn ($q, $size) => $q->whereHas('variants', fn ($vq) => $vq->where('size', $size)))
            ->when($request->query('search'), fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->when($request->query('price'), function ($q, $price) {
                match ($price) {
                    '0-50' => $q->where('price', '<=', 50),
                    '50-100' => $q->whereBetween('price', [50, 100]),
                    '100+' => $q->where('price', '>=', 100),
                    default => $q,
                };
            });

        $products = match ($request->query('sort')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default => $query->latest(),
        };

        $products = $query->paginate(16)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $colours = Colour::orderBy('name')->get();
        $occasions = Occasion::orderBy('name')->get();
        $boutiques = Boutique::where('is_active', true)->orderBy('name')->get();

        return view('pages.products.index', compact('products', 'categories', 'colours', 'occasions', 'boutiques'));
    }

    public function show(Boutique $boutique, Product $product): View
    {
        if (!$boutique->is_active || !$product->is_active || $product->boutique_id !== $boutique->id) {
            abort(404);
        }

        $product->load(['variants', 'images' => fn ($q) => $q->orderBy('sort_order'), 'categories', 'colours', 'occasions']);

        $related = Product::with(['boutique', 'variants'])
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where('boutique_id', $boutique->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('pages.products.show', compact('boutique', 'product', 'related'));
    }
}
