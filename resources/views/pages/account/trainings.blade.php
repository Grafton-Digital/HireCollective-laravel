<x-layouts.account>
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-900">Trainings</h1>
        <p class="mt-2 text-sm text-gray-600">Video guides to help you get the most out of your boutique</p>
    </div>

    @if($trainings->isEmpty())
        <div class="text-gray-500">
            <p>No training videos available yet. Check back soon!</p>
        </div>
    @else
        <div x-data="{ active: null }" class="space-y-3">
            @foreach($trainings as $training)
                <div class="overflow-hidden border border-gray-200 bg-white">
                    <button @click="active = active === {{ $training->id }} ? null : {{ $training->id }}" class="flex w-full items-center justify-between px-6 py-4 text-left">
                        <h3 class="text-base font-medium text-gray-900">{{ $training->title }}</h3>
                        <svg class="h-5 w-5 shrink-0 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': active === {{ $training->id }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div
                        class="grid overflow-hidden transition-all duration-500 ease-in-out"
                        :class="active === {{ $training->id }} ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                    >
                        <div class="overflow-hidden">
                            <div class="grid grid-cols-1 gap-6 border-t border-gray-200 px-6 py-5 md:grid-cols-2">
                                <div class="aspect-video overflow-hidden bg-gray-100">
                                    <video controls preload="metadata" class="h-full w-full object-cover">
                                        <source src="{{ asset('storage/' . $training->video_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <div class="flex items-start">
                                    @if($training->description)
                                        <div class="prose prose-sm text-gray-600">{!! $training->description !!}</div>
                                    @else
                                        <p class="text-sm text-gray-400 italic">No description available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.account>
