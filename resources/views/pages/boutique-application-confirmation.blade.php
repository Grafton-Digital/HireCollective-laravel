<x-layouts.public>
    <div class="mx-auto max-w-2xl px-4 py-12 md:py-20">
        <div class="rounded-lg bg-white p-8 text-center shadow-lg md:p-12">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="font-serif text-3xl tracking-wide text-black md:text-4xl">Application Submitted!</h1>
            <p class="mt-4 text-gray-600">Thank you for your interest in joining Hire Collective.</p>
            <p class="mt-2 text-sm text-gray-500">
                We've received your boutique application and will review it within 48 hours.
                You'll receive an email at the address you provided once we've made a decision.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                <a
                    href="{{ route('home') }}"
                    class="rounded-md bg-black px-6 py-3 text-xs font-semibold uppercase tracking-wider text-white transition hover:bg-gray-800"
                >
                    Back to Home
                </a>
                <a
                    href="{{ route('boutiques.index') }}"
                    class="rounded-md border border-gray-300 px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-700 transition hover:bg-gray-50"
                >
                    Browse Boutiques
                </a>
            </div>
        </div>
    </div>
</x-layouts.public>
