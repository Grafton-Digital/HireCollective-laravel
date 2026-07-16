<x-layouts.account>
    <div class="bg-white p-8" x-data="{ deleteModal: false, deleteFormId: null }">
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="font-serif text-[24px] tracking-wide text-gray-900">Products</h1>
                <span class="text-sm text-gray-500 mt-1">{{ $products->total() }} items</span>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <input
                        type="text"
                        placeholder="Search products..."
                        class="w-80 border-gray-300 py-2 pl-10 pr-4 text-sm focus:border-gray-400 focus:ring-gray-400"
                        x-data
                        @input.debounce.300ms="window.location.href = '{{ route('account.products') }}?search=' + $event.target.value"
                    >
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                </div>

                <a href="{{ route('dashboard.products.create') }}" class="inline-flex items-center gap-2 bg-black px-6 py-2 text-sm text-white hover:bg-gray-800">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Product
                </a>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="py-12 text-center">
                <p class="text-gray-500">No products found.</p>
            </div>
        @else
            <div class="overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="pb-3">Image</th>
                            <th class="pb-3">Name</th>
                            <th class="pb-3">Price From</th>
                            <th class="pb-3">Size</th>
                            <th class="pb-3">Colour</th>
                            <th class="pb-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($products as $product)
                            <tr class="group">
                                <td class="py-4">
                                    @if($product->images && count($product->images) > 0)
                                        <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="h-12 w-12 bg-gray-100 object-cover">
                                    @elseif($product->featured_image)
                                        <img src="{{ Storage::url($product->featured_image) }}" alt="{{ $product->name }}" class="h-12 w-12 bg-gray-100 object-cover">
                                    @else
                                        <div class="h-12 w-12 bg-gray-100"></div>
                                    @endif
                                </td>
                                <td class="py-4 text-sm text-gray-900">{{ $product->name }}</td>
                                <td class="py-4 text-sm text-gray-900">from €{{ number_format($product->price_per_day, 0) }}</td>
                                <td class="py-4 text-sm text-gray-900">{{ $product->size ?? '-' }}</td>
                                <td class="py-4 text-sm text-gray-900">{{ $product->color ?? '-' }}</td>
                                <td class="py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dashboard.products.edit', $product) }}" class="text-gray-400 hover:text-gray-900" title="Edit">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                        <button
                                            @click="deleteModal = true; deleteFormId = 'delete-form-{{ $product->id }}'"
                                            class="text-gray-400 hover:text-red-600"
                                            title="Delete"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                        <form id="delete-form-{{ $product->id }}" action="{{ route('dashboard.products.destroy', $product) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @endif
        @endif

        {{-- Delete Confirmation Modal --}}
        <div
            x-show="deleteModal"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @click.self="deleteModal = false"
        >
            <div class="w-full max-w-md bg-white p-8 shadow-lg" @click.away="deleteModal = false">
                <h2 class="mb-4 font-serif text-[20px] text-gray-900">Delete Product</h2>
                <p class="mb-6 text-sm text-gray-600">Are you sure you want to delete this product? This action cannot be undone.</p>

                <div class="flex items-center justify-end gap-3">
                    <button
                        @click="deleteModal = false"
                        class="px-6 py-2 text-sm text-gray-600 hover:text-gray-900"
                    >
                        Cancel
                    </button>
                    <button
                        @click="document.getElementById(deleteFormId).submit()"
                        class="bg-red-600 px-6 py-2 text-sm text-white hover:bg-red-700"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.account>
