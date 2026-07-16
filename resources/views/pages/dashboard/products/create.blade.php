<x-layouts.account>
    <div class="bg-white p-8">
        <div class="mb-6">
            <h1 class="font-serif text-[24px] tracking-wide text-gray-900">Add New Product</h1>
        </div>

        <p class="mb-8 text-sm text-gray-500">Fill in the product details below. Fields marked with * are required.</p>

        <form method="POST" action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data"
            x-data="productForm()"
            @submit.prevent="submitForm"
            @file-selected-main.window="mainImage = $event.detail"
            @files-selected-gallery.window="galleryImages = $event.detail">
            @csrf

            <div class="grid grid-cols-2 gap-8">

                <div class="left-side">
                    
                    {{-- Product Name --}}
                    <div class="mb-6">
                        <label for="name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Product Name *</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            placeholder="e.g. Oversized Cashmere Sweater"
                            required
                            @input="generateSlug($event.target.value)"
                            class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                        >
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Price and Size --}}
                    <div class="mb-6 grid grid-cols-2 gap-4">
                        <div>
                            <label for="price_per_day" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Price From *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500">€</span>
                                <input
                                    type="number"
                                    name="price_per_day"
                                    id="price_per_day"
                                    value="{{ old('price_per_day') }}"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0"
                                    required
                                    class="block w-full border-gray-300 pl-8 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                >
                            </div>
                            @error('price_per_day') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="size" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Available Size</label>
                            <input
                                type="text"
                                name="size"
                                id="size"
                                value="{{ old('size') }}"
                                placeholder="e.g. 8, 10, 12, 14"
                                class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                            >
                            @error('size') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Colour and Category --}}
                    <div class="mb-6 grid grid-cols-2 gap-4">
                        <div>
                            <label for="color" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Colour *</label>
                            <input
                                type="text"
                                name="color"
                                id="color"
                                value="{{ old('color') }}"
                                placeholder="e.g. Cream, Black"
                                required
                                class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                            >
                            @error('color') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="category" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Category</label>
                            <select
                                name="category"
                                id="category"
                                class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                            >
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Designer --}}
                    <div class="mb-6">
                        <label for="designer" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Designer</label>
                        <input
                            type="text"
                            name="designer"
                            id="designer"
                            value="{{ old('designer') }}"
                            placeholder="Type designer name"
                            class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                        >
                        @error('designer') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-8">
                        <label for="description" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            placeholder="Describe your product — materials, fit, care instructions..."
                            class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                        >{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>


                    {{-- Availability Calendar --}}
                    <div class="mb-6" x-data="availabilityCalendar()">
                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Availability Calendar</label>
                        <p class="mb-4 text-xs text-gray-500">Click on dates to toggle availability. Green = available, Red = unavailable, Yellow = need to confirm</p>

                        <div class="border border-gray-200 p-4">
                            <div class="mb-4 flex items-center justify-between">
                                <button type="button" @click="previousMonth()" class="text-gray-400 hover:text-gray-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <span class="text-sm font-medium text-gray-900" x-text="monthYear"></span>
                                <button type="button" @click="nextMonth()" class="text-gray-400 hover:text-gray-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-7 gap-2">
                                <div class="text-center text-xs font-medium text-gray-500">Mo</div>
                                <div class="text-center text-xs font-medium text-gray-500">Tu</div>
                                <div class="text-center text-xs font-medium text-gray-500">We</div>
                                <div class="text-center text-xs font-medium text-gray-500">Th</div>
                                <div class="text-center text-xs font-medium text-gray-500">Fr</div>
                                <div class="text-center text-xs font-medium text-gray-500">Sa</div>
                                <div class="text-center text-xs font-medium text-gray-500">Su</div>

                                <template x-for="day in calendarDays" :key="day.date">
                                    <button
                                        type="button"
                                        @click="toggleDate(day.date)"
                                        :disabled="!day.isCurrentMonth"
                                        :class="{
                                            'bg-green-100 text-green-900': day.status === 'available' && day.isCurrentMonth,
                                            'bg-red-100 text-red-900': day.status === 'unavailable' && day.isCurrentMonth,
                                            'bg-yellow-100 text-yellow-900': day.status === 'confirm' && day.isCurrentMonth,
                                            'text-gray-300': !day.isCurrentMonth
                                        }"
                                        class="flex h-10 items-center justify-center text-sm hover:bg-gray-100 disabled:hover:bg-transparent"
                                        x-text="day.day"
                                    ></button>
                                </template>
                            </div>

                            <input type="hidden" name="availability" :value="JSON.stringify(availability)">
                        </div>

                        <div class="mt-3 flex items-center gap-6 text-xs">
                            <div class="flex items-center gap-2">
                                <div class="h-4 w-4 bg-green-100 border border-green-200"></div>
                                <span class="text-gray-600">Available</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="h-4 w-4 bg-red-100 border border-red-200"></div>
                                <span class="text-gray-600">Unavailable</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="h-4 w-4 bg-yellow-100 border border-yellow-200"></div>
                                <span class="text-gray-600">Need to confirm</span>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="right-side">

                    {{-- Hidden Slug Field --}}
                    <input type="hidden" name="slug" x-ref="slugInput" value="{{ old('slug') }}">
                        {{-- Product Main Image --}}
                        <div class="mb-6" x-data="mainImageUploader()">
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Product Image *</label>

                            <div
                                @click="$refs.fileInput.click()"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                :class="isDragging ? 'border-gray-900 bg-gray-100' : ''"
                                class="flex h-48 cursor-pointer flex-col items-center justify-center border-2 border-dashed border-gray-300 bg-gray-50 hover:border-gray-400"
                            >
                                <template x-if="!preview">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">Drag & drop or click to upload</p>
                                        <p class="mt-1 text-xs text-gray-400">PNG, JPG up to 10MB</p>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <div class="relative h-full w-full">
                                        <img :src="preview" class="h-full w-full object-contain p-4">
                                        <button
                                            type="button"
                                            @click.stop="removeImage()"
                                            class="absolute right-2 top-2 flex h-6 w-6 items-center justify-center bg-black text-white hover:bg-gray-800"
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
                                x-ref="fileInput"
                                @change="handleFile($event)"
                                accept="image/*"
                                class="hidden"
                                name="featured_image"
                            >

                            @error('featured_image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Product Gallery (Carousel) --}}
                            <div class="mb-6" x-data="galleryUploader()">
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Product Gallery (Carousel)</label>
                            <p class="mb-2 text-xs text-gray-400">Additional photos (optional, max 10)</p>

                            <div
                                @click="$refs.galleryInput.click()"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                :class="isDragging ? 'border-gray-900 bg-gray-100' : ''"
                                class="flex h-48 cursor-pointer flex-col items-center justify-center border-2 border-dashed border-gray-300 bg-gray-50 hover:border-gray-400"
                            >
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Drag & drop or click to add photos</p>
                                <p class="mt-1 text-xs text-gray-400">You can select multiple images at once</p>
                            </div>

                            <input
                                type="file"
                                x-ref="galleryInput"
                                @change="handleFiles($event)"
                                accept="image/*"
                                multiple
                                class="hidden"
                            >

                            <div class="mt-4 grid grid-cols-4 gap-2" x-show="previews.length > 0">
                                <template x-for="(preview, index) in previews" :key="index">
                                    <div class="relative aspect-square border border-gray-300 bg-gray-100">
                                        <img :src="preview" class="h-full w-full object-cover">
                                        <button
                                            type="button"
                                            @click.stop="removeImage(index)"
                                            class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center bg-black text-white hover:bg-gray-800"
                                        >
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            @error('gallery') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>
                
            <div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('account.products') }}" class="px-6 py-2 text-sm text-gray-600 hover:text-gray-900">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 bg-black px-6 py-2 text-sm text-white hover:bg-gray-800"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Product
                </button>
            </div>
        </form>
    </div>

    <script>
        function productForm() {
            return {
                mainImage: null,
                galleryImages: [],
                generateSlug(name) {
                    const slug = name
                        .toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    this.$refs.slugInput.value = slug;
                },
                submitForm(e) {
                    const form = e.target;
                    const formData = new FormData(form);

                    // Add main image
                    if (this.mainImage) {
                        formData.set('featured_image', this.mainImage);
                    }

                    // Add gallery images
                    this.galleryImages.forEach(file => {
                        formData.append('gallery[]', file);
                    });

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
                            window.location.href = '{{ route("account.products") }}';
                        } else {
                            return response.json().then(data => {
                                alert('Error: ' + (data.message || 'Failed to save'));
                            });
                        }
                    })
                    .catch(error => {
                        alert('Failed to save product');
                    });
                }
            }
        }

        function mainImageUploader() {
            return {
                preview: null,
                file: null,
                isDragging: false,
                handleFile(e) {
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

                        // Dispatch event to form
                        window.dispatchEvent(new CustomEvent('file-selected-main', { detail: file }));
                    }
                },
                removeImage() {
                    this.preview = null;
                    this.file = null;
                    this.$refs.fileInput.value = '';

                    // Dispatch event to clear
                    window.dispatchEvent(new CustomEvent('file-selected-main', { detail: null }));
                }
            }
        }

        function galleryUploader() {
            return {
                previews: [],
                files: [],
                isDragging: false,
                handleFiles(e) {
                    const files = Array.from(e.target.files);
                    this.processFiles(files);
                    e.target.value = '';
                },
                handleDrop(e) {
                    this.isDragging = false;
                    const files = Array.from(e.dataTransfer.files);
                    this.processFiles(files);
                },
                processFiles(files) {
                    const maxFiles = 10;

                    if (this.files.length + files.length > maxFiles) {
                        alert(`Maximum ${maxFiles} images allowed`);
                        return;
                    }

                    files.forEach(file => {
                        if (file.type.startsWith('image/')) {
                            this.files.push(file);

                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.previews.push(e.target.result);
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    // Dispatch event with all files
                    window.dispatchEvent(new CustomEvent('files-selected-gallery', { detail: this.files }));
                },
                removeImage(index) {
                    this.previews.splice(index, 1);
                    this.files.splice(index, 1);

                    // Dispatch updated files
                    window.dispatchEvent(new CustomEvent('files-selected-gallery', { detail: this.files }));
                }
            }
        }

        function availabilityCalendar() {
            return {
                currentMonth: new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                availability: {},

                get monthYear() {
                    const date = new Date(this.currentYear, this.currentMonth);
                    return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
                },

                get calendarDays() {
                    const firstDay = new Date(this.currentYear, this.currentMonth, 1);
                    const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
                    const prevLastDay = new Date(this.currentYear, this.currentMonth, 0);

                    const firstDayOfWeek = firstDay.getDay() === 0 ? 7 : firstDay.getDay();
                    const days = [];

                    // Previous month days
                    for (let i = firstDayOfWeek - 1; i > 0; i--) {
                        days.push({
                            day: prevLastDay.getDate() - i + 1,
                            date: null,
                            isCurrentMonth: false,
                            status: null
                        });
                    }

                    // Current month days
                    for (let i = 1; i <= lastDay.getDate(); i++) {
                        const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                        days.push({
                            day: i,
                            date: dateStr,
                            isCurrentMonth: true,
                            status: this.availability[dateStr] || 'available'
                        });
                    }

                    // Next month days
                    const remainingDays = 35 - days.length;
                    for (let i = 1; i <= remainingDays; i++) {
                        days.push({
                            day: i,
                            date: null,
                            isCurrentMonth: false,
                            status: null
                        });
                    }

                    return days;
                },

                toggleDate(dateStr) {
                    if (!dateStr) return;

                    const current = this.availability[dateStr] || 'available';
                    const statuses = ['available', 'unavailable', 'confirm'];
                    const nextIndex = (statuses.indexOf(current) + 1) % statuses.length;
                    this.availability[dateStr] = statuses[nextIndex];
                },

                previousMonth() {
                    if (this.currentMonth === 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                },

                nextMonth() {
                    if (this.currentMonth === 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                }
            }
        }
    </script>
</x-layouts.account>
