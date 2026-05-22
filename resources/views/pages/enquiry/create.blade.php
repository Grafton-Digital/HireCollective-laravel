<x-layouts.public>
    <x-slot:title>Enquire — {{ $product->name }} — Hire Collective</x-slot:title>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 bg-cream-50 px-[60px] py-3">
        <a href="{{ route('home') }}" class="text-xs text-[#666] hover:underline">Home</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <a href="{{ route('products.show', [$product->boutique, $product]) }}" class="text-xs text-[#666] hover:underline">{{ $product->name }}</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <span class="text-xs text-black">Enquire</span>
    </div>

    <section class="bg-cream-50 px-[60px] py-10">
        <div class="mx-auto max-w-xl">
            <h1 class="font-serif text-[32px] italic text-black">Enquire About This Item</h1>
            <p class="mt-2 text-[13px] text-[#666]">{{ $product->name }} from {{ $product->boutique->name }}</p>

            <form method="POST" action="{{ route('enquiry.store') }}" class="mt-8 flex flex-col gap-5">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                @if ($product->is_variable && $product->variants->isNotEmpty())
                    <div class="flex flex-col gap-1.5">
                        <label for="product_variant_id" class="text-[11px] font-semibold tracking-[1px] text-black">SIZE</label>
                        <select name="product_variant_id" id="product_variant_id" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                            <option value="">Select a size</option>
                            @foreach ($product->variants as $variant)
                                <option value="{{ $variant->id }}">{{ $variant->size }} — €{{ number_format($variant->price, 2) }}</option>
                            @endforeach
                        </select>
                        @error('product_variant_id') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div class="flex flex-col gap-1.5">
                    <label for="customer_name" class="text-[11px] font-semibold tracking-[1px] text-black">YOUR NAME</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                           class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    @error('customer_name') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="customer_email" class="text-[11px] font-semibold tracking-[1px] text-black">EMAIL</label>
                    <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" required
                           class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    @error('customer_email') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="customer_phone" class="text-[11px] font-semibold tracking-[1px] text-black">PHONE (OPTIONAL)</label>
                    <input type="tel" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}"
                           class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    @error('customer_phone') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="desired_dates" class="text-[11px] font-semibold tracking-[1px] text-black">PREFERRED DATES</label>
                    <input type="text" name="desired_dates" id="desired_dates" value="{{ old('desired_dates') }}"
                           placeholder="e.g. 15–17 June 2026"
                           class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    @error('desired_dates') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="message" class="text-[11px] font-semibold tracking-[1px] text-black">MESSAGE</label>
                    <textarea name="message" id="message" rows="4" required
                              class="w-full border border-[#D0D0D0] bg-white px-3 py-2.5 text-[13px] text-[#333]">{{ old('message') }}</textarea>
                    @error('message') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="mt-2 flex h-12 items-center justify-center bg-black text-[13px] font-semibold tracking-[1.5px] text-white hover:bg-gray-800">
                    SEND ENQUIRY
                </button>
            </form>
        </div>
    </section>
</x-layouts.public>
