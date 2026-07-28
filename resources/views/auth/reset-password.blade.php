<x-layouts.public>
    <x-slot:title>New Password — Hire Collective</x-slot:title>

    <div class="mx-auto max-w-[460px] px-4 py-12 md:py-20">
        <div class="bg-white p-8 shadow-lg md:p-10" x-data="{ showPassword: false }">

            {{-- Title --}}
            <h1 class="font-serif text-3xl tracking-wide text-center text-black md:text-4xl">New Password</h1>

            {{-- Description --}}
            <p class="mt-4 text-center text-[13px] text-[#666]">Enter your new password below.</p>

            {{-- Divider --}}
            <div class="mt-6 h-px bg-[#E0E0E0]"></div>

            {{-- Form --}}
            <form method="POST" action="{{ route('password.store') }}" class="mt-6">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email --}}
                <div>
                    <label for="email" class="text-2xs font-semibold tracking-[1px] text-black">EMAIL</label>
                    <div class="relative mt-1.5">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-[#999]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                               placeholder="your@boutique-email.com"
                               class="h-12 w-full border border-[#D0D0D0] bg-cream-50 pl-10 pr-4 text-[13px] text-black placeholder-[#999] focus:border-cream-200 focus:outline-none focus:ring-1 focus:ring-gray-200">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mt-5">
                    <label for="password" class="text-2xs font-semibold tracking-[1px] text-black">NEW PASSWORD</label>
                    <div class="relative mt-1.5">
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password"
                               placeholder="Enter new password"
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

                {{-- Confirm Password --}}
                <div class="mt-5">
                    <label for="password_confirmation" class="text-2xs font-semibold tracking-[1px] text-black">CONFIRM PASSWORD</label>
                    <div class="relative mt-1.5">
                        <input id="password_confirmation" :type="showPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                               placeholder="Repeat new password"
                               class="h-12 w-full border border-[#D0D0D0] bg-cream-50 pl-4 pr-10 text-[13px] text-black placeholder-[#999] focus:border-cream-200 focus:outline-none focus:ring-1 focus:ring-gray-200">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Submit button --}}
                <button type="submit" class="mt-6 flex h-12 w-full items-center justify-center bg-black text-[13px] font-semibold tracking-[2px] text-white hover:bg-gray-800">
                    RESET PASSWORD
                </button>
            </form>

            {{-- Help text --}}
            <p class="mt-6 text-center text-xs text-[#999]">Need help? Contact us at support@nyknitwear.com</p>
        </div>
    </div>
</x-layouts.public>
