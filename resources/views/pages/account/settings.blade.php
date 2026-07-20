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
                <div class=" bg-white p-6 shadow">
                    <h3 class="text-lg font-semibold text-gray-900">Boutique Information</h3>
                    <p class="mt-1 text-sm text-gray-600">Update your boutique profile and contact details.</p>

                    <form method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data" class="mt-6"
                        x-data="boutiqueForm()"
                        @submit.prevent="submitForm"
                        @file-selected-logo.window="logoFile = $event.detail"
                        @file-selected-cover.window="coverFile = $event.detail">
                        @csrf
                        @method('PATCH')

                        @php
                            $boutique = $user->boutique;
                        @endphp

                        <input type="hidden" name="remove_logo" x-ref="removeLogo" value="0">
                        <input type="hidden" name="remove_cover_image" x-ref="removeCover" value="0">

                        <div class="space-y-5">
                            <div class="grid grid-cols-2 gap-4">
                                <div x-data="fileUpload('logo', '{{ $boutique?->logo ? Storage::url($boutique->logo) : '' }}')" x-ref="logoUpload">
                                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Logo</label>
                                    <div
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="handleDrop($event)"
                                        @click="$refs.fileInput.click()"
                                        :class="isDragging ? 'border-gray-900 bg-gray-50' : 'border-gray-300'"
                                        class="relative flex h-32 cursor-pointer flex-col items-center justify-center border-2 border-dashed bg-white transition-colors hover:border-gray-400"
                                    >
                                        <template x-if="!preview && !existingImage">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                <p class="mt-2 text-xs text-gray-500">Drag & drop or click to upload</p>
                                            </div>
                                        </template>
                                        <template x-if="preview || existingImage">
                                            <div class="relative h-full w-full">
                                                <img :src="preview || existingImage" class="h-full w-full object-cover">
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

                                <div x-data="fileUpload('cover_image', '{{ $boutique?->cover_image ? Storage::url($boutique->cover_image) : '' }}')" x-ref="coverUpload">
                                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Cover Photo</label>
                                    <div
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="handleDrop($event)"
                                        @click="$refs.fileInput.click()"
                                        :class="isDragging ? 'border-gray-900 bg-gray-50' : 'border-gray-300'"
                                        class="relative flex h-32 cursor-pointer flex-col items-center justify-center border-2 border-dashed bg-white transition-colors hover:border-gray-400"
                                    >
                                        <template x-if="!preview && !existingImage">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                <p class="mt-2 text-xs text-gray-500">Drag & drop or click to upload</p>
                                            </div>
                                        </template>
                                        <template x-if="preview || existingImage">
                                            <div class="relative h-full w-full">
                                                <img :src="preview || existingImage" class="h-full w-full object-cover">
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
                                    <label for="county" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">County</label>
                                    <select
                                        name="county"
                                        id="county"
                                        required
                                        class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                        <option value="">Select your county</option>
                                        @foreach (App\County::cases() as $countyOption)
                                            <option value="{{ $countyOption->value }}" {{ old('county', $boutique?->county) == $countyOption->value ? 'selected' : '' }}>
                                                {{ $countyOption->getLabel() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('county') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
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
                                class=" bg-gray-900 px-6 py-2 text-sm font-medium text-white hover:bg-gray-800"
                            >
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div x-show="tab === 'security'" class="max-w-2xl" style="display: none;">
                <div class=" bg-white p-6 shadow">
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
                                        class="block w-full  border-gray-300 pr-10 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
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
                                        class="block w-full  border-gray-300 pr-10 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
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
                                        class="block w-full  border-gray-300 pr-10 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
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
                                class=" border border-gray-300 bg-white px-6 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class=" bg-gray-900 px-6 py-2 text-sm font-medium text-white hover:bg-gray-800"
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

        function boutiqueForm() {
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
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else if (response.ok) {
                            window.location.reload();
                        } else {
                            return response.json().then(data => {
                                alert('Error: ' + (data.message || 'Failed to save'));
                            });
                        }
                    })
                    .catch(error => {
                        alert('Failed to save changes');
                    });
                }
            }
        }

        function fileUpload(fieldName, existingUrl) {
            return {
                isDragging: false,
                preview: null,
                existingImage: existingUrl,
                currentFile: null,
                handleDrop(e) {
                    this.isDragging = false;
                    const files = e.dataTransfer.files;

                    if (files.length > 0 && files[0].type.startsWith('image/')) {
                        this.currentFile = files[0];
                        this.processFile(files[0]);

                        const eventName = fieldName === 'logo' ? 'file-selected-logo' : 'file-selected-cover';
                        window.dispatchEvent(new CustomEvent(eventName, { detail: files[0] }));

                        const form = this.$el.closest('form');
                        const removeInput = form.querySelector(fieldName === 'logo' ? 'input[name="remove_logo"]' : 'input[name="remove_cover_image"]');
                        if (removeInput) {
                            removeInput.value = '0';
                        }
                    }
                },
                handleFileSelect(e) {
                    const files = e.target.files;
                    if (files.length > 0 && files[0].type.startsWith('image/')) {
                        this.currentFile = files[0];
                        this.processFile(files[0]);

                        // Dispatch event to form (for consistency)
                        const eventName = fieldName === 'logo' ? 'file-selected-logo' : 'file-selected-cover';
                        window.dispatchEvent(new CustomEvent(eventName, { detail: files[0] }));

                        // Mark as not removing
                        const form = this.$el.closest('form');
                        const removeInput = form.querySelector(fieldName === 'logo' ? 'input[name="remove_logo"]' : 'input[name="remove_cover_image"]');
                        if (removeInput) {
                            removeInput.value = '0';
                        }
                    }
                },
                processFile(file) {
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.preview = e.target.result;
                            this.existingImage = null;
                        };
                        reader.readAsDataURL(file);
                    }
                },
                clearFile() {
                    this.preview = null;
                    this.existingImage = null;
                    this.currentFile = null;
                    this.$refs.fileInput.value = '';

                    // Dispatch event to clear file in form
                    const eventName = fieldName === 'logo' ? 'file-selected-logo' : 'file-selected-cover';
                    window.dispatchEvent(new CustomEvent(eventName, { detail: null }));

                    // Mark for removal on server (only if there was an existing image)
                    const form = this.$el.closest('form');
                    if (existingUrl) {
                        const removeInput = form.querySelector(fieldName === 'logo' ? 'input[name="remove_logo"]' : 'input[name="remove_cover_image"]');
                        if (removeInput) {
                            removeInput.value = '1';
                        }
                    }
                }
            }
        }
    </script>
</x-layouts.account>
