@props(['product'])

@php
    // Handle both old relationship images and new JSON array
    $imageArray = is_array($product->images) ? $product->images : [];

    // If no gallery images, use featured_image
    if (empty($imageArray) && $product->featured_image) {
        $imageArray = [$product->featured_image];
    }

    $featured = $imageArray[0] ?? null;
@endphp

<div x-data="{ active: '{{ $featured ? Storage::url($featured) : '' }}' }" class="flex flex-col gap-3">
    {{-- Main image --}}
    <div class="overflow-hidden bg-cream-100" style="height:560px;">
        @if ($featured)
            <img :src="active" alt="{{ $product->name }}" class="h-full w-full object-cover">
        @else
            <div class="flex h-full items-center justify-center text-[#999]">No images</div>
        @endif
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
