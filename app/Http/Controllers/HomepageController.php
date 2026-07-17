<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\HomepageSection;
use App\Models\Product;
use Illuminate\View\View;

class HomepageController extends Controller
{
    public function index(): View
    {
        $sections = HomepageSection::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredBoutiques = Boutique::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        $latestProducts = Product::where('is_active', true)
            ->whereHas('boutique', fn ($q) => $q->where('is_active', true))
            ->latest()
            ->take(3)
            ->get();

        return view('pages.home', compact('sections', 'featuredBoutiques', 'latestProducts'));
    }
}
