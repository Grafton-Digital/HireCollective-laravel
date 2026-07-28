<x-layouts.public>
    <x-slot:title>Reset Password — Hire Collective</x-slot:title>

    <div class="mx-auto max-w-[460px] px-4 py-12 md:py-20">
        <div class="bg-white p-8 shadow-lg md:p-10">

            {{-- Title --}}
            <h1 class="font-serif text-3xl tracking-wide text-center text-black md:text-4xl">Reset Password</h1>

            {{-- Description --}}
            <p class="mt-4 text-center text-[13px] text-[#666]">Enter your email address and we'll send you a link to reset your password.</p>

            {{-- Divider --}}
            <div class="mt-6 h-px bg-[#E0E0E0]"></div>

            {{-- Session Status --}}
            <x-auth-session-status class="mt-4" :status="session('status')" />

            {{-- Form --}}
            <form method="POST" action="{{ route('password.email') }}" class="mt-6">
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

                {{-- Submit button --}}
                <button type="submit" class="mt-6 flex h-12 w-full items-center justify-center bg-black text-[13px] font-semibold tracking-[2px] text-white hover:bg-gray-800">
                    SEND RESET LINK
                </button>
            </form>

            {{-- Divider with OR --}}
            <div class="mt-6 flex items-center gap-3">
                <div class="h-px flex-1 bg-[#E0E0E0]"></div>
                <span class="text-xs text-[#999]">OR</span>
                <div class="h-px flex-1 bg-[#E0E0E0]"></div>
            </div>

            {{-- Back to login --}}
            <a href="{{ route('login') }}" class="mt-6 flex h-12 w-full items-center justify-center gap-2 border border-black text-[13px] font-medium text-black hover:bg-black hover:text-white">
                Back to Sign In
            </a>

            {{-- Help text --}}
            <p class="mt-6 text-center text-xs text-[#999]">Need help? Contact us at support@nyknitwear.com</p>
        </div>
    </div>
</x-layouts.public>
