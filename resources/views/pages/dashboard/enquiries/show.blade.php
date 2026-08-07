<x-layouts.account>
    <div class="mb-6">
        <a href="{{ route('account.enquiries.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Booking Requests
        </a>
    </div>

    <div class="w-full max-w-2xl space-y-6">
        @if (session('date_warning'))
            <div class="border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                <div class="flex items-start gap-2">
                    <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <div>
                        <p class="font-medium">Date conflict</p>
                        <p class="mt-1">{{ session('date_warning') }}</p>
                        @if ($enquiry->product)
                            <a href="{{ route('account.products.edit', $enquiry->product) }}" class="mt-2 inline-flex items-center gap-1 text-sm font-medium text-amber-900 underline hover:text-amber-700">
                                View product calendar
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="font-serif text-[24px] sm:text-[28px] tracking-wide text-gray-900">{{ $enquiry->customer_name }}</h1>
            <span class="inline-flex px-3 py-1 text-xs font-medium
                {{ $enquiry->status === 'new' ? 'bg-amber-100 text-amber-700' : '' }}
                {{ $enquiry->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                {{ $enquiry->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $enquiry->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
            ">{{ ucfirst($enquiry->status) }}</span>
        </div>

        <div class="border border-gray-200 p-6">
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
                    <dd class="mt-1 text-sm text-gray-900">
                        @if ($enquiry->product)
                            <a href="{{ route('account.products.edit', $enquiry->product) }}" class="underline hover:text-gray-600">{{ $enquiry->product->name }}</a>
                            <a href="{{ route('products.show', [$enquiry->product->boutique, $enquiry->product]) }}" target="_blank" class="ml-2 inline-flex items-center gap-0.5 text-xs text-gray-500 hover:text-gray-700">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                View page
                            </a>
                        @else
                            —
                        @endif
                    </dd>
                </div>
                @if ($enquiry->variant)
                    <div>
                        <dt class="text-xs font-medium uppercase text-gray-500">Size</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $enquiry->variant->size }}</dd>
                    </div>
                @endif
                @if ($enquiry->desired_dates)
                    <div>
                        <dt class="text-xs font-medium uppercase text-gray-500">Event Date</dt>
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

        {{-- Status actions --}}
        @if ($enquiry->status === 'new' || $enquiry->status === 'confirmed')
        <div class="flex flex-wrap items-center gap-3 border-t border-gray-200 pt-6">
            @if ($enquiry->status === 'new')
                <form method="POST" action="{{ route('account.enquiries.update', $enquiry) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="bg-black px-5 py-2 text-xs font-semibold tracking-wide text-white hover:bg-gray-800">
                        CONFIRM BOOKING
                    </button>
                </form>
                <form method="POST" action="{{ route('account.enquiries.update', $enquiry) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="border border-gray-300 px-5 py-2 text-xs font-semibold tracking-wide text-gray-700 hover:bg-gray-50">
                        DECLINE
                    </button>
                </form>
            @elseif ($enquiry->status === 'confirmed')
                <form method="POST" action="{{ route('account.enquiries.update', $enquiry) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="bg-black px-5 py-2 text-xs font-semibold tracking-wide text-white hover:bg-gray-800">
                        MARK COMPLETED
                    </button>
                </form>
                <form method="POST" action="{{ route('account.enquiries.update', $enquiry) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="border border-gray-300 px-5 py-2 text-xs font-semibold tracking-wide text-gray-700 hover:bg-gray-50">
                        CANCEL
                    </button>
                </form>
            @endif
        </div>
        @endif
    </div>
</x-layouts.account>
