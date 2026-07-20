@props(['product', 'removable' => false])

<div
    @if($removable)
        x-data="{ visible: true, productId: {{ $product->id }} }"
        x-show="visible"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @favorite-removed.window="if ($event.detail.productId === productId) visible = false"
    @endif
    class="group block"
>
<a href="{{ route('products.show', [$product->boutique, $product]) }}" class="block aspect-[1/0.8]">
    {{-- Image --}}
    <div class="relative h-full overflow-hidden bg-cream-100">
        @if ($product->featured_image)
            <img src="{{ Storage::url($product->featured_image) }}" alt="{{ $product->name }}"
                 class="h-full w-full object-cover transition group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center">
                <span class="text-sm text-[#999]">No image</span>
            </div>
        @endif
        <!-- @if ($product->is_available)
            <span class="absolute left-2 top-2 flex items-center gap-1 rounded-full bg-[#E8F5E9] px-2 py-1 text-2xs font-medium text-[#2E7D32]">
                <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                Available
            </span>
        @endif -->
        <x-favorite-button :product-id="$product->id" />
    </div>

    {{-- Info --}}
    <div class="flex flex-row justify-between items-center text-[13px] mt-2 gap-1">
        <span class="font-medium text-black">{{ $product->name }}</span>
        <span>
            @if ($product->is_variable && $product->variants->count())
                from €{{ number_format($product->variants->min('price_per_day'), 0) }}
            @elseif ($product->price_per_day)
                from €{{ number_format($product->price_per_day, 0) }}
            @endif
        </span>
    </div>
</a>
</div>
