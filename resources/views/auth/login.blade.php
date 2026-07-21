<x-layouts.public>
    <x-slot:title>Boutique Portal — Hire Collective</x-slot:title>

    <div class="mx-auto max-w-[460px] px-4 py-12 md:py-20">
        <div class="bg-white p-8 shadow-lg md:p-10" x-data="{ showPassword: false }">

            {{-- Title --}}
            <h1 class="font-serif text-3xl tracking-wide text-center text-black md:text-4xl">Boutique Portal</h1>

            {{-- Notice --}}
            <div class="mt-4 flex items-center gap-2.5 bg-cream-100 px-4 py-3">
                <svg class="h-5 w-5 flex-shrink-0 text-gold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                </svg>
                <span class="text-[13px] text-[#333]">This login is for boutique owners only</span>
            </div>

            {{-- Divider --}}
            <div class="mt-6 h-px bg-[#E0E0E0]"></div>

            {{-- Session Status --}}
            <x-auth-session-status class="mt-4" :status="session('status')" />

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="text-2xs font-semibold tracking-[1px] text-black">EMAIL</label>
                    <div class="relative mt-1.5">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-[#999]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               placeholder="your@boutique-email.com"
                               class="h-12 w-full border border-[#D0D0D0] bg-cream-50 pl-10 pr-4 text-[13px] text-black placeholder-[#999] focus:border-cream-200 focus:outline-none focus:ring-1 focus:ring-gray-200">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mt-5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-2xs font-semibold tracking-[1px] text-black">PASSWORD</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-gold hover:underline">Forgot password?</a>
                        @endif
                    </div>
                    <div class="relative mt-1.5">
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password"
                               placeholder="Enter your password"
                               class="h-12 w-full border border-[#D0D0D0] bg-cream-50 pl-4 pr-10 text-[13px] text-black placeholder-[#999] focus:border-cream-200 focus:outline-none focus:ring-1 focus:ring-gray-200">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg x-show="!showPassword" class="h-5 w-5 text-[#999]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5 text-[#999]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="display: none;">
                                <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Sign In button --}}
                <button type="submit" class="mt-6 flex h-12 w-full items-center justify-center bg-black text-[13px] font-semibold tracking-[2px] text-white hover:bg-gray-800">
                    SIGN IN
                </button>
            </form>

            {{-- Divider with OR --}}
            <div class="mt-6 flex items-center gap-3">
                <div class="h-px flex-1 bg-[#E0E0E0]"></div>
                <span class="text-xs text-[#999]">OR</span>
                <div class="h-px flex-1 bg-[#E0E0E0]"></div>
            </div>

            {{-- Register boutique --}}
            <a href="{{ route('boutique.application.create') }}" class="mt-6 flex h-12 w-full items-center justify-center gap-2 border border-black text-[13px] font-medium text-black hover:bg-black hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                </svg>
                Register Your Boutique
            </a>

            {{-- Help text --}}
            <p class="mt-6 text-center text-xs text-[#999]">Need help? Contact us at support@nyknitwear.com</p>
        </div>
    </div>
</x-layouts.public>
