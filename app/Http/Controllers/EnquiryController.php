<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Mail\BookingRequestMail;
use App\Models\Enquiry;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function create(Product $product): View
    {
        if (! $product->is_active || ! $product->boutique->is_active) {
            abort(404);
        }

        $product->load(['variants' => fn ($q) => $q->where('is_available', true), 'boutique']);

        return view('pages.enquiry.create', compact('product'));
    }

    public function store(StoreEnquiryRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        $product = Product::where('is_active', true)
            ->whereHas('boutique', fn ($q) => $q->where('is_active', true))
            ->with('boutique')
            ->findOrFail($validated['product_id']);

        $enquiry = new Enquiry($validated);
        $enquiry->boutique_id = $product->boutique_id;
        $enquiry->status = 'new';
        $enquiry->save();

        $enquiry->load('product');
        Mail::to($product->boutique->contact_email)->send(new BookingRequestMail($enquiry));

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('enquiry.confirmation')->with('enquiry_product', $product->name);
    }

    public function confirmation(): View
    {
        return view('pages.enquiry.confirmation');
    }
}
