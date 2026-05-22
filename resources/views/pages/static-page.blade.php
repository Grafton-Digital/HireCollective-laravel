<x-layouts.public>
    <x-slot:title>{{ $page->title }} — Hire Collective</x-slot:title>

    <section class="bg-cream-50 px-[60px] py-12">
        <div class="mx-auto max-w-3xl">
            <h1 class="font-serif text-[36px] italic text-black">{{ $page->title }}</h1>
            <div class="prose mt-8 max-w-none text-[13px] leading-[1.7] text-[#333]">
                {!! Str::markdown($page->content ?? '') !!}
            </div>
        </div>
    </section>
</x-layouts.public>
