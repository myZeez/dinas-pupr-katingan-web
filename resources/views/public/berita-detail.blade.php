@extends('public.layouts.app')

@section('title', $berita->judul)
@section('description', Str::limit(strip_tags($berita->konten), 160))

@section('content')
    @include('public.berita.show')
@endsection
