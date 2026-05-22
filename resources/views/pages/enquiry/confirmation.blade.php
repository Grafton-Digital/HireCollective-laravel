<x-layouts.public>
    <x-slot:title>Enquiry Sent — Hire Collective</x-slot:title>

    <section class="flex flex-col items-center bg-cream-50 px-[60px] py-24 text-center">
        <svg class="h-12 w-12 text-[#2E7D32]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
        <h1 class="mt-4 font-serif text-[32px] italic text-black">Enquiry Sent</h1>
        <p class="mt-3 max-w-md text-sm leading-relaxed text-[#333]">
            Thank you! Your enquiry about <strong>{{ session('enquiry_product', 'this item') }}</strong> has been sent to the boutique.
            They'll get back to you by email shortly.
        </p>
        <a href="{{ route('products.index') }}" class="mt-8 bg-black px-8 py-3 text-xs font-medium tracking-[1.5px] text-white hover:bg-gray-800">
            CONTINUE BROWSING
        </a>
    </section>
</x-layouts.public>
