@props(['product', 'removable' => false, 'showBoutique' => false])

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
        @if ($product->created_at >= now()->subMonth())
            <span class="absolute top-3 left-3 bg-orange-500 px-2.5 py-1 text-[11px] font-semibold tracking-[0.5px] text-white">NEW</span>
        @endif
        <x-favorite-button :product-id="$product->id" />
    </div>

    {{-- Info --}}
    <div @class(['mt-2 flex gap-0.5', 'flex-col' => $showBoutique && $product->boutique, 'flex-row justify-between' => !($showBoutique && $product->boutique)])>
        @if ($showBoutique && $product->boutique)
            <span class="text-[11px] tracking-[0.5px] text-[#666]">{{ strtoupper($product->boutique->name) }}</span>
        @endif
        <span class="text-[13px] font-medium text-black">{{ $product->name }}</span>
        <span class="text-[13px] text-[#333]">
            from 
            @if ($product->is_variable && $product->variants->count())
                from €{{ number_format($product->variants->min('price_per_day'), 0) }}
            @elseif ($product->price_per_day)
                €{{ number_format($product->price_per_day, 0) }}
            @endif
        </span>
    </div>
</a>
</div>
