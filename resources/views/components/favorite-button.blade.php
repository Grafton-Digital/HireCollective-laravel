@props(['productId', 'classes' => 'absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-full bg-white/80 transition-colors hover:bg-white'])

<button
    x-data="{
        liked: false,
        init() {
            let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');

            // Migrate old format to new format if needed
            if (favorites.length > 0 && typeof favorites[0] === 'number') {
                favorites = favorites.map(id => ({
                    id: id,
                    addedAt: Date.now()
                }));
                localStorage.setItem('favorites', JSON.stringify(favorites));
            }

            this.liked = favorites.some(f => f.id === {{ $productId }});
        },
        toggleLike() {
            let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');

            // Ensure new format
            if (favorites.length > 0 && typeof favorites[0] === 'number') {
                favorites = favorites.map(id => ({
                    id: id,
                    addedAt: Date.now()
                }));
            }

            const wasLiked = this.liked;

            if (this.liked) {
                // Remove from favorites
                favorites = favorites.filter(f => f.id !== {{ $productId }});

                // Also remove from viewed list
                let viewedFavorites = JSON.parse(localStorage.getItem('viewedFavorites') || '[]');
                viewedFavorites = viewedFavorites.filter(id => id !== {{ $productId }});
                localStorage.setItem('viewedFavorites', JSON.stringify(viewedFavorites));
            } else {
                // Add to favorites with timestamp
                favorites.push({
                    id: {{ $productId }},
                    addedAt: Date.now()
                });
            }

            localStorage.setItem('favorites', JSON.stringify(favorites));
            this.liked = !this.liked;

            // Dispatch events to sync all buttons with same product
            if (wasLiked) {
                window.dispatchEvent(new CustomEvent('favorite-removed', {
                    detail: { productId: {{ $productId }} }
                }));
            } else {
                window.dispatchEvent(new CustomEvent('favorite-added', {
                    detail: { productId: {{ $productId }} }
                }));
            }
        }
    }"
    @click.prevent="toggleLike()"
    @favorite-added.window="if ($event.detail.productId === {{ $productId }}) liked = true"
    @favorite-removed.window="if ($event.detail.productId === {{ $productId }}) liked = false"
    class="{{ $classes }}"
    :class="{ 'text-red-500': liked }"
>
    <svg
        class="h-5 w-5 transition-all"
        xmlns="http://www.w3.org/2000/svg"
        :fill="liked ? 'currentColor' : 'none'"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="1.5"
    >
        <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
    </svg>
</button>
