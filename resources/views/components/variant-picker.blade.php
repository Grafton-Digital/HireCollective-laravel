@props(['variants'])

<div x-data="{ selected: null }" class="flex flex-col gap-2">
    <p class="text-[11px] font-semibold tracking-[1px] text-black">SIZE</p>
    <div class="flex flex-wrap gap-2">
        @foreach ($variants as $variant)
            <button type="button"
                    @click="selected = {{ $variant->id }}"
                    :class="selected === {{ $variant->id }} ? 'border-black bg-black text-white' : 'border-[#D0D0D0] text-black hover:border-black'"
                    class="flex h-8 w-8 items-center justify-center border text-xs font-medium transition {{ !$variant->is_available ? 'opacity-40 line-through' : '' }}"
                    {{ !$variant->is_available ? 'disabled' : '' }}>
                {{ $variant->size }}
            </button>
        @endforeach
    </div>
    <template x-if="selected">
        <p class="text-[13px] text-[#333]">
            @foreach ($variants as $variant)
                <span x-show="selected === {{ $variant->id }}">
                    €{{ number_format($variant->price, 2) }}
                    @if (!$variant->is_available) — Currently unavailable @endif
                </span>
            @endforeach
        </p>
    </template>
</div>
