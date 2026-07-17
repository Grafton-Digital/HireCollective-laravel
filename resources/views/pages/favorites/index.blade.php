<x-layouts.public>
    <x-slot:title>Saved Items — Hire Collective</x-slot:title>

    <script>
        (function() {
            const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            const urlParams = new URLSearchParams(window.location.search);
            const urlIds = urlParams.getAll('ids[]').map(id => parseInt(id));

            // Check if URL IDs match localStorage IDs
            const idsMatch = favorites.length === urlIds.length &&
                             favorites.every(id => urlIds.includes(id)) &&
                             urlIds.every(id => favorites.includes(id));

            if (!idsMatch) {
                // Reload with correct IDs from localStorage
                if (favorites.length > 0) {
                    const params = new URLSearchParams();
                    favorites.forEach(id => params.append('ids[]', id));
                    window.location.replace('{{ route('favorites.index') }}?' + params.toString());
                } else {
                    // No favorites - clear URL params
                    window.location.replace('{{ route('favorites.index') }}');
                }
            }
        })();
    </script>

    <div
        x-data="{
            favoriteCount: JSON.parse(localStorage.getItem('favorites') || '[]').length,
            updateCount() {
                this.favoriteCount = JSON.parse(localStorage.getItem('favorites') || '[]').length;
            }
        }"
        @favorite-removed.window="updateCount()"
    >
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 bg-white px-[60px] py-3">
            <a href="{{ route('home') }}" class="text-xs text-[#666] hover:underline">Home</a>
            <span class="text-xs text-[#666]">&gt;</span>
            <span class="text-xs text-black">Saved Items</span>
        </div>

        {{-- Title section --}}
        <section class="bg-white px-[60px] pb-6 pt-5">
            <div class="flex items-center justify-between">
                <h1 class="font-serif text-[38px] text-black">Saved Items</h1>
                <span class="text-sm text-[#666]" x-text="favoriteCount + ' items saved'"></span>
            </div>
        </section>

        <div class="h-px bg-[#E0E0E0]"></div>

        {{-- Product grid --}}
        <section class="bg-white px-[60px] py-8">
            @if ($products->isEmpty())
                <div class="flex flex-col items-center justify-center py-16">
                    <svg class="mb-4 h-16 w-16 text-[#999]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                    </svg>
                    <p class="mb-2 text-lg font-medium text-black">No saved items yet</p>
                    <p class="mb-6 text-sm text-[#666]">Start saving your favorite pieces to view them here</p>
                    <a href="{{ route('products.index') }}" class="bg-black px-6 py-2.5 text-sm font-medium tracking-[1px] text-white hover:bg-gray-800">
                        BROWSE PRODUCTS
                    </a>
                </div>
            @else
                <div class="grid grid-cols-4 gap-5">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" :removable="true" />
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-layouts.public>
