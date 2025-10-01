@php
    $profil = $profil ?? \App\Models\Profil::select('logo', 'updated_at')->first();
@endphp

@if ($profil && $profil->logo)
    @php
        // Force cache busting with current timestamp
        $version = time();
        $logoPath = asset('storage/' . $profil->logo) . '?v=' . $version;
    @endphp
    <link rel="icon" type="image/png" href="{{ $logoPath }}">
    <link rel="shortcut icon" type="image/png" href="{{ $logoPath }}">
@endif
