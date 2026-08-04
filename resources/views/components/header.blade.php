{{-- Top banner --}}
<div class="bg-cream-200 py-2 text-center z-10">
    <p class="text-[11px] font-normal tracking-[1px] text-black">FREE DELIVERY ON ORDERS OVER €100</p>
</div>

{{-- Header --}}
<header class="relative flex items-center justify-between bg-cream-50 px-4 py-4 md:px-[60px] z-10" x-data="{
    mobileMenuOpen: false,
    searchOpen: false,
    favoritesCount: 0,
    init() {
        this.validateFavorites();
    },
    updateFavoritesCount() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        this.favoritesCount = favorites.length;
    },
    validateFavorites() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        if (favorites.length === 0) {
            this.favoritesCount = 0;
            return;
        }
        const ids = favorites.map(f => f.id);
        fetch('{{ route('favorites.validate') }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
            body: JSON.stringify({ids: ids})
        })
        .then(r => r.json())
        .then(data => {
            const validIds = data.valid_ids;
            const cleaned = favorites.filter(f => validIds.includes(f.id));
            if (cleaned.length !== favorites.length) {
                localStorage.setItem('favorites', JSON.stringify(cleaned));
                window.dispatchEvent(new CustomEvent('favorites-updated'));
            }
            this.favoritesCount = cleaned.length;
        })
        .catch(() => {
            this.favoritesCount = favorites.length;
        });
    }
}" @favorite-added.window="updateFavoritesCount()" @favorite-removed.window="updateFavoritesCount()" @favorites-updated.window="updateFavoritesCount()">
    {{-- Left section: Burger menu + links --}}
    <div class="flex items-center gap-6 z-10">
        {{-- Burger menu button --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="h-6 w-6">
            <svg x-show="!mobileMenuOpen" class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg x-show="mobileMenuOpen" class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Navigation links --}}
        <nav class="hidden items-center gap-6 nav:flex">
            <a href="{{ route('new-arrivals') }}" class="text-xs text-red-500 font-normal tracking-[1px] hover:underline">NEW</a>
            <a href="{{ route('products.index') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">All PRODUCTS</a>
            <a href="{{ route('how-it-works') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">HOW IT WORKS</a>
        </nav>
    </div>

    {{-- Center: Logo --}}
    <a href="{{ route('home') }}" class="font-serif text-center text-[17px] tracking-[3px] text-black sm:text-[26px] ml-[22px] nav:ml-0 md:text-2xl md:ml-[34px]">
        HIRE COLLECTIVE
    </a>

    {{-- Right section: Icons --}}
    <div class="flex w-full max-w-[68px] nav:max-w-[338px] md:max-w-[92px] items-center justify-end gap-2 md:gap-4">
        <button @click="searchOpen = true" class="h-5 w-5">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </button>
        <a href="{{ route('favorites.index') }}" class="relative h-5 w-5">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
            <span
                x-show="favoritesCount > 0"
                x-text="favoritesCount"
                class="absolute -right-2 -top-2 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-semibold text-white"
                style="display: none;"
            ></span>
        </a>
        <a href="@auth{{ auth()->user()->isAdmin() ? url('/admin') : route('account.overview') }}@else{{ route('login') }}@endauth" class="h-5 w-5">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
        </a>
    </div>

    {{-- Search overlay --}}
    <div
        x-show="searchOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="absolute inset-0 z-50 flex items-center bg-white px-4 md:px-[60px]"
        style="display: none;"
        x-data="headerSearch()"
        @keydown.escape.window="if (searchOpen) { searchOpen = false }"
    >
        <button @click="searchOpen = false" class="mr-4 h-6 w-6 flex-shrink-0">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="relative flex-1">
            <form @submit.prevent="submitSearch()" class="flex items-center">
                <input
                    type="text"
                    x-model="query"
                    @input.debounce.300ms="fetchSuggestions()"
                    placeholder="Search dresses, bags, hats, boutiques..."
                    class="flex-1 border-none bg-transparent py-2 text-base text-black placeholder-gray-400 focus:outline-none"
                    x-ref="searchInput"
                    @keydown.arrow-down.prevent="highlightNext()"
                    @keydown.arrow-up.prevent="highlightPrev()"
                    @keydown.enter.prevent="submitSearch()"
                    style="border-bottom: 1px solid #dadada;"
                >
                <button type="submit" class="ml-4 h-6 w-6 flex-shrink-0">
                    <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                </button>
            </form>

            {{-- Dropdown --}}
            <div
                x-show="results.length > 0 && query.length >= 2"
                x-transition
                class="absolute left-0 right-0 top-full mt-1 border border-gray-200 bg-white shadow-lg"
                style="display: none;"
            >
                <template x-for="(item, index) in results" :key="index">
                    <a
                        :href="item.url"
                        @mouseenter="highlighted = index"
                        :class="highlighted === index ? 'bg-gray-50' : ''"
                        class="flex items-center justify-between px-4 py-3 text-sm text-black hover:bg-gray-50 transition-colors"
                    >
                        <span x-text="item.name" class="truncate"></span>
                        <span
                            x-text="item.type === 'product' ? item.price : 'Boutique'"
                            :class="item.type === 'boutique' ? 'text-xs uppercase tracking-wide text-gray-500' : 'text-sm font-medium text-black'"
                        ></span>
                    </a>
                </template>
            </div>
        </div>
    </div>

    <script>
        function headerSearch() {
            return {
                query: '',
                results: [],
                highlighted: -1,
                fetchSuggestions() {
                    if (this.query.length < 2) {
                        this.results = [];
                        return;
                    }
                    fetch('{{ route("search.suggestions") }}?q=' + encodeURIComponent(this.query))
                        .then(r => r.json())
                        .then(data => {
                            this.results = data.results;
                            this.highlighted = -1;
                        });
                },
                highlightNext() {
                    if (this.highlighted < this.results.length - 1) this.highlighted++;
                },
                highlightPrev() {
                    if (this.highlighted > 0) this.highlighted--;
                },
                submitSearch() {
                    if (this.highlighted >= 0 && this.results[this.highlighted]) {
                        window.location.href = this.results[this.highlighted].url;
                        return;
                    }
                    if (this.query.length < 2) return;

                    window.location.href = '{{ route("search.results") }}?q=' + encodeURIComponent(this.query);
                }
            }
        }
    </script>

    {{-- Fullscreen menu --}}
    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed w-full sm:w-[300px] inset-0 z-50 bg-cream-50"
        style="display: none;"
    >
        {{-- Close button --}}
        <div class="absolute left-[24px] top-[54px]">
            <button @click="mobileMenuOpen = false" class="h-6 w-6">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Menu items --}}
        <nav class="flex h-full flex-col justify-center gap-6 p-6 text-center sm:text-start">
            <a href="{{ route('new-arrivals') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline text-red-500">NEW</a>
            <a href="{{ route('products.index') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">All PRODUCTS</a>
            @foreach ($navCategories as $navCategory)
                <a href="{{ route('products.index', ['category' => $navCategory->slug]) }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">{{ strtoupper($navCategory->name) }}</a>
            @endforeach
            <a href="{{ route('boutiques.index') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">BOUTIQUES</a>
            <a href="{{ route('how-it-works') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">HOW IT WORKS</a>
        </nav>
    </div>
</header>
