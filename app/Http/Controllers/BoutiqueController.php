<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoutiqueController extends Controller
{
    public function index(Request $request): View
    {
        $query = Boutique::where('is_active', true)
            ->when($request->query('county'), fn ($q, $county) => $q->where('county', $county))
            ->when($request->query('category'), fn ($q, $cat) => $q->whereHas('products.categories', fn ($cq) => $cq->where('slug', $cat)))
            ->when($request->query('search'), fn ($q, $search) => $q->where('name', 'like', "%{$search}%"));

        $boutiques = match ($request->query('sort')) {
            'newest' => $query->latest(),
            default => $query->orderBy('name'),
        };

        $boutiques = $query->paginate(9)->withQueryString();

        return view('pages.boutiques.index', compact('boutiques'));
    }

    public function show(Boutique $boutique): View
    {
        if (!$boutique->is_active) {
            abort(404);
        }

        $boutique->load('products');

        $products = $boutique->products()
            ->with('variants')
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('pages.boutiques.show', compact('boutique', 'products'));
    }
}
