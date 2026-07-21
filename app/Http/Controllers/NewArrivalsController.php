<?php

namespace App\Http\Controllers;

use App\County;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Occasion;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewArrivalsController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = Product::with(['boutique', 'variants'])
            ->where('is_active', true)
            ->whereHas('boutique', fn ($q) => $q->where('is_active', true))
            ->when($request->query('category'), fn ($q, $slug) => $q->whereHas('categories', fn ($cq) => $cq->where('slug', $slug)))
            ->when($request->query('colour'), fn ($q, $slug) => $q->whereHas('colours', fn ($cq) => $cq->where('slug', $slug)))
            ->when($request->query('occasion'), fn ($q, $slug) => $q->whereHas('occasions', fn ($cq) => $cq->where('slug', $slug)))
            ->when($request->query('designer'), fn ($q, $designer) => $q->where('designer', $designer))
            ->when($request->query('county'), fn ($q, $county) => $q->where('county', $county))
            ->when($request->query('size'), fn ($q, $size) => $q->where('size', $size))
            ->when($request->query('price'), function ($q, $price) {
                match ($price) {
                    '0-50' => $q->where('price_per_day', '<=', 50),
                    '50-100' => $q->whereBetween('price_per_day', [50, 100]),
                    '100-150' => $q->whereBetween('price_per_day', [100, 150]),
                    '150-200' => $q->whereBetween('price_per_day', [150, 200]),
                    '200+' => $q->where('price_per_day', '>=', 200),
                    default => $q,
                };
            });

        $products = match ($request->query('sort')) {
            'price_asc' => $query->orderBy('price_per_day'),
            'price_desc' => $query->orderByDesc('price_per_day'),
            default => $query->latest(),
        };

        $products = $query->paginate(9)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $colours = Colour::orderBy('name')->get();
        $occasions = Occasion::orderBy('name')->get();
        $designers = Product::where('is_active', true)
            ->whereNotNull('designer')
            ->distinct()
            ->orderBy('designer')
            ->pluck('designer');
        $counties = County::cases();

        return view('pages.new-arrivals.index', compact('products', 'categories', 'colours', 'occasions', 'designers', 'counties'));
    }
}
