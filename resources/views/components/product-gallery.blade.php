@props(['product'])

@php
    $imageArray = is_array($product->images) ? $product->images : [];

    // Prepend featured_image as the first gallery image
    if ($product->featured_image) {
        $imageArray = array_values(array_unique(array_merge([$product->featured_image], $imageArray)));
    }

    $featured = $imageArray[0] ?? null;
@endphp

<div x-data="{ active: '{{ $featured ? Storage::url($featured) : '' }}' }" class="flex flex-col gap-3">
    {{-- Main image --}}
    <div class="relative flex h-[500px] items-center justify-center bg-gray-50">
        @if ($featured)
            <img :src="active" alt="{{ $product->name }}" class="h-full w-full object-contain">
        @else
            <div class="flex h-full items-center justify-center text-[#999]">No images</div>
        @endif

        <x-favorite-button :product-id="$product->id" />
    </div>

    {{-- Thumbnails --}}
    @if (count($imageArray) > 1)
        <div class="flex gap-2.5">
            @foreach ($imageArray as $imagePath)
                <button type="button"
                        @click="active = '{{ Storage::url($imagePath) }}'"
                        class="h-20 w-20 shrink-0 overflow-hidden border border-[#E0E0E0] hover:border-black">
                    <img src="{{ Storage::url($imagePath) }}" alt="" class="h-full w-full object-cover">
                </button>
            @endforeach
        </div>
    @endif
</div>
