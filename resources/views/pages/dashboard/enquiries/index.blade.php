<x-layouts.account>
    <div class="mb-8">
        <h1 class="font-serif text-[32px] tracking-wide text-gray-900">Booking Requests</h1>
        <p class="mt-1 text-sm text-gray-500">Manage incoming booking requests from customers</p>
    </div>

    <div class="flex items-center gap-4 border-b border-gray-200 pb-4">
        <a href="{{ route('account.enquiries.index') }}"
           class="text-sm {{ !request('status') ? 'font-medium text-gray-900 border-b-2 border-black pb-4 -mb-4' : 'text-gray-500 hover:text-gray-700' }}">All</a>
        <a href="{{ route('account.enquiries.index', ['status' => 'new']) }}"
           class="text-sm {{ request('status') === 'new' ? 'font-medium text-gray-900 border-b-2 border-black pb-4 -mb-4' : 'text-gray-500 hover:text-gray-700' }}">New</a>
        <a href="{{ route('account.enquiries.index', ['status' => 'confirmed']) }}"
           class="text-sm {{ request('status') === 'confirmed' ? 'font-medium text-gray-900 border-b-2 border-black pb-4 -mb-4' : 'text-gray-500 hover:text-gray-700' }}">Confirmed</a>
        <a href="{{ route('account.enquiries.index', ['status' => 'completed']) }}"
           class="text-sm {{ request('status') === 'completed' ? 'font-medium text-gray-900 border-b-2 border-black pb-4 -mb-4' : 'text-gray-500 hover:text-gray-700' }}">Completed</a>
        <a href="{{ route('account.enquiries.index', ['status' => 'cancelled']) }}"
           class="text-sm {{ request('status') === 'cancelled' ? 'font-medium text-gray-900 border-b-2 border-black pb-4 -mb-4' : 'text-gray-500 hover:text-gray-700' }}">Cancelled</a>
    </div>

    <div class="mt-6 overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Product</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Event Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Received</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($enquiries as $enquiry)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('account.enquiries.show', $enquiry) }}" class="font-medium text-gray-900 hover:underline">
                                {{ $enquiry->customer_name }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $enquiry->customer_email }}</p>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @if ($enquiry->product)
                                <a href="{{ route('products.show', [$enquiry->product->boutique, $enquiry->product]) }}" class="hover:underline">{{ $enquiry->product->name }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $enquiry->desired_dates ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex px-2 py-0.5 text-xs font-medium
                                {{ $enquiry->status === 'new' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $enquiry->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $enquiry->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $enquiry->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                            ">{{ ucfirst($enquiry->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $enquiry->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">No booking requests yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $enquiries->links() }}
    </div>
</x-layouts.account>
