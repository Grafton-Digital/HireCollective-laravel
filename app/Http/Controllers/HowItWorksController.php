<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HowItWorksController extends Controller
{
    public function index(): View
    {
        return view('pages.how-it-works');
    }
}
