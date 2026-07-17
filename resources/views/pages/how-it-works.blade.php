<x-layouts.public>
    <x-slot:title>How It Works — Hire Collective</x-slot:title>

    <section class="px-6 md:px-[60px] py-16">
        <div class="mx-auto max-w-[1000px]">
            
            <div class="mb-12 text-center">
                <p class="mb-4 text-xs font-medium uppercase tracking-[2px] text-[#C5A882]">SUPPORT</p>
                <h1 class="font-serif text-[48px] font-normal leading-[1.2] text-black">How It Works</h1>
                <p class="mt-4 text-sm leading-relaxed text-[#666]">Find answers to common questions about our platform, ordering, and delivery</p>
            </div>

            <div x-data="{ openItem: 1 }" class="bg-cream-50">

                <div class="overflow-hidden border border-[#E3E3E0] bg-white">
                    <button
                        @click="openItem = (openItem === 1 ? null : 1)"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">How do I place an order?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 1 }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 1 ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                Browse our boutique collections, select the items you love, and add them to your bag. At checkout, choose your preferred delivery option and complete payment. You'll receive an order confirmation email with tracking details within 24 hours.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden border border-b-[#E3E3E0] bg-white mt-[-1px]">
                    <button
                        @click="openItem = (openItem === 2 ? null : 2)"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">What payment methods do you accept?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 2 }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 2 ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                We accept all major credit and debit cards including Visa, Mastercard, and American Express. We also support Apple Pay, Google Pay, and secure online banking payments for your convenience.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden border border-b-[#E3E3E0] bg-white mt-[-1px]">
                    <button
                        @click="openItem = (openItem === 3 ? null : 3)"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">How long does delivery take?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 3 }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 3 ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                Delivery times vary depending on the boutique and your location. Most orders arrive within 3–7 business days, while international shipping may take 7–14 business days.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden border border-[#E3E3E0] bg-white mt-[-1px]">
                    <button
                        @click="openItem = (openItem === 'return-exchange' ? null : 'return-exchange')"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">Can I return or exchange an item?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 'return-exchange' }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 'return-exchange' ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                Yes. Most boutiques accept returns or exchanges within 14 days of delivery, provided the item is unworn, unused, and in its original packaging. Return policies may vary by boutique.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden border border-[#E3E3E0] bg-white mt-[-1px]">
                    <button
                        @click="openItem = (openItem === 'payment-methods' ? null : 'payment-methods')"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">How are boutiques selected for the platform?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 'payment-methods' }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 'payment-methods' ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                We carefully curate every boutique on our platform based on quality, authenticity, customer service, and unique style. Our goal is to offer a trusted selection of premium fashion brands.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden border border-[#E3E3E0] bg-white mt-[-1px]">
                    <button
                        @click="openItem = (openItem === 'payment-methods' ? null : 'payment-methods')"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">Are the products authentic?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 'payment-methods' }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 'payment-methods' ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                Absolutely. Every product is sourced directly from our partner boutiques, ensuring that all items are 100% authentic and meet our quality standards.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden border border-[#E3E3E0] bg-white mt-[-1px]">
                    <button
                        @click="openItem = (openItem === 'payment-methods' ? null : 'payment-methods')"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">How do I track my order?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 'payment-methods' }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 'payment-methods' ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                Once your order has been shipped, you'll receive a confirmation email with a tracking number and a link to monitor your delivery in real time.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden border border-[#E3E3E0] bg-white mt-[-1px]">
                    <button
                        @click="openItem = (openItem === 'payment-methods' ? null : 'payment-methods')"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">What if an item is out of stock?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 'payment-methods' }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 'payment-methods' ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                If an item is unavailable, it will be marked as out of stock. Some boutiques may restock popular products, so we recommend checking back or contacting the boutique for availability.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden border border-[#E3E3E0] bg-white mt-[-1px]">
                    <button
                        @click="openItem = (openItem === 'payment-methods' ? null : 'payment-methods')"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">Do you offer gift wrapping?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 'payment-methods' }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 'payment-methods' ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                Gift wrapping is available for selected boutiques and products. If offered, you'll see the option during checkout before completing your purchase.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden border border-[#E3E3E0] bg-white mt-[-1px]">
                    <button
                        @click="openItem = (openItem === 'payment-methods' ? null : 'payment-methods')"
                        class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                    >
                        <h3 class="text-base font-medium text-black">How can I contact a specific boutique?</h3>
                        <svg
                            class="h-5 w-5 text-black transition-transform duration-300"
                            :class="{ 'rotate-180': openItem === 'payment-methods' }"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="openItem === 'payment-methods' ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="px-8 py-6 transition-opacity duration-500">
                            <p class="text-sm leading-relaxed text-[#666]">
                                Each boutique has its own profile page with contact information. You can also reach out through our platform, and we'll make sure your message gets to the boutique promptly.
                            </p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </section>

    <section class="px-6 md:px-[60px] py-16 bg-cream-50">

        {{-- Still have questions section --}}
        <div class="max-w-[465px] mx-auto text-center">
            <h2 class="font-serif text-[36px] font-normal leading-[1.2] text-black">Still have questions?</h2>
            <p class="mx-auto mt-4 max-w-[600px] text-sm leading-relaxed text-[#666]">
                Our support team is here to help. Reach out and we'll get back to you within 24 hours.
            </p>
            <a
                href="mailto:support@hirecollective.ie"
                class="mt-6 inline-flex items-center gap-2 bg-black px-8 py-3 text-xs font-medium uppercase tracking-[1.5px] text-white transition-colors hover:bg-gray-800"
            >
                Contact Us
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </a>
        </div>

    </section>
</x-layouts.public>
