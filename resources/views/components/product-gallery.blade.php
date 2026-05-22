@props(['product'])

@php
    $images = $product->images->sortBy('sort_order');
    $featured = $images->firstWhere('is_featured', true) ?? $images->first();
@endphp

<div x-data="{ active: '{{ $featured?->path ? Storage::url($featured->path) : '' }}' }" class="flex flex-col gap-3">
    {{-- Main image --}}
    <div class="overflow-hidden rounded bg-cream-100" style="height:560px;">
        @if ($featured)
            <img :src="active" alt="{{ $product->name }}" class="h-full w-full object-cover">
        @else
            <div class="flex h-full items-center justify-center text-[#999]">No images</div>
        @endif
    </div>

    {{-- Thumbnails --}}
    @if ($images->count() > 1)
        <div class="flex gap-2.5">
            @foreach ($images as $image)
                <button type="button"
                        @click="active = '{{ Storage::url($image->path) }}'"
                        class="h-20 w-20 shrink-0 overflow-hidden rounded border border-[#E0E0E0] hover:border-black">
                    <img src="{{ Storage::url($image->path) }}" alt="" class="h-full w-full object-cover">
                </button>
            @endforeach
        </div>
    @endif
</div>
