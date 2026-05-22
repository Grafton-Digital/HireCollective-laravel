@props(['categories', 'colours', 'occasions', 'boutiques'])

{{-- Mobile filter drawer --}}
<aside class="w-full shrink-0 lg:hidden" x-data="{ open: false }">
    <button @click="open = !open" class="flex w-full items-center justify-center gap-2 border border-[#D0D0D0] py-2.5 text-[11px] font-semibold tracking-[1px]">
        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/></svg>
        FILTERS
    </button>

    <form method="GET" action="{{ route('products.index') }}" class="mt-4 flex flex-col gap-4" x-show="open" x-transition>
        <select name="category" class="h-9 border border-[#D0D0D0] px-3 text-xs">
            <option value="">Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>

        <select name="colour" class="h-9 border border-[#D0D0D0] px-3 text-xs">
            <option value="">Colour</option>
            @foreach ($colours as $colour)
                <option value="{{ $colour->slug }}" {{ request('colour') === $colour->slug ? 'selected' : '' }}>{{ $colour->name }}</option>
            @endforeach
        </select>

        <select name="occasion" class="h-9 border border-[#D0D0D0] px-3 text-xs">
            <option value="">Occasion</option>
            @foreach ($occasions as $occasion)
                <option value="{{ $occasion->slug }}" {{ request('occasion') === $occasion->slug ? 'selected' : '' }}>{{ $occasion->name }}</option>
            @endforeach
        </select>

        <select name="boutique" class="h-9 border border-[#D0D0D0] px-3 text-xs">
            <option value="">Boutique</option>
            @foreach ($boutiques as $boutique)
                <option value="{{ $boutique->slug }}" {{ request('boutique') === $boutique->slug ? 'selected' : '' }}>{{ $boutique->name }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-black py-2.5 text-[11px] font-medium tracking-[1px] text-white">APPLY</button>
            <a href="{{ route('products.index') }}" class="flex flex-1 items-center justify-center border border-black py-2.5 text-[11px] tracking-[1px] text-black">CLEAR</a>
        </div>
    </form>
</aside>
