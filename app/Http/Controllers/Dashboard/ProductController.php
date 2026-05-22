<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Product::class);

        $products = $request->user()->boutique->products()
            ->latest()
            ->paginate(15);

        return view('pages.dashboard.products.index', compact('products'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Product::class);

        $categories = Category::orderBy('name')->get();
        $colours = Colour::orderBy('name')->get();
        $occasions = Occasion::orderBy('name')->get();

        return view('pages.dashboard.products.create', compact('categories', 'colours', 'occasions'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $validated = $request->validated();

        $product = new Product($validated);
        $product->boutique_id = $request->user()->boutique_id;

        if ($request->hasFile('featured_image')) {
            $product->featured_image = $request->file('featured_image')->store('products', 'public');
        }

        $product->save();

        if (!empty($validated['categories'])) {
            $product->categories()->sync($validated['categories']);
        }
        if (!empty($validated['colours'])) {
            $product->colours()->sync($validated['colours']);
        }
        if (!empty($validated['occasions'])) {
            $product->occasions()->sync($validated['occasions']);
        }

        if ($product->is_variable && !empty($validated['variants'])) {
            foreach ($validated['variants'] as $variantData) {
                $product->variants()->create($variantData);
            }
        }

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Request $request, Product $product): View
    {
        $this->authorize('update', $product);

        $product->load(['variants', 'categories', 'colours', 'occasions']);
        $categories = Category::orderBy('name')->get();
        $colours = Colour::orderBy('name')->get();
        $occasions = Occasion::orderBy('name')->get();

        return view('pages.dashboard.products.edit', compact('product', 'categories', 'colours', 'occasions'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $validated = $request->validated();

        $product->fill($validated);

        if ($request->hasFile('featured_image')) {
            if ($product->featured_image) {
                Storage::disk('public')->delete($product->featured_image);
            }
            $product->featured_image = $request->file('featured_image')->store('products', 'public');
        }

        $product->save();

        $product->categories()->sync($validated['categories'] ?? []);
        $product->colours()->sync($validated['colours'] ?? []);
        $product->occasions()->sync($validated['occasions'] ?? []);

        if ($product->is_variable && !empty($validated['variants'])) {
            $product->variants()->delete();
            foreach ($validated['variants'] as $variantData) {
                $product->variants()->create($variantData);
            }
        } elseif (!$product->is_variable) {
            $product->variants()->delete();
        }

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }

        $product->delete();

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
