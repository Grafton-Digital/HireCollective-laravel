<x-layouts.dashboard>
    <x-slot:header>Enquiry from {{ $enquiry->customer_name }}</x-slot:header>

    <div class="max-w-2xl space-y-6">
        <div class="rounded-lg border border-gray-200 p-6">
            <dl class="grid gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase text-gray-500">Customer</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $enquiry->customer_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <a href="mailto:{{ $enquiry->customer_email }}" class="underline">{{ $enquiry->customer_email }}</a>
                    </dd>
                </div>
                @if ($enquiry->customer_phone)
                    <div>
                        <dt class="text-xs font-medium uppercase text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $enquiry->customer_phone }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-xs font-medium uppercase text-gray-500">Product</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $enquiry->product?->name ?? '—' }}</dd>
                </div>
                @if ($enquiry->variant)
                    <div>
                        <dt class="text-xs font-medium uppercase text-gray-500">Size</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $enquiry->variant->size }}</dd>
                    </div>
                @endif
                @if ($enquiry->desired_dates)
                    <div>
                        <dt class="text-xs font-medium uppercase text-gray-500">Preferred Dates</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $enquiry->desired_dates }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-xs font-medium uppercase text-gray-500">Received</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $enquiry->created_at->format('d M Y, H:i') }}</dd>
                </div>
            </dl>

            <div class="mt-6 border-t border-gray-200 pt-4">
                <dt class="text-xs font-medium uppercase text-gray-500">Message</dt>
                <dd class="mt-2 whitespace-pre-wrap text-sm text-gray-900">{{ $enquiry->message }}</dd>
            </div>
        </div>

        {{-- Status update --}}
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500">Status:</span>
            @foreach (['new', 'read', 'archived'] as $status)
                @if ($enquiry->status !== $status)
                    <form method="POST" action="{{ route('dashboard.enquiries.update', $enquiry) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="rounded-md border border-gray-300 px-3 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50">
                            Mark as {{ ucfirst($status) }}
                        </button>
                    </form>
                @else
                    <span class="rounded-md bg-gray-100 px-3 py-1 text-xs font-medium text-gray-900">
                        {{ ucfirst($status) }}
                    </span>
                @endif
            @endforeach
        </div>

        <a href="{{ route('dashboard.enquiries.index') }}" class="inline-block text-sm text-gray-500 hover:text-gray-700">&larr; Back to enquiries</a>
    </div>
</x-layouts.dashboard>
