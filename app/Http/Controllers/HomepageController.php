<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Page;
use App\Models\Product;
use Illuminate\View\View;

class HomepageController extends Controller
{
    public function index(): View
    {
        $page = Page::where('slug', 'homepage')
            ->where('is_published', true)
            ->first();

        $content = $page?->content ?? [];

        $featuredCount = (int) ($content['featured']['count'] ?? 3);
        $brandsCount = (int) ($content['brands']['count'] ?? 6);

        $latestProducts = Product::where('is_active', true)
            ->whereHas('boutique', fn ($q) => $q->where('is_active', true))
            ->latest()
            ->take($featuredCount)
            ->get();

        $featuredBoutiques = Boutique::where('is_active', true)
            ->latest()
            ->take($brandsCount)
            ->get();

        return view('pages.home', compact('page', 'content', 'featuredBoutiques', 'latestProducts'));
    }
}
