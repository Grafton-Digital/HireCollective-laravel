<x-layouts.dashboard>
    <x-slot:header>Dashboard</x-slot:header>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <x-dashboard-stat label="Total Products" :value="$stats['total_products']" />
        <x-dashboard-stat label="Active Products" :value="$stats['active_products']" />
        <x-dashboard-stat label="New Enquiries" :value="$stats['new_enquiries']" />
        <x-dashboard-stat label="Total Enquiries" :value="$stats['total_enquiries']" />
    </div>

    @if ($recentEnquiries->isNotEmpty())
        <div class="mt-10">
            <h2 class="text-lg font-semibold">Recent Enquiries</h2>
            <div class="mt-4 overflow-hidden rounded-lg border border-gray-200">
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
                        @foreach ($recentEnquiries as $enquiry)
                            <tr>
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{ route('dashboard.enquiries.show', $enquiry) }}" class="font-medium text-gray-900 hover:underline">
                                        {{ $enquiry->customer_name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $enquiry->product?->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="rounded-full px-2 py-0.5 text-xs font-medium
                                        {{ $enquiry->status === 'new' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $enquiry->status === 'read' ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $enquiry->status === 'archived' ? 'bg-gray-50 text-gray-400' : '' }}
                                    ">{{ ucfirst($enquiry->status) }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $enquiry->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-layouts.dashboard>
