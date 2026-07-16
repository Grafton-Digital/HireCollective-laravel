<x-layouts.account>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="font-serif text-[32px] tracking-wide text-gray-900">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your boutique profile and products</p>
        </div>
        @if(auth()->user()->boutique)
            <a href="{{ route('boutiques.show', auth()->user()->boutique->slug) }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                View Store
            </a>
        @endif
    </div>

    @if(auth()->user()->boutique)
        <div class="bg-white p-8 shadow-sm">
            <div class="mb-6 flex items-start justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Boutique Information</h2>
                <a href="{{ route('account.settings') }}" class="inline-flex items-center gap-2 bg-black px-6 py-2 text-sm text-white hover:bg-gray-800">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit
                </a>
            </div>

            @php
                $boutique = auth()->user()->boutique;
            @endphp

            <div class="grid grid-cols-2 gap-x-16 gap-y-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Boutique Name</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->name }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Email</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->contact_email }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Category</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->description ? 'Occasion Wear, Knitwear' : 'Not specified' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">WhatsApp</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->phone ?? 'Not specified' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Location</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->city ? $boutique->city.', '.$boutique->county : 'Not specified' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Instagram</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->social_links['instagram'] ?? 'Not specified' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Founded</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->created_at ? $boutique->created_at->format('Y') : 'Not specified' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Status</p>
                    <p class="mt-1 text-sm font-medium text-green-600">Active</p>
                </div>

                <div class="col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Short Bio</p>
                    <p class="mt-1 text-sm leading-relaxed text-gray-900">{{ $boutique->description ?? 'No description provided' }}</p>
                </div>
            </div>
        </div>
    @endif
</x-layouts.account>
