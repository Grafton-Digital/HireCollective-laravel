<x-layouts.public>
    <div class="mx-auto max-w-4xl px-4 py-12 md:py-16">
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-gray-900">Edit: {{ $product->name }}</h1>
        </div>

        <form method="POST" action="{{ route('dashboard.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6 rounded-lg bg-white p-8 shadow">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">URL Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $product->description) }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="featured_image" class="block text-sm font-medium text-gray-700">Featured Image</label>
            @if ($product->featured_image)
                <img src="{{ Storage::url($product->featured_image) }}" alt="" class="mt-2 h-32 w-32 rounded object-cover">
            @endif
            <input type="file" name="featured_image" id="featured_image" accept="image/*"
                   class="mt-2 block w-full text-sm text-gray-500">
            @error('featured_image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Variable product toggle --}}
        <div x-data="{ isVariable: {{ old('is_variable', $product->is_variable) ? 'true' : 'false' }} }">
            <label class="flex items-center gap-2">
                <input type="hidden" name="is_variable" value="0">
                <input type="checkbox" name="is_variable" value="1" x-model="isVariable"
                       class="rounded border-gray-300">
                <span class="text-sm font-medium text-gray-700">This product has size variants</span>
            </label>

            <div x-show="!isVariable" class="mt-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Hire Price (&euro;)</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0"
                       class="mt-1 block w-48 rounded-md border-gray-300 shadow-sm">
                @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div x-show="isVariable" class="mt-4" x-data="variantManager()">
                <p class="text-sm font-medium text-gray-700">Size Variants</p>
                <template x-for="(variant, index) in variants" :key="index">
                    <div class="mt-2 flex items-center gap-3">
                        <input type="text" :name="`variants[${index}][size]`" x-model="variant.size" placeholder="Size"
                               class="block w-24 rounded-md border-gray-300 shadow-sm text-sm">
                        <input type="number" :name="`variants[${index}][price]`" x-model="variant.price" placeholder="Price" step="0.01" min="0"
                               class="block w-28 rounded-md border-gray-300 shadow-sm text-sm">
                        <label class="flex items-center gap-1 text-xs text-gray-600">
                            <input type="hidden" :name="`variants[${index}][is_available]`" value="0">
                            <input type="checkbox" :name="`variants[${index}][is_available]`" value="1" x-model="variant.is_available"
                                   class="rounded border-gray-300">
                            Available
                        </label>
                        <button type="button" @click="removeVariant(index)" class="text-sm text-red-500 hover:text-red-700">&times;</button>
                    </div>
                </template>
                <button type="button" @click="addVariant()" class="mt-3 text-sm font-medium text-gray-600 hover:text-gray-900">
                    + Add variant
                </button>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2">
                <input type="hidden" name="is_available" value="0">
                <input type="checkbox" name="is_available" value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }}
                       class="rounded border-gray-300">
                <span class="text-sm text-gray-700">Available for hire</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                       class="rounded border-gray-300">
                <span class="text-sm text-gray-700">Published</span>
            </label>
        </div>

        <div class="grid gap-6 sm:grid-cols-3">
            <div>
                <p class="text-sm font-medium text-gray-700">Categories</p>
                <div class="mt-2 space-y-1">
                    @foreach ($categories as $category)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                   {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                   class="rounded border-gray-300">
                            {{ $category->name }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700">Colours</p>
                <div class="mt-2 space-y-1">
                    @foreach ($colours as $colour)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="colours[]" value="{{ $colour->id }}"
                                   {{ in_array($colour->id, old('colours', $product->colours->pluck('id')->toArray())) ? 'checked' : '' }}
                                   class="rounded border-gray-300">
                            {{ $colour->name }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700">Occasions</p>
                <div class="mt-2 space-y-1">
                    @foreach ($occasions as $occasion)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="occasions[]" value="{{ $occasion->id }}"
                                   {{ in_array($occasion->id, old('occasions', $product->occasions->pluck('id')->toArray())) ? 'checked' : '' }}
                                   class="rounded border-gray-300">
                            {{ $occasion->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="rounded-md bg-gray-900 px-6 py-2 text-sm font-medium text-white hover:bg-gray-800">
                Save Changes
            </button>
            <a href="{{ route('dashboard.products.index') }}" class="rounded-md px-6 py-2 text-sm text-gray-600 hover:text-gray-900">
                Cancel
            </a>
        </div>
    </form>

    @php
        $existingVariants = old('variants', $product->variants->map(fn ($v) => [
            'size' => $v->size,
            'price' => $v->price,
            'is_available' => $v->is_available,
        ])->toArray());
    @endphp

    <script>
        function variantManager() {
            return {
                variants: @json($existingVariants ?: [['size' => '', 'price' => '', 'is_available' => true]]),
                addVariant() {
                    this.variants.push({ size: '', price: '', is_available: true });
                },
                removeVariant(index) {
                    this.variants.splice(index, 1);
                }
            }
        }
    </script>
    </div>
</x-layouts.public>
