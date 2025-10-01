@php
    $profil = $profil ?? \App\Models\Profil::select('logo', 'nama_instansi')->first();
@endphp

@if ($profil && $profil->logo)
    <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo {{ $profil->nama_instansi }}"
        @if (isset($style)) style="{{ $style }}" @endif
        @if (isset($class)) class="{{ $class }}" @endif>
@endif
