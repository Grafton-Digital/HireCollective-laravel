<x-layouts.public>
    <div class="mx-auto max-w-2xl px-4 py-12 md:py-20">
        <div class="bg-white p-8 shadow-lg md:p-12">
            <div class="mb-8 text-center">
                <h1 class="font-serif text-3xl tracking-wide text-black md:text-4xl">Create Your Boutique</h1>
                <p class="mt-3 text-sm text-gray-600">Submit your boutique application. We review each request within 48 hours.</p>
            </div>

            <form method="POST" action="{{ route('boutique.application.store') }}" enctype="multipart/form-data" class="space-y-6"
                x-data="applicationForm()"
                @submit.prevent="submitForm"
                @file-selected-logo.window="logoFile = $event.detail"
                @file-selected-cover.window="coverFile = $event.detail">
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
                        class="mt-2 block w-full border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Logo and Cover Image --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700 mb-2">Images</label>
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Logo --}}
                        <div x-data="fileUpload('logo')" x-ref="logoUpload">
                            <label class="mb-2 block text-xs font-medium text-gray-700">Logo</label>
                            <div
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                @click="$refs.fileInput.click()"
                                :class="isDragging ? 'border-gray-900 bg-gray-50' : 'border-gray-300'"
                                class="relative flex h-32 cursor-pointer flex-col items-center justify-center border-2 border-dashed bg-white transition-colors hover:border-gray-400"
                            >
                                <template x-if="!preview">
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <p class="mt-2 text-xs text-gray-500">Drag & drop or click</p>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <div class="relative h-full w-full">
                                        <img :src="preview" class="h-full w-full object-cover">
                                        <button
                                            type="button"
                                            @click.stop="clearFile()"
                                            class="absolute right-2 top-2 flex h-6 w-6 items-center justify-center bg-black bg-opacity-50 text-white hover:bg-opacity-70"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <input
                                type="file"
                                name="logo"
                                x-ref="fileInput"
                                @change="handleFileSelect($event)"
                                accept="image/*"
                                class="hidden"
                            >
                            @error('logo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Cover Image --}}
                        <div x-data="fileUpload('cover_image')" x-ref="coverUpload">
                            <label class="mb-2 block text-xs font-medium text-gray-700">Cover Photo</label>
                            <div
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                @click="$refs.fileInput.click()"
                                :class="isDragging ? 'border-gray-900 bg-gray-50' : 'border-gray-300'"
                                class="relative flex h-32 cursor-pointer flex-col items-center justify-center border-2 border-dashed bg-white transition-colors hover:border-gray-400"
                            >
                                <template x-if="!preview">
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <p class="mt-2 text-xs text-gray-500">Drag & drop or click</p>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <div class="relative h-full w-full">
                                        <img :src="preview" class="h-full w-full object-cover">
                                        <button
                                            type="button"
                                            @click.stop="clearFile()"
                                            class="absolute right-2 top-2 flex h-6 w-6 items-center justify-center bg-black bg-opacity-50 text-white hover:bg-opacity-70"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <input
                                type="file"
                                name="cover_image"
                                x-ref="fileInput"
                                @change="handleFileSelect($event)"
                                accept="image/*"
                                class="hidden"
                            >
                            @error('cover_image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">PNG, JPG up to 5MB. Logo: square, Cover: 1200×400 recommended</p>
                </div>

                <div>
                    <label for="bio" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">Short Bio</label>
                    <textarea
                        name="bio"
                        id="bio"
                        rows="4"
                        required
                        placeholder="Tell us about your boutique, your style, and what makes you unique..."
                        class="mt-2 block w-full border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >{{ old('bio') }}</textarea>
                    @error('bio') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="region" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">County</label>
                    <select
                        name="region"
                        id="region"
                        required
                        class="mt-2 block w-full border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                        <option value="">Select your county</option>
                        @foreach (App\County::cases() as $county)
                            <option value="{{ $county->value }}" {{ old('region') == $county->value ? 'selected' : '' }}>{{ $county->getLabel() }}</option>
                        @endforeach
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
                                    class="block w-full border-gray-300 py-3 pl-10 pr-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                                    class="block w-full border-gray-300 py-3 pl-10 pr-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                                    class="block w-full border-gray-300 py-3 pl-10 pr-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                                class="mt-1 block w-full border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                                class="mt-1 block w-full border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                                class="mt-1 block w-full border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full bg-black px-6 py-4 text-xs font-semibold uppercase tracking-wider text-white transition hover:bg-gray-800"
                    >
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function applicationForm() {
            return {
                logoFile: null,
                coverFile: null,
                submitForm(e) {
                    const form = e.target;
                    const formData = new FormData(form);

                    if (this.logoFile) {
                        formData.set('logo', this.logoFile);
                    }

                    if (this.coverFile) {
                        formData.set('cover_image', this.coverFile);
                    }

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok || response.redirected) {
                            window.location.href = '{{ route("boutique.application.confirmation") }}';
                        } else {
                            return response.json().then(data => {
                                if (data.errors) {
                                    let errorMsg = 'Please fix the following errors:\n';
                                    Object.values(data.errors).forEach(errors => {
                                        errors.forEach(error => errorMsg += '- ' + error + '\n');
                                    });
                                    alert(errorMsg);
                                } else {
                                    alert('Error: ' + (data.message || 'Failed to submit application'));
                                }
                            });
                        }
                    })
                    .catch(error => {
                        alert('Failed to submit application. Please try again.');
                    });
                }
            }
        }

        function fileUpload(fieldName) {
            return {
                preview: null,
                file: null,
                isDragging: false,
                fieldName: fieldName,
                handleFileSelect(e) {
                    const file = e.target.files[0];
                    this.processFile(file);
                },
                handleDrop(e) {
                    this.isDragging = false;
                    const file = e.dataTransfer.files[0];
                    this.processFile(file);
                },
                processFile(file) {
                    if (file && file.type.startsWith('image/')) {
                        this.file = file;

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.preview = e.target.result;
                        };
                        reader.readAsDataURL(file);

                        // Dispatch event based on field name
                        const eventName = this.fieldName === 'logo' ? 'file-selected-logo' : 'file-selected-cover';
                        window.dispatchEvent(new CustomEvent(eventName, { detail: file }));
                    }
                },
                clearFile() {
                    this.preview = null;
                    this.file = null;
                    this.$refs.fileInput.value = '';

                    const eventName = this.fieldName === 'logo' ? 'file-selected-logo' : 'file-selected-cover';
                    window.dispatchEvent(new CustomEvent(eventName, { detail: null }));
                }
            }
        }
    </script>
</x-layouts.public>
