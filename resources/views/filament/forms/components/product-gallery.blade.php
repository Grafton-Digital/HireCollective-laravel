<div>
    @php
        $record = $getRecord();
        $images = $record && $record->images ? (is_array($record->images) ? $record->images : []) : [];
    @endphp

    @if(empty($images))
        <p class="text-sm text-gray-500">No gallery images yet.</p>
    @else
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
            @foreach($images as $index => $imagePath)
                <div style="position: relative;">
                    <img
                        src="{{ Storage::url($imagePath) }}"
                        alt="Gallery image {{ $index + 1 }}"
                        style="width: 100%; height: 128px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;"
                    >

                    {{-- Delete button - always visible in top right corner --}}
                    <button
                        type="button"
                        wire:click="deleteGalleryImage({{ $index }})"
                        onclick="if(!confirm('Delete this image?')) return false;"
                        title="Delete image"
                        style="position: absolute; top: -8px; right: -8px; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background-color: #dc2626; color: white; border-radius: 50%; border: none; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s; z-index: 10;"
                        onmouseover="this.style.backgroundColor='#b91c1c'"
                        onmouseout="this.style.backgroundColor='#dc2626'"
                    >
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <div style="margin-top: 4px; font-size: 12px; color: #4b5563; text-align: center; font-weight: 500;">
                        Image {{ $index + 1 }} of {{ count($images) }}
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 16px; padding: 12px; background-color: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
            <p style="font-size: 14px; color: #4b5563;">
                💡 <strong>Tip:</strong> Click the red button to delete an image
            </p>
        </div>
    @endif
</div>
