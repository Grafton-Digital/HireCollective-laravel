<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class HowItWorksController extends Controller
{
    public function index(): View
    {
        $page = Page::where('slug', 'how-it-works')
            ->where('is_published', true)
            ->firstOrFail();

        return view('pages.how-it-works.index', compact('page'));
    }
}
