<x-layouts.account>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-[28px] sm:text-[32px] tracking-wide text-gray-900">Boutique</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your boutique profile and products</p>
        </div>
        @if(auth()->user()->boutique)
            <a href="{{ route('boutiques.show', auth()->user()->boutique->slug) }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                View Boutique
            </a>
        @endif
    </div>

    @if(auth()->user()->boutique)
        <div class="bg-white p-4 sm:p-8 shadow-sm">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Information</h2>
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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-16 gap-y-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Boutique Name</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->name }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Account Email</p>
                    <p class="mt-1 text-sm text-gray-900">{{ auth()->user()->email }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Website</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->website ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Contact Email</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->contact_email }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Phone</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->phone ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">County</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->county ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Member Since</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $boutique->approved_at ? $boutique->approved_at->format('j F Y') : ($boutique->created_at ? $boutique->created_at->format('j F Y') : '-') }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Status</p>
                    <p class="mt-1 text-sm font-medium text-green-600">Active</p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Short Bio</p>
                    <div class="prose prose-sm mt-1 text-gray-900">{!! $boutique->description ?? '-' !!}</div>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Social Media</p>
                    @if(!empty($boutique->social_links))
                        <div class="mt-2 flex items-center gap-4">
                            @foreach($boutique->social_links as $platform => $handle)
                                <a href="{{ $handle }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-gray-900 transition-colors" title="{{ ucfirst($platform === 'twitter' ? 'X' : $platform) }}">
                                    @switch($platform)
                                        @case('instagram')
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                            @break
                                        @case('tiktok')
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.88 2.89 2.89 0 01-2.88-2.88 2.89 2.89 0 012.88-2.88c.28 0 .56.04.82.11V9.4a6.33 6.33 0 00-.82-.05A6.34 6.34 0 003.15 15.7a6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.34-6.34V9.05a8.27 8.27 0 004.76 1.5V7.1a4.83 4.83 0 01-1-.41z"/></svg>
                                            @break
                                        @case('facebook')
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                            @break
                                        @case('twitter')
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                            @break
                                        @case('threads')
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.186 24h-.007c-3.581-.024-6.334-1.205-8.184-3.509C2.35 18.44 1.5 15.586 1.472 12.01v-.017c.03-3.579.879-6.43 2.525-8.482C5.845 1.205 8.6.024 12.18 0h.014c2.746.02 5.043.725 6.826 2.098 1.677 1.29 2.858 3.13 3.509 5.467l-2.04.569c-1.104-3.96-3.898-5.984-8.304-6.015-2.91.022-5.11.936-6.54 2.717C4.307 6.504 3.616 8.914 3.59 12c.025 3.086.718 5.496 2.057 7.164 1.43 1.783 3.631 2.698 6.54 2.717 2.623-.02 4.358-.631 5.8-2.045 1.647-1.613 1.618-3.593 1.09-4.798-.31-.71-.873-1.3-1.634-1.75-.192 1.352-.622 2.446-1.284 3.272-.886 1.102-2.14 1.704-3.73 1.79-1.202.065-2.361-.218-3.259-.801-1.063-.689-1.685-1.74-1.752-2.96-.065-1.17.408-2.243 1.33-3.023.88-.744 2.084-1.168 3.59-1.264 1.104-.07 2.132.02 3.062.267.03-.643.003-1.26-.082-1.838-.215-1.452-.778-2.422-1.73-2.97-.981-.566-2.293-.674-3.546-.296l-.614-1.94c1.795-.543 3.678-.395 5.156.406 1.38.748 2.29 2.08 2.604 3.807.088.483.14.995.157 1.534 1.09.59 1.943 1.39 2.477 2.392.78 1.463.89 3.944-.86 5.66-1.818 1.783-4.07 2.576-7.31 2.6zm-.04-8.95c-1.476.094-3.081.578-3.081 2.196 0 1.3 1.334 2.023 2.58 1.955 1.387-.075 2.554-.753 3.15-2.152.087-.205.162-.427.226-.665-.933-.266-1.925-.398-2.875-.334z"/></svg>
                                            @break
                                    @endswitch
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-900">-</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
</x-layouts.account>
