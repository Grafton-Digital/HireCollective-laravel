@props(['boutique'])

<a href="{{ route('boutiques.show', $boutique) }}" class="flex flex-col aspect-[1/0.8] [&:hover_img]:scale-105">
    @if ($boutique->cover_image)
        <div class="h-full overflow-hidden bg-cream-100">
            <img src="{{ Storage::url($boutique->cover_image) }}" alt="{{ $boutique->name }}"
                 class="h-full w-full object-cover transition-transform duration-500">
        </div>
    @else
        <div class="h-full flex items-center justify-center bg-cream-100">
            <span class="font-serif text-6xl font-bold text-black">{{ substr($boutique->name, 0, 1) }}</span>
        </div>
    @endif
    <div class="mt-3 flex flex-col gap-1.5">
        <h3 class="font-serif text-2xl font-normal text-black">{{ $boutique->name }}</h3>
        <div class="flex items-center gap-1.5">
            <svg class="h-3.5 w-3.5 text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
            <span class="text-[11px] text-[#666]">{{ $boutique->city }}, {{ $boutique->county }}</span>
        </div>
        <div class="text-sm leading-relaxed text-gray-600 line-clamp-3">
            {{ $boutique->description }}
        </div>
    </div>
</a>
