@props(['product'])

<div
    x-data="{
        visible: true,
        productId: {{ $product->id }},
        get addedAt() {
            const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            const favorite = favorites.find(f => f.id === {{ $product->id }});
            return favorite ? favorite.addedAt : null;
        },
        getTimeAgo() {
            if (!this.addedAt) return '';

            const now = Date.now();
            const diff = now - this.addedAt;
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const weeks = Math.floor(days / 7);

            if (days === 0) return 'Added today';
            if (days === 1) return 'Added 1 day ago';
            if (days < 7) return `Added ${days} days ago`;
            if (weeks === 1) return 'Added 1 week ago';
            return `Added ${weeks} weeks ago`;
        }
    }"
    x-show="visible"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    @favorite-removed.window="if ($event.detail.productId === productId) visible = false"
    class="group block"
>
    <a href="{{ route('products.show', [$product->boutique, $product]) }}" class="block">
        {{-- Image --}}
        <div class="relative aspect-[1/0.8] overflow-hidden bg-cream-100">
            @if ($product->featured_image)
                <img src="{{ Storage::url($product->featured_image) }}" alt="{{ $product->name }}"
                     class="h-full w-full object-cover transition group-hover:scale-105">
            @else
                <div class="flex h-full items-center justify-center">
                    <span class="text-sm text-[#999]">No image</span>
                </div>
            @endif
            <x-favorite-button :product-id="$product->id" />
        </div>

        {{-- Info --}}
        <div class="mt-3">
            {{-- Brand name --}}
            <div class="mb-1 text-[11px] uppercase tracking-[0.5px] text-[#666]">
                {{ $product->boutique->name }}
            </div>

            {{-- Product name --}}
            <div class="mb-1 text-[13px] font-medium text-black">
                {{ $product->name }}
            </div>

            {{-- Price and timestamp row --}}
            <div class="flex items-center justify-between text-[13px]">
                <span class="text-black">
                    @if ($product->is_variable && $product->variants->count())
                        from €{{ number_format($product->variants->min('price_per_day'), 0) }}
                    @elseif ($product->price_per_day)
                        from €{{ number_format($product->price_per_day, 0) }}
                    @endif
                </span>
                <span class="text-[11px] text-[#999]" x-text="getTimeAgo()"></span>
            </div>
        </div>
    </a>
</div>
