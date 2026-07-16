<x-layouts.public>
    <div class="mx-auto max-w-6xl px-4 py-12 md:py-16">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Products</h1>
                <p class="mt-2 text-sm text-gray-500">{{ $products->total() }} products</p>
            </div>
            <a href="{{ route('dashboard.products.create') }}" class="rounded-md bg-gray-900 px-6 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                Add Product
            </a>
        </div>

    <div class="mt-6 overflow-hidden rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Price</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Available</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @if ($product->is_variable)
                                Variable
                            @else
                                &euro;{{ number_format($product->price, 2) }}
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <x-availability-badge :available="$product->is_active" label-on="Active" label-off="Draft" />
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <x-availability-badge :available="$product->is_available" />
                        </td>
                        <td class="px-4 py-3 text-right text-sm">
                            <a href="{{ route('dashboard.products.edit', $product) }}" class="text-gray-600 hover:text-gray-900">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-layouts.public>
