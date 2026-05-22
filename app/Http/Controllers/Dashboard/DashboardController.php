<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $boutique = $request->user()->boutique;

        $stats = [
            'total_products' => $boutique->products()->count(),
            'active_products' => $boutique->products()->where('is_active', true)->count(),
            'new_enquiries' => $boutique->enquiries()->where('status', 'new')->count(),
            'total_enquiries' => $boutique->enquiries()->count(),
        ];

        $recentEnquiries = $boutique->enquiries()
            ->with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('pages.dashboard.index', compact('stats', 'recentEnquiries'));
    }
}
