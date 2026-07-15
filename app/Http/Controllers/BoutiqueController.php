<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Occasion;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoutiqueController extends Controller
{
    public function index(Request $request): View
    {
        $query = Boutique::where('is_active', true)
            ->when($request->query('county'), fn ($q, $county) => $q->where('county', $county))
            ->when($request->query('category'), fn ($q, $cat) => $q->whereHas('products.categories', fn ($cq) => $cq->where('slug', $cat)))
            ->when($request->query('search'), fn ($q, $search) => $q->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('county', 'like', "%{$search}%");
            }));

        $boutiques = match ($request->query('sort')) {
            'name' => $query->orderBy('name'),
            'newest' => $query->latest(),
            default => $query->orderBy('name'),
        };

        $boutiques = $query->paginate(9)->withQueryString();

        return view('pages.boutiques.index', compact('boutiques'));
    }

    public function show(Request $request, Boutique $boutique): View
    {
        if (! $boutique->is_active) {
            abort(404);
        }

        $boutique->load('products');

        $query = $boutique->products()
            ->with('variants')
            ->where('is_active', true)
            ->when($request->query('category'), fn ($q, $slug) => $q->whereHas('categories', fn ($cq) => $cq->where('slug', $slug)))
            ->when($request->query('colour'), fn ($q, $slug) => $q->whereHas('colours', fn ($cq) => $cq->where('slug', $slug)))
            ->when($request->query('occasion'), fn ($q, $slug) => $q->whereHas('occasions', fn ($cq) => $cq->where('slug', $slug)))
            ->when($request->query('designer'), fn ($q, $designer) => $q->where('designer', $designer))
            ->when($request->query('size'), fn ($q, $size) => $q->whereHas('variants', fn ($vq) => $vq->where('size', $size)))
            ->when($request->query('price_range'), function ($q, $range) {
                if ($range === '200+') {
                    return $q->where('price', '>=', 200);
                }
                [$min, $max] = explode('-', $range);

                return $q->whereBetween('price', [(int) $min, (int) $max]);
            });

        $products = match ($request->query('sort')) {
            'name' => $query->orderBy('name'),
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $colours = Colour::orderBy('name')->get();
        $occasions = Occasion::orderBy('name')->get();
        $counties = Boutique::where('is_active', true)
            ->whereNotNull('county')
            ->distinct()
            ->orderBy('county')
            ->pluck('county');
        $designers = Product::where('is_active', true)
            ->whereNotNull('designer')
            ->distinct()
            ->orderBy('designer')
            ->pluck('designer');

        $priceRange = [
            'min' => $boutique->products()->where('is_active', true)->min('price') ?? 0,
            'max' => $boutique->products()->where('is_active', true)->max('price') ?? 500,
        ];

        return view('pages.boutiques.show', compact('boutique', 'products', 'categories', 'colours', 'occasions', 'counties', 'designers', 'priceRange'));
    }
}
