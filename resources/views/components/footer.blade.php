<footer>
    <div class="bg-[#1A1A1A] px-[60px] py-12">
        <div class="flex flex-col gap-10 md:flex-row md:gap-10">
            <div class="flex-1">
                <p class="font-serif text-[24px] tracking-[2px] text-white">HIRE COLLECTIVE</p>
                <p class="mt-3 text-[14px] leading-relaxed text-[#AAA]">Ireland's luxury multi-boutique fashion hire marketplace. Discover, hire, and wear designer pieces from trusted Irish boutiques.</p>
            </div>
            <div class="flex-1">
                <p class="text-[11px] font-semibold tracking-[1px] text-white">EXPLORE</p>
                <div class="mt-3 flex flex-col gap-2">
                    <a href="{{ route('boutiques.index') }}" class="text-[14px] text-[#AAA] hover:text-white">All Boutiques</a>
                    <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="text-[14px] text-[#AAA] hover:text-white">Dresses</a>
                    <a href="{{ route('products.index', ['category' => 'hats']) }}" class="text-[14px] text-[#AAA] hover:text-white">Hats</a>
                    <a href="{{ route('products.index', ['category' => 'bags']) }}" class="text-[14px] text-[#AAA] hover:text-white">Bags</a>
                </div>
            </div>
            <div class="flex-1">
                <p class="text-[11px] font-semibold tracking-[1px] text-white">COMPANY</p>
                <div class="mt-3 flex flex-col gap-2">
                    <a href="#" class="text-[14px] text-[#AAA] hover:text-white">How it works</a>
                    <a href="#" class="text-[14px] text-[#AAA] hover:text-white">Terms & Conditions</a>
                    <a href="#" class="text-[14px] text-[#AAA] hover:text-white">Privacy Policy</a>
                </div>
            </div>
            <div class="flex-1">
                <p class="text-[11px] font-semibold tracking-[1px] text-white">GET IN TOUCH</p>
                <p class="mt-3 text-[14px] text-[#AAA]">hello@hirecollective.ie</p>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between bg-[#111] px-[60px] py-4">
        <p class="text-[11px] text-[#AAA]">&copy; {{ date('Y') }} Hire Collective. All rights reserved.</p>
        <div class="flex items-center gap-5">
            <a href="#" class="text-[11px] text-[#AAA] hover:text-white">Terms</a>
            <a href="#" class="text-[11px] text-[#AAA] hover:text-white">Privacy</a>
            <a href="#" class="text-[11px] text-[#AAA] hover:text-white">Cookies</a>
        </div>
    </div>
</footer>
