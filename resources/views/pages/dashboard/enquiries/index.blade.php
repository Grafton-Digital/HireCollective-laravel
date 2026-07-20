<x-layouts.account>
    <x-slot:header>Enquiries</x-slot:header>

    <div class="flex items-center gap-4">
        <a href="{{ route('account.enquiries.index') }}"
           class="text-sm {{ !request('status') ? 'font-medium text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">All</a>
        <a href="{{ route('account.enquiries.index', ['status' => 'new']) }}"
           class="text-sm {{ request('status') === 'new' ? 'font-medium text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">New</a>
        <a href="{{ route('account.enquiries.index', ['status' => 'read']) }}"
           class="text-sm {{ request('status') === 'read' ? 'font-medium text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">Read</a>
        <a href="{{ route('account.enquiries.index', ['status' => 'archived']) }}"
           class="text-sm {{ request('status') === 'archived' ? 'font-medium text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">Archived</a>
    </div>

    <div class="mt-6 overflow-hidden  border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Product</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($enquiries as $enquiry)
                    <tr>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('account.enquiries.show', $enquiry) }}" class="font-medium text-gray-900 hover:underline">
                                {{ $enquiry->customer_name }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $enquiry->customer_email }}</p>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $enquiry->product?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class=" px-2 py-0.5 text-xs font-medium
                                {{ $enquiry->status === 'new' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $enquiry->status === 'read' ? 'bg-gray-100 text-gray-700' : '' }}
                                {{ $enquiry->status === 'archived' ? 'bg-gray-50 text-gray-400' : '' }}
                            ">{{ ucfirst($enquiry->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $enquiry->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">No enquiries yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $enquiries->links() }}
    </div>
</x-layouts.account>
