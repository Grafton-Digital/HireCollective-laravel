<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookTestRequest;
use App\Mail\BookTestMail;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class BookTestController extends Controller
{
    public function store(StoreBookTestRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $product = Product::where('is_active', true)
            ->whereHas('boutique', fn ($q) => $q->where('is_active', true))
            ->with('boutique')
            ->findOrFail($validated['product_id']);

        Mail::to($product->boutique->contact_email)->send(new BookTestMail(
            customerName: $validated['customer_name'],
            customerEmail: $validated['customer_email'],
            customerPhone: $validated['customer_phone'] ?? null,
            productName: $product->name,
            productEditUrl: route('account.products.edit', $product),
        ));

        return response()->json(['message' => 'Request sent successfully.']);
    }
}
