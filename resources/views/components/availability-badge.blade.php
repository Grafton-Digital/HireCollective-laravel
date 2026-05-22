@props(['available', 'labelOn' => 'Available', 'labelOff' => 'Unavailable'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-2xs font-medium ' . ($available ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'bg-red-50 text-red-700')]) }}>
    <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
    {{ $available ? $labelOn : $labelOff }}
</span>
