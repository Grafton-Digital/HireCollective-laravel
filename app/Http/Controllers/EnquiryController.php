<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Models\Enquiry;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EnquiryController extends Controller
{
    public function create(Product $product): View
    {
        if (!$product->is_active || !$product->boutique->is_active) {
            abort(404);
        }

        $product->load(['variants' => fn ($q) => $q->where('is_available', true), 'boutique']);

        return view('pages.enquiry.create', compact('product'));
    }

    public function store(StoreEnquiryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $product = Product::where('is_active', true)
            ->whereHas('boutique', fn ($q) => $q->where('is_active', true))
            ->findOrFail($validated['product_id']);

        $enquiry = new Enquiry($validated);
        $enquiry->boutique_id = $product->boutique_id;
        $enquiry->status = 'new';
        $enquiry->save();

        return redirect()->route('enquiry.confirmation')->with('enquiry_product', $product->name);
    }

    public function confirmation(): View
    {
        return view('pages.enquiry.confirmation');
    }
}
