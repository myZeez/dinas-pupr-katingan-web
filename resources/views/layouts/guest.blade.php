<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $profil = \App\Models\Profil::first();
    @endphp

    <title>{{ $profil->nama_instansi ?? config('app.name', 'Laravel') }}</title>

    <!-- Favicon (cached) -->
    @include('components.favicon', ['profil' => $profil])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            @php
                $profil = \App\Models\Profil::first();
            @endphp
            <a href="/">
                @if ($profil && $profil->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo {{ $profil->nama_instansi }}"
                        class="w-20 h-20 object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" style="display: none;" />
                @else
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                @endif
            </a>
            @if ($profil && $profil->nama_instansi)
                <h2 class="text-center text-lg font-semibold text-gray-700 mt-2">
                    {{ $profil->nama_instansi }}
                </h2>
            @endif
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
