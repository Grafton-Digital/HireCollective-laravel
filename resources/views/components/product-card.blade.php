@props(['product'])

<a href="{{ route('products.show', [$product->boutique, $product]) }}" class="group block">
    {{-- Image --}}
    <div class="relative overflow-hidden rounded bg-cream-100" style="height:320px;">
        @if ($product->featured_image)
            <img src="{{ Storage::url($product->featured_image) }}" alt="{{ $product->name }}"
                 class="h-full w-full object-cover transition group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center">
                <span class="text-sm text-[#999]">No image</span>
            </div>
        @endif
        @if ($product->is_available)
            <span class="absolute left-2 top-2 flex items-center gap-1 rounded-full bg-[#E8F5E9] px-2 py-1 text-2xs font-medium text-[#2E7D32]">
                <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                Available
            </span>
        @endif
    </div>

    {{-- Info --}}
    <div class="mt-2.5 flex flex-col gap-1">
        <p class="text-[13px] font-medium text-black">{{ $product->name }}</p>
        <p class="text-[11px] text-[#666]">{{ $product->boutique->name }}</p>
        <div class="flex items-center justify-between">
            <span class="text-[11px] text-[#666]">
                @if ($product->is_variable && $product->variants->count())
                    Size {{ $product->variants->min('size') }}-{{ $product->variants->max('size') }}
                @endif
            </span>
            <span class="text-[13px] font-semibold text-black">
                @if ($product->is_variable && $product->variants->count())
                    €{{ number_format($product->variants->min('price'), 0) }}
                @elseif ($product->price)
                    €{{ number_format($product->price, 0) }}
                @endif
            </span>
        </div>
    </div>
</a>
