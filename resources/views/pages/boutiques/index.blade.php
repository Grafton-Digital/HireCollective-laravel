<x-layouts.public>
    <x-slot:title>Boutiques — Hire Collective</x-slot:title>
    <x-slot:metaDescription>Discover Ireland's finest luxury fashion hire boutiques. Dresses, hats, and bags for every occasion.</x-slot:metaDescription>

    {{-- Title section --}}
    <section class="px-4 sm:px-[60px] py-12">
        <span class="text-[#c7a869] text-center text-sm block">DISCOVER</span>
        <h1 class="animate font-serif text-center text-[36px] sm:text-[48px] uppercase font-normal text-black animate-visible my-2">All Boutiques</h1>
        <p class="max-w-[520px] text-center text-sm leading-relaxed text-gray-600 mx-auto mb-6">Explore our curated selection of luxury knitwear boutiques, each handpicked for their exceptional craftsmanship and quality.</p>

        {{-- Search section --}}
        <div class="relative max-w-[500px] mx-auto" x-data="boutiqueSearch()">
            <input
                type="text"
                x-model="query"
                @input.debounce.300ms="search()"
                placeholder="Search boutiques..."
                class="w-full border border-gray-300 bg-white px-4 py-3 pr-12 text-sm text-black placeholder-gray-400 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
            />
            <button
                x-show="query.length > 0"
                @click="query = ''; search()"
                type="button"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
            >
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
            <svg x-show="query.length === 0" class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
    </section>

    {{-- Boutique grid --}}
    <section class="px-4 sm:px-[60px] pb-4 sm:pb-20" id="boutiques-section">
        {{-- Results bar --}}
        <div class="flex items-center justify-between mb-6">
            <div class="text-sm text-gray-600" id="boutiques-count">
                Showing {{ $boutiques->count() }} boutique{{ $boutiques->count() !== 1 ? 's' : '' }}
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Sort by:</span>
                <select name="sort" onchange="window.location.href=this.value" class="border border-gray-300 bg-white pl-3 pr-8 py-2 pr-[35px] text-sm text-black focus:border-black focus:outline-none focus:ring-1 focus:ring-black">
                    <option value="{{ route('boutiques.index', array_merge(request()->except('sort'), ['sort' => 'featured'])) }}" {{ request('sort', 'featured') === 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="{{ route('boutiques.index', array_merge(request()->except('sort'), ['sort' => 'name'])) }}" {{ request('sort') === 'name' ? 'selected' : '' }}>A - Z</option>
                    <option value="{{ route('boutiques.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="boutiques-grid">
            @forelse ($boutiques as $boutique)
                <x-boutique-card :boutique="$boutique" />
            @empty
                <p class="col-span-3 text-center text-[#666]">No boutiques found.</p>
            @endforelse
        </div>

        <div id="boutiques-pagination">
            @if ($boutiques->hasPages())
                <div class="py-10">
                    {{ $boutiques->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </section>

    {{-- Register your boutique --}}
   <section class="relative h-[400px] md:h-[600px] overflow-hidden">
        @if (!empty($content['register']['image']))
            <img src="{{ Storage::disk('public')->url($content['register']['image']) }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="Register your boutique">
        @else
            <img src="{{ asset('images/bg-img.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="Register your boutique">
        @endif
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative flex h-full flex-col items-center justify-center gap-8 px-[60px]">
            <h2 class="animate max-w-[400px] font-serif text-center text-white">
                <span class="mt-2 lg:text-left text-[26px] sm:text-[36px] md:text-[48px] lg:text-[48px] font-bold uppercase tracking-[1px] leading-[1.2]">{{ $content['register']['heading'] ?? 'Register your boutique' }}</span>
            </h2>

            <div class="animate animate-delay-100 flex items-center gap-4">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ url('/admin') }}" class="inline-flex items-center justify-center border-[1px] border-white bg-transparent px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-white hover:text-black">
                            {{ $content['register']['button_text'] ?? 'Register Now' }}
                        </a>
                    @else
                        <a href="{{ route('account.overview') }}" class="inline-flex items-center justify-center border-[1px] border-white bg-transparent px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-white hover:text-black">
                            {{ $content['register']['button_text'] ?? 'Register Now' }}
                        </a>
                    @endif
                @else
                    <a href="{{ $content['register']['button_link'] ?? '/boutique/apply' }}" class="inline-flex items-center justify-center border-[1px] border-white bg-transparent px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-white hover:text-black">
                       {{ $content['register']['button_text'] ?? 'Register Now' }}
                    </a>
                @endauth
            </div>
        </div>
    </section>


    <script>
        function boutiqueSearch() {
            return {
                query: '{{ request('search') }}',
                search() {
                    const params = new URLSearchParams(window.location.search);

                    if (this.query.length >= 1) {
                        params.set('search', this.query);
                    } else {
                        params.delete('search');
                    }
                    params.delete('page');

                    fetch('{{ route("boutiques.index") }}?' + params.toString(), {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const doc = new DOMParser().parseFromString(html, 'text/html');
                        document.getElementById('boutiques-grid').innerHTML = doc.getElementById('boutiques-grid').innerHTML;
                        document.getElementById('boutiques-count').innerHTML = doc.getElementById('boutiques-count').innerHTML;
                        document.getElementById('boutiques-pagination').innerHTML = doc.getElementById('boutiques-pagination').innerHTML;

                        const url = '{{ route("boutiques.index") }}' + (params.toString() ? '?' + params.toString() : '');
                        window.history.replaceState({}, '', url);
                    });
                }
            }
        }
    </script>
</x-layouts.public>
