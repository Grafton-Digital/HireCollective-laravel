<x-layouts.account>
    <div class="bg-white p-8">
        <div class="mb-6">
            <h1 class="font-serif text-[24px] tracking-wide text-gray-900">Edit Product</h1>
        </div>

        <p class="mb-8 text-sm text-gray-500">Update product details below. Fields marked with * are required.</p>

        <form method="POST" action="{{ route('account.products.update', $product) }}" enctype="multipart/form-data" novalidate
            x-data="productForm()"
            @submit.prevent="submitForm"
            @file-selected-main.window="mainImage = $event.detail"
            @files-selected-gallery.window="galleryImages = $event.detail">
            @csrf
            @method('PUT')


            <div class="grid grid-cols-2 gap-8">

                <div class="left-side">

                    {{-- Product Name --}}
                    <div class="mb-6">
                        <label for="name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Product Name *</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $product->name) }}"
                            placeholder="e.g. Oversized Cashmere Sweater"
                            required
                            @input="generateSlug($event.target.value)"
                            class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                        >
                        <p x-show="errors.name" x-text="errors.name?.[0]" class="mt-1 text-xs text-red-600"></p>
                    </div>

                    {{-- Hidden Slug Field --}}
                    <input type="hidden" name="slug" x-ref="slugInput" value="{{ old('slug', $product->slug) }}">

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
                                    value="{{ old('price_per_day', $product->price_per_day) }}"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0"
                                    required
                                    class="block w-full pl-8 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                    :class="errors.price_per_day ? 'border-red-500' : 'border-gray-300'"
                                >
                            </div>
                            <p x-show="errors.price_per_day" x-text="errors.price_per_day?.[0]" class="mt-1 text-xs text-red-600"></p>
                        </div>

                        <div>
                            <label for="size" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Available Size *</label>
                            <input
                                type="text"
                                name="size"
                                id="size"
                                value="{{ old('size', $product->size) }}"
                                placeholder="e.g. 8, 10, 12, 14"
                                class="block w-full text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                :class="errors.size ? 'border-red-500' : 'border-gray-300'"
                            >
                            <p x-show="errors.size" x-text="errors.size?.[0]" class="mt-1 text-xs text-red-600"></p>
                        </div>
                    </div>

                    {{-- Colours and Category --}}
                    <div class="mb-6 grid grid-cols-2 gap-4">
                        <div x-data="colourSelector(@js($colours->toArray()), @js(old('colours', $product->colours->pluck('id')->toArray())))">
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Colours *</label>

                            {{-- Selected colours as tags --}}
                            <div class="mb-2 flex flex-wrap gap-2" x-show="selectedColours.length > 0">
                                <template x-for="(colourId, index) in selectedColours" :key="colourId">
                                    <div class="inline-flex items-center gap-1 bg-gray-100 px-2 py-1 text-xs">
                                        <span x-text="getColourName(colourId)"></span>
                                        <button type="button" @click="removeColour(colourId)" class="text-gray-500 hover:text-gray-700">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            {{-- Dropdown toggle --}}
                            <div class="relative">
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="flex w-full items-center justify-between border border-gray-300 bg-white px-3 py-2 text-left text-sm shadow-sm hover:bg-gray-50 focus:border-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400"
                                >
                                    <span x-text="selectedColours.length === 0 ? 'Select colours' : selectedColours.length + ' selected'" class="text-gray-700"></span>
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                {{-- Dropdown menu --}}
                                <div
                                    x-show="open"
                                    @click.away="open = false"
                                    x-transition
                                    class="absolute z-10 mt-1 w-full border border-gray-300 bg-white shadow-lg"
                                >
                                    {{-- Search input --}}
                                    <div class="border-b border-gray-200 p-2">
                                        <input
                                            type="text"
                                            x-model="search"
                                            placeholder="Search colours..."
                                            class="w-full border-gray-300 px-2 py-1 text-sm focus:border-gray-400 focus:ring-gray-400"
                                        >
                                    </div>

                                    {{-- Options list --}}
                                    <div class="max-h-48 overflow-y-auto">
                                        <template x-for="colour in filteredColours" :key="colour.id">
                                            <label
                                                class="flex cursor-pointer items-center gap-2 px-3 py-2 text-sm hover:bg-gray-50"
                                                :class="{ 'bg-gray-100': selectedColours.includes(colour.id) }"
                                            >
                                                <input
                                                    type="checkbox"
                                                    :value="colour.id"
                                                    x-model="selectedColours"
                                                    class="border-gray-300 text-gray-900 focus:ring-gray-400"
                                                >
                                                <span x-text="colour.name"></span>
                                            </label>
                                        </template>
                                        <div x-show="filteredColours.length === 0" class="px-3 py-2 text-sm text-gray-500">
                                            No colours found
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Hidden inputs for form submission --}}
                            <template x-for="colourId in selectedColours" :key="colourId">
                                <input type="hidden" name="colours[]" :value="colourId">
                            </template>

                            <p x-show="errors.colours" x-text="errors.colours?.[0]" class="mt-1 text-xs text-red-600"></p>
                        </div>

                        <div class="mt-auto">
                            <label for="category" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Category *</label>
                            <select
                                name="category"
                                id="category"
                                class="block w-full text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                                :class="errors.category ? 'border-red-500' : 'border-gray-300'"
                            >
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category', $product->categories->first()?->id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p x-show="errors.category" x-text="errors.category?.[0]" class="mt-1 text-xs text-red-600"></p>
                        </div>
                    </div>

                    {{-- Occasions / Event Tags --}}
                    <div class="mb-6" x-data="occasionSelector(@js($occasions->toArray()), @js(old('occasions', $product->occasions->pluck('id')->toArray())))">
                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Event Tags</label>

                        <div class="mb-2 flex flex-wrap gap-2" x-show="selectedOccasions.length > 0">
                            <template x-for="(occasionId, index) in selectedOccasions" :key="occasionId">
                                <div class="inline-flex items-center gap-1 bg-gray-100 px-2 py-1 text-xs">
                                    <span x-text="getOccasionName(occasionId)"></span>
                                    <button type="button" @click="removeOccasion(occasionId)" class="text-gray-500 hover:text-gray-700">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="relative">
                            <button
                                type="button"
                                @click="open = !open"
                                class="flex w-full items-center justify-between border border-gray-300 bg-white px-3 py-2 text-left text-sm shadow-sm hover:bg-gray-50 focus:border-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400"
                            >
                                <span x-text="selectedOccasions.length === 0 ? 'Select event tags' : selectedOccasions.length + ' selected'" class="text-gray-700"></span>
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition
                                class="absolute z-10 mt-1 w-full border border-gray-300 bg-white shadow-lg"
                            >
                                <div class="border-b border-gray-200 p-2">
                                    <input
                                        type="text"
                                        x-model="search"
                                        placeholder="Search event tags..."
                                        class="w-full border-gray-300 px-2 py-1 text-sm focus:border-gray-400 focus:ring-gray-400"
                                    >
                                </div>

                                <div class="max-h-48 overflow-y-auto">
                                    <template x-for="occasion in filteredOccasions" :key="occasion.id">
                                        <label
                                            class="flex cursor-pointer items-center gap-2 px-3 py-2 text-sm hover:bg-gray-50"
                                            :class="{ 'bg-gray-100': selectedOccasions.includes(occasion.id) }"
                                        >
                                            <input
                                                type="checkbox"
                                                :value="occasion.id"
                                                x-model="selectedOccasions"
                                                class="border-gray-300 text-gray-900 focus:ring-gray-400"
                                            >
                                            <span x-text="occasion.name"></span>
                                        </label>
                                    </template>
                                    <div x-show="filteredOccasions.length === 0" class="px-3 py-2 text-sm text-gray-500">
                                        No event tags found
                                    </div>
                                </div>
                            </div>
                        </div>

                        <template x-for="occasionId in selectedOccasions" :key="occasionId">
                            <input type="hidden" name="occasions[]" :value="occasionId">
                        </template>

                        <p x-show="errors.occasions" x-text="errors.occasions?.[0]" class="mt-1 text-xs text-red-600"></p>
                    </div>

                    <div class="mb-6 grid grid-cols-2 gap-4">

                        {{-- Region --}}
                        <div class="mb-6">
                            <label for="county" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Region *</label>
                            <select
                                name="county"
                                id="county"
                                required
                                class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                            >
                                <option value="">Select region</option>
                                @foreach(\App\County::cases() as $countyOption)
                                    <option value="{{ $countyOption->value }}" {{ old('county', $product->county?->value) == $countyOption->value ? 'selected' : '' }}>
                                        {{ $countyOption->getLabel() }}
                                    </option>
                                @endforeach
                            </select>
                            <p x-show="errors.county" x-text="errors.county?.[0]" class="mt-1 text-xs text-red-600"></p>
                        </div>

                        {{-- Designer --}}
                        <div class="mb-6">
                            <label for="designer" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Designer</label>
                            <input
                                type="text"
                                name="designer"
                                id="designer"
                                value="{{ old('designer', $product->designer) }}"
                                placeholder="Type designer name"
                                class="block w-full border-gray-300 text-sm shadow-sm focus:border-gray-400 focus:ring-gray-400"
                            >
                            <p x-show="errors.designer" x-text="errors.designer?.[0]" class="mt-1 text-xs text-red-600"></p>
                        </div>

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
                        >{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Availability Calendar --}}
                    @php
                        $availabilityData = is_string($product->availability)
                            ? json_decode($product->availability, true)
                            : ($product->availability ?? []);
                        $availabilityData = !empty($availabilityData) ? (object) $availabilityData : (object) [];
                    @endphp
                    <div class="mb-6" x-data="availabilityCalendar(@js($availabilityData))">
                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Availability Calendar</label>
                        <p class="mb-4 text-xs text-gray-500">Click on a date to set its status.</p>

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

                                <template x-for="(day, index) in calendarDays" :key="index">
                                    <div class="relative">
                                        <button
                                            type="button"
                                            @click="day.isCurrentMonth ? openDropdown(day.date) : null"
                                            :disabled="!day.isCurrentMonth"
                                            :class="{
                                                'bg-green-100 text-green-900': day.status === 'available' && day.isCurrentMonth,
                                                'bg-red-100 text-red-900': day.status === 'unavailable' && day.isCurrentMonth,
                                                'bg-yellow-100 text-yellow-900': day.status === 'confirm' && day.isCurrentMonth,
                                                'text-gray-300': !day.isCurrentMonth
                                            }"
                                            class="flex h-10 w-full items-center justify-center text-sm hover:bg-gray-100 disabled:hover:bg-transparent"
                                            x-text="day.day"
                                        ></button>
                                        <div
                                            x-show="day.date && activeDate === day.date"
                                            x-transition
                                            class="absolute z-20 mt-1 w-36 border border-gray-200 bg-white shadow-lg"
                                            :class="index % 7 >= 5 ? 'right-0' : 'left-0'"
                                        >
                                            <button type="button" @click.stop="setStatus(day.date, 'available')" class="flex w-full items-center gap-2 px-3 py-2 text-xs hover:bg-gray-50">
                                                <span class="h-3 w-3 bg-green-100 border border-green-300"></span> Available
                                            </button>
                                            <button type="button" @click.stop="setStatus(day.date, 'unavailable')" class="flex w-full items-center gap-2 px-3 py-2 text-xs hover:bg-gray-50">
                                                <span class="h-3 w-3 bg-red-100 border border-red-300"></span> Unavailable
                                            </button>
                                            <button type="button" @click.stop="setStatus(day.date, 'confirm')" class="flex w-full items-center gap-2 px-3 py-2 text-xs hover:bg-gray-50">
                                                <span class="h-3 w-3 bg-yellow-100 border border-yellow-300"></span> Need to confirm
                                            </button>
                                        </div>
                                    </div>
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

                    {{-- Product Main Image --}}
                    <div class="mb-6" x-data="mainImageUploader('{{ $product->featured_image ? Storage::url($product->featured_image) : '' }}')">
                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-700">Product Image *</label>

                        <div
                            @click="$refs.fileInput.click()"
                            @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="handleDrop($event)"
                            :class="isDragging ? 'border-gray-900 bg-gray-100' : ''"
                            class="flex h-48 cursor-pointer flex-col items-center justify-center border-2 border-dashed border-gray-300 bg-gray-50 hover:border-gray-400"
                        >
                            <template x-if="!preview && !existingImage">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Drag & drop or click to upload</p>
                                    <p class="mt-1 text-xs text-gray-400">PNG, JPG up to 10MB</p>
                                </div>
                            </template>
                            <template x-if="preview || existingImage">
                                <div class="relative h-full w-full">
                                    <img :src="preview || existingImage" class="h-full w-full object-contain p-4">
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

                        <p x-show="errors.featured_image" x-text="errors.featured_image?.[0]" class="mt-1 text-xs text-red-600"></p>
                    </div>

                    {{-- Product Gallery (Carousel) --}}
                    <div class="mb-6" x-data="galleryUploader(@js(collect($product->images ?? [])->map(fn($img) => Storage::url($img))->values()->toArray()))">
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

                        <div class="mt-4 grid grid-cols-4 gap-2" x-show="previews.length > 0 || existingImages.length > 0">
                            {{-- Existing images --}}
                            <template x-for="(image, index) in existingImages" :key="'existing-' + index">
                                <div class="relative aspect-square border border-gray-300 bg-gray-100">
                                    <img :src="image" class="h-full w-full object-cover">
                                    <button
                                        type="button"
                                        @click.stop="removeExistingImage(index)"
                                        class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center bg-black text-white hover:bg-gray-800"
                                    >
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            {{-- New images --}}
                            <template x-for="(preview, index) in previews" :key="'new-' + index">
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

                        <p x-show="errors.gallery" x-text="errors.gallery?.[0]" class="mt-1 text-xs text-red-600"></p>
                    </div>

                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('account.products') }}" class="px-6 py-2 text-sm text-gray-600 hover:text-gray-900">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="bg-black px-6 py-2 text-sm text-white hover:bg-gray-800"
                >
                    Update Product
                </button>
            </div>
        </form>
    </div>

    <script>
        function productForm() {
            return {
                mainImage: null,
                galleryImages: [],
                errors: {},
                generateSlug(name) {
                    // Only auto-generate on create, not on edit
                },
                submitForm(e) {
                    this.errors = {};
                    const form = e.target;
                    const formData = new FormData(form);

                    if (this.mainImage) {
                        formData.set('featured_image', this.mainImage);
                    }

                    this.galleryImages.forEach(file => {
                        formData.append('gallery[]', file);
                    });

                    const calendarEl = form.querySelector('[x-data*="availabilityCalendar"]');
                    if (calendarEl) {
                        const calendarData = Alpine.$data(calendarEl);
                        formData.set('availability', JSON.stringify(calendarData.availability));
                    }

                    const galleryUploader = window.Alpine ? Alpine.$data(document.querySelector('[x-data*="galleryUploader"]')) : null;
                    if (galleryUploader && galleryUploader.existingImages) {
                        const keptPaths = galleryUploader.existingImages.map(url => {
                            const match = url.match(/\/storage\/(.+)$/);
                            return match ? match[1] : null;
                        }).filter(Boolean);
                        formData.set('keep_images', JSON.stringify(keptPaths));
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
                            window.location.href = '{{ route("account.products") }}';
                        } else if (response.status === 422) {
                            return response.json().then(data => {
                                this.errors = data.errors || {};
                                this.$nextTick(() => {
                                    const firstError = form.querySelector('.border-red-500');
                                    if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                });
                            });
                        } else {
                            return response.json().then(data => {
                                this.errors = { general: [data.message || 'Failed to save product'] };
                            });
                        }
                    })
                    .catch(() => {
                        this.errors = { general: ['Failed to save product. Please try again.'] };
                    });
                }
            }
        }

        function mainImageUploader(existingUrl = '') {
            return {
                preview: null,
                existingImage: existingUrl,
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
                            this.existingImage = null;
                        };
                        reader.readAsDataURL(file);

                        window.dispatchEvent(new CustomEvent('file-selected-main', { detail: file }));
                    }
                },
                removeImage() {
                    this.preview = null;
                    this.existingImage = null;
                    this.file = null;
                    this.$refs.fileInput.value = '';

                    window.dispatchEvent(new CustomEvent('file-selected-main', { detail: null }));
                }
            }
        }

        function galleryUploader(existingGallery = []) {
            return {
                existingImages: existingGallery,
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
                    const currentTotal = this.existingImages.length + this.files.length;

                    if (currentTotal + files.length > maxFiles) {
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

                    window.dispatchEvent(new CustomEvent('files-selected-gallery', { detail: this.files }));
                },
                removeExistingImage(index) {
                    this.existingImages.splice(index, 1);
                },
                removeImage(index) {
                    this.previews.splice(index, 1);
                    this.files.splice(index, 1);

                    window.dispatchEvent(new CustomEvent('files-selected-gallery', { detail: this.files }));
                }
            }
        }


    </script>
</x-layouts.account>
