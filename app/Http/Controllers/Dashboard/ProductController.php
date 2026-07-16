<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Occasion;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Product::class);

        $products = $request->user()->boutique->products()
            ->with('category')
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

        // Generate unique slug
        $slug = $validated['slug'] ?? Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        $validated['slug'] = $slug;

        // Map 'category' to 'category_id'
        if (isset($validated['category'])) {
            $validated['category_id'] = $validated['category'];
            unset($validated['category']);
        }

        $product = new Product($validated);
        $product->boutique_id = $request->user()->boutique_id;

        if ($request->hasFile('featured_image')) {
            $product->featured_image = $request->file('featured_image')->store('products', 'public');
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('products/gallery', 'public');
            }
            $product->images = $galleryPaths;
        }

        $product->save();

        return redirect()->route('account.products')
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

        // Map 'category' to 'category_id'
        if (isset($validated['category'])) {
            $validated['category_id'] = $validated['category'];
            unset($validated['category']);
        }

        $product->fill($validated);

        if ($request->hasFile('featured_image')) {
            if ($product->featured_image) {
                Storage::disk('public')->delete($product->featured_image);
            }
            $product->featured_image = $request->file('featured_image')->store('products', 'public');
        }

        // Handle gallery images
        $keptImages = $request->input('keep_images') ? json_decode($request->input('keep_images'), true) : [];
        $newGalleryPaths = [];

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $newGalleryPaths[] = $image->store('products/gallery', 'public');
            }
        }

        // Combine kept existing images with new ones
        $product->images = array_merge($keptImages, $newGalleryPaths);

        $product->save();

        return redirect()->route('account.products')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }

        $product->delete();

        return redirect()->route('account.products')
            ->with('success', 'Product deleted successfully.');
    }
}
