<x-layouts.public>
    <div class="mx-auto max-w-2xl px-4 py-12 md:py-20">
        <div class="rounded-lg bg-white p-8 shadow-lg md:p-12">
            <div class="mb-8 text-center">
                <h1 class="font-serif text-3xl tracking-wide text-black md:text-4xl">Create Your Boutique</h1>
                <p class="mt-3 text-sm text-gray-600">Submit your boutique application. We review each request within 48 hours.</p>
            </div>

            <form method="POST" action="{{ route('boutique.application.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">Boutique Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Enter your boutique name"
                        class="mt-2 block w-full rounded-md border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="banner_image" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">Banner Image</label>
                    <div class="mt-2 flex items-center justify-center rounded-md border-2 border-dashed border-gray-300 px-6 py-12 text-center">
                        <div>
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4 flex text-sm text-gray-600">
                                <label for="banner_image" class="relative cursor-pointer rounded-md font-medium text-black hover:underline">
                                    <span>Click to upload or drag and drop</span>
                                    <input id="banner_image" name="banner_image" type="file" accept="image/*" required class="sr-only">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG up to 5MB (1200×400 recommended)</p>
                        </div>
                    </div>
                    @error('banner_image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="bio" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">Short Bio</label>
                    <textarea
                        name="bio"
                        id="bio"
                        rows="4"
                        required
                        placeholder="Tell us about your boutique, your style, and what makes you unique..."
                        class="mt-2 block w-full rounded-md border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >{{ old('bio') }}</textarea>
                    @error('bio') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="region" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">Region</label>
                    <select
                        name="region"
                        id="region"
                        required
                        class="mt-2 block w-full rounded-md border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                        <option value="">Select your region</option>
                        <option value="Dublin" {{ old('region') == 'Dublin' ? 'selected' : '' }}>Dublin</option>
                        <option value="Cork" {{ old('region') == 'Cork' ? 'selected' : '' }}>Cork</option>
                        <option value="Galway" {{ old('region') == 'Galway' ? 'selected' : '' }}>Galway</option>
                        <option value="Limerick" {{ old('region') == 'Limerick' ? 'selected' : '' }}>Limerick</option>
                        <option value="Waterford" {{ old('region') == 'Waterford' ? 'selected' : '' }}>Waterford</option>
                        <option value="Other" {{ old('region') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('region') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="border-t pt-6">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-gray-700">Contact Links</p>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div>
                            <label for="contact_email" class="sr-only">Email</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    name="contact_email"
                                    id="contact_email"
                                    value="{{ old('contact_email') }}"
                                    required
                                    placeholder="your@email.com"
                                    class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                >
                            </div>
                            @error('contact_email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="phone" class="sr-only">Phone</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <input
                                    type="tel"
                                    name="phone"
                                    id="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="+44 000 000 000"
                                    class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                >
                            </div>
                            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="instagram" class="sr-only">Instagram</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    name="instagram"
                                    id="instagram"
                                    value="{{ old('instagram') }}"
                                    placeholder="@handle"
                                    class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                >
                            </div>
                            @error('instagram') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-gray-700">Account</p>

                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="your@email.com"
                                class="mt-1 block w-full rounded-md border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                placeholder="Create a password"
                                class="mt-1 block w-full rounded-md border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                required
                                placeholder="Repeat your password"
                                class="mt-1 block w-full rounded-md border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full rounded-md bg-black px-6 py-4 text-xs font-semibold uppercase tracking-wider text-white transition hover:bg-gray-800"
                    >
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.public>
