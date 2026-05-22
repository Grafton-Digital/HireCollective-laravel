<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} — Hire Collective</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 border-r border-gray-200 bg-white">
            <div class="p-6">
                <a href="{{ route('home') }}" class="text-lg font-bold tracking-tight">Hire Collective</a>
                <p class="mt-1 text-xs text-gray-500">{{ auth()->user()->boutique->name }}</p>
            </div>
            <nav class="mt-4 flex flex-col gap-1 px-3">
                <a href="{{ route('dashboard.index') }}"
                   class="rounded-md px-3 py-2 text-sm {{ request()->routeIs('dashboard.index') ? 'bg-gray-100 font-medium text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                    Dashboard
                </a>
                <a href="{{ route('dashboard.products.index') }}"
                   class="rounded-md px-3 py-2 text-sm {{ request()->routeIs('dashboard.products.*') ? 'bg-gray-100 font-medium text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                    Products
                </a>
                <a href="{{ route('dashboard.enquiries.index') }}"
                   class="rounded-md px-3 py-2 text-sm {{ request()->routeIs('dashboard.enquiries.*') ? 'bg-gray-100 font-medium text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                    Enquiries
                </a>
            </nav>
            <div class="mt-auto border-t border-gray-200 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Log out</button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1">
            <header class="border-b border-gray-200 bg-white px-8 py-4">
                <h1 class="text-lg font-semibold text-gray-900">{{ $header ?? '' }}</h1>
            </header>
            <main class="p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
