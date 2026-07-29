<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggestions(Request $request): JsonResponse
    {
        $query = $request->query('q', '');

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $products = Product::with('boutique:id,slug')
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('designer', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'name', 'price_per_day', 'slug', 'boutique_id']);

        $boutiques = Boutique::where('is_active', true)
            ->where('status', Boutique::STATUS_APPROVED)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('county', 'like', "%{$query}%");
            })
            ->limit(3)
            ->get(['id', 'name', 'slug']);

        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'type' => 'product',
                'name' => $product->name,
                'url' => route('products.show', [$product->boutique->slug, $product->slug]),
                'price' => '€'.number_format($product->price_per_day, 0),
            ];
        }

        foreach ($boutiques as $boutique) {
            $results[] = [
                'type' => 'boutique',
                'name' => $boutique->name,
                'url' => route('boutiques.show', $boutique->slug),
            ];
        }

        return response()->json(['results' => $results]);
    }
}
