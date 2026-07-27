<x-layouts.public>
    <x-slot:title>{{ $page->content['heading'] ?? $page->title }} — Hire Collective</x-slot:title>

    <section class="px-6 md:px-[60px] py-16">
        <div class="mx-auto max-w-[1000px]">

            <div class="mb-12 text-center">
                <p class="mb-4 text-xs font-medium uppercase tracking-[2px] text-[#C5A882]">SUPPORT</p>
                <h1 class="font-serif text-[48px] font-normal leading-[1.2] text-black">{{ $page->content['heading'] ?? $page->title }}</h1>
                @if (!empty($page->content['subtitle']))
                    <p class="mt-4 text-sm leading-relaxed text-[#666]">{{ $page->content['subtitle'] }}</p>
                @endif
            </div>

            @if (!empty($page->content['faq']))
                <div x-data="{ openItem: 0 }">
                    @foreach ($page->content['faq'] as $index => $item)
                        <div class="overflow-hidden border {{ $index === 0 ? '' : 'border-t-0' }} border-[#E3E3E0] bg-white">
                            <button
                                @click="openItem = (openItem === {{ $index }} ? null : {{ $index }})"
                                class="flex w-full items-center justify-between px-8 py-6 text-left transition-colors hover:bg-cream-50"
                            >
                                <h3 class="text-base font-medium text-black">{{ $item['question'] }}</h3>
                                <svg
                                    class="h-5 w-5 text-black transition-transform duration-300"
                                    :class="{ 'rotate-180': openItem === {{ $index }} }"
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
                                :class="openItem === {{ $index }} ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                            >
                                <div class="overflow-hidden">
                                    <div class="px-8 pb-6 transition-opacity duration-500">
                                        <p class="text-sm leading-relaxed text-[#666]">{{ $item['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="px-6 md:px-[60px] py-16 bg-cream-50">
        <div class="text-center">
            <h2 class="font-serif text-[36px] font-normal leading-[1.2] text-black">Still have questions?</h2>
            <p class="mx-auto mt-4 max-w-[480px] text-sm leading-relaxed text-[#666]">
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
