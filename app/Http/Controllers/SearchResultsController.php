<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class SearchResultsController extends Controller
{
    public function __invoke(Request $request): View
    {
        $search = $request->query('q', '');
        $type = $request->query('type', 'all');
        $perPage = 9;

        $products = collect();
        $boutiques = collect();
        $allResults = collect();

        if (strlen($search) >= 2) {
            if ($type !== 'boutiques') {
                $productQuery = Product::with(['boutique', 'variants'])
                    ->where('is_active', true)
                    ->whereHas('boutique', fn ($q) => $q->where('is_active', true))
                    ->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('designer', 'like', "%{$search}%");
                    });

                match ($request->query('sort')) {
                    'price_asc' => $productQuery->orderBy('price_per_day'),
                    'price_desc' => $productQuery->orderByDesc('price_per_day'),
                    default => $productQuery->latest(),
                };

                $products = $productQuery->get();
            }

            if ($type !== 'products') {
                $boutiques = Boutique::where('is_active', true)
                    ->where('status', Boutique::STATUS_APPROVED)
                    ->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('county', 'like', "%{$search}%");
                    })
                    ->get();
            }

            $allResults = $boutiques->map(fn ($b) => ['type' => 'boutique', 'item' => $b])
                ->concat($products->map(fn ($p) => ['type' => 'product', 'item' => $p]));
        }

        $totalResults = $allResults->count();
        $page = (int) $request->query('page', 1);
        $paginatedResults = new LengthAwarePaginator(
            $allResults->forPage($page, $perPage)->values(),
            $totalResults,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pages.search.index', compact('paginatedResults', 'search', 'totalResults'));
    }
}
