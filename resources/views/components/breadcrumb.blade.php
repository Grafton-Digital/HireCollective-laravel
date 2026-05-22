@props(['items'])

<nav class="flex items-center gap-2">
    @foreach ($items as $i => $item)
        @if ($i > 0)
            <span class="text-xs text-[#666]">&gt;</span>
        @endif
        @if (!empty($item['url']))
            <a href="{{ $item['url'] }}" class="text-xs text-[#666] hover:underline">{{ $item['label'] }}</a>
        @else
            <span class="text-xs text-black">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
