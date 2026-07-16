<x-layouts.account>
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-900">Settings</h1>
        <p class="mt-2 text-sm text-gray-600">Manage your account preferences and security</p>
    </div>

    <div x-data="{ tab: '{{ session('tab', 'account') }}' }" class="mt-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex gap-8">
                <button
                    @click="tab = 'account'"
                    :class="tab === 'account' ? 'border-gray-900 text-gray-900 font-medium' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="border-b-2 px-1 py-4 text-sm"
                >
                    Account
                </button>
                <button
                    @click="tab = 'security'"
                    :class="tab === 'security' ? 'border-gray-900 text-gray-900 font-medium' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="border-b-2 px-1 py-4 text-sm"
                >
                    Security
                </button>
            </nav>
        </div>

        <div class="mt-8">
            <div x-show="tab === 'account'" class="max-w-4xl">
                <div class="rounded-lg bg-white p-6 shadow">
                    <h3 class="text-lg font-semibold text-gray-900">Boutique Information</h3>
                    <p class="mt-1 text-sm text-gray-600">Update your boutique profile and contact details.</p>

                    <form method="POST" action="{{ route('account.update') }}" class="mt-6">
                        @csrf
                        @method('PATCH')

                        @php
                            $boutique = $user->boutique;
                        @endphp

                        <div class="space-y-5">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="boutique_name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Boutique Name</label>
                                    <input
                                        type="text"
                                        name="boutique_name"
                                        id="boutique_name"
                                        value="{{ old('boutique_name', $boutique?->name) }}"
                                        required
                                        class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    @error('boutique_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="contact_email" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Email</label>
                                    <input
                                        type="email"
                                        name="contact_email"
                                        id="contact_email"
                                        value="{{ old('contact_email', $boutique?->contact_email) }}"
                                        required
                                        class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    @error('contact_email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="category" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Category</label>
                                    <input
                                        type="text"
                                        name="category"
                                        id="category"
                                        value="{{ old('category', 'Occasion Wear, Knitwear') }}"
                                        class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    @error('category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="phone" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">WhatsApp</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        value="{{ old('phone', $boutique?->phone) }}"
                                        placeholder="+44 7700 900000"
                                        class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="location" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Location</label>
                                    <input
                                        type="text"
                                        name="location"
                                        id="location"
                                        value="{{ old('location', $boutique ? $boutique->city.', '.$boutique->county : '') }}"
                                        placeholder="London, UK"
                                        class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    @error('location') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="instagram" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Instagram</label>
                                    <input
                                        type="text"
                                        name="instagram"
                                        id="instagram"
                                        value="{{ old('instagram', $boutique?->social_links['instagram'] ?? '') }}"
                                        placeholder="@thecompletelook"
                                        class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    @error('instagram') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="founded" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Founded</label>
                                    <input
                                        type="text"
                                        name="founded"
                                        id="founded"
                                        value="{{ old('founded', $boutique?->created_at?->format('Y')) }}"
                                        placeholder="2019"
                                        class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    @error('founded') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="status" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Status</label>
                                    <input
                                        type="text"
                                        value="Active"
                                        disabled
                                        class="block w-full border-gray-300 bg-gray-50 text-sm text-gray-500 shadow-sm"
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="description" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Short Bio</label>
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="4"
                                    class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                >{{ old('description', $boutique?->description) }}</textarea>
                                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button
                                type="submit"
                                class="rounded-md bg-gray-900 px-6 py-2 text-sm font-medium text-white hover:bg-gray-800"
                            >
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div x-show="tab === 'security'" class="max-w-2xl" style="display: none;">
                <div class="rounded-lg bg-white p-6 shadow">
                    <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
                    <p class="mt-1 text-sm text-gray-600">Update your password to keep your account secure.</p>

                    <form method="POST" action="{{ route('account.password.update') }}" class="mt-6" x-data="passwordForm()">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-5">
                            <div>
                                <label for="current_password" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Current Password</label>
                                <div class="relative">
                                    <input
                                        :type="showCurrent ? 'text' : 'password'"
                                        name="current_password"
                                        id="current_password"
                                        required
                                        class="block w-full rounded-md border-gray-300 pr-10 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    <button
                                        type="button"
                                        @click="showCurrent = !showCurrent"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3"
                                    >
                                        <svg x-show="!showCurrent" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                        <svg x-show="showCurrent" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('current_password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">New Password</label>
                                <div class="relative">
                                    <input
                                        :type="showNew ? 'text' : 'password'"
                                        name="password"
                                        id="password"
                                        x-model="newPassword"
                                        @input="validatePassword"
                                        required
                                        placeholder="Enter new password"
                                        class="block w-full rounded-md border-gray-300 pr-10 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    <button
                                        type="button"
                                        @click="showNew = !showNew"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3"
                                    >
                                        <svg x-show="!showNew" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                        <svg x-show="showNew" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="mt-3 space-y-2 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg :class="checks.length ? 'text-green-500' : 'text-gray-300'" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="10"/>
                                        </svg>
                                        <span :class="checks.length ? 'text-gray-900' : ''">At least 8 characters</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg :class="checks.uppercase ? 'text-green-500' : 'text-gray-300'" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="10"/>
                                        </svg>
                                        <span :class="checks.uppercase ? 'text-gray-900' : ''">One uppercase letter</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg :class="checks.numberOrSpecial ? 'text-green-500' : 'text-gray-300'" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="10"/>
                                        </svg>
                                        <span :class="checks.numberOrSpecial ? 'text-gray-900' : ''">One number or special character</span>
                                    </div>
                                </div>

                                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Confirm New Password</label>
                                <div class="relative">
                                    <input
                                        :type="showConfirm ? 'text' : 'password'"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        required
                                        placeholder="Repeat new password"
                                        class="block w-full rounded-md border-gray-300 pr-10 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                    <button
                                        type="button"
                                        @click="showConfirm = !showConfirm"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3"
                                    >
                                        <svg x-show="!showConfirm" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                        <svg x-show="showConfirm" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button
                                type="button"
                                onclick="window.location.reload()"
                                class="rounded-md border border-gray-300 bg-white px-6 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="rounded-md bg-gray-900 px-6 py-2 text-sm font-medium text-white hover:bg-gray-800"
                            >
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function passwordForm() {
            return {
                newPassword: '',
                showCurrent: false,
                showNew: false,
                showConfirm: false,
                checks: {
                    length: false,
                    uppercase: false,
                    numberOrSpecial: false
                },
                validatePassword() {
                    this.checks.length = this.newPassword.length >= 8;
                    this.checks.uppercase = /[A-Z]/.test(this.newPassword);
                    this.checks.numberOrSpecial = /[0-9!@#$%^&*(),.?":{}|<>]/.test(this.newPassword);
                }
            }
        }
    </script>
</x-layouts.account>
