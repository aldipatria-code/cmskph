@extends('layouts.app')

@php($siteSettings = \App\Models\SiteSetting::current())

@section('title', $siteSettings->aboutTitle().' - '.$siteSettings->site_name)

@section('content')
<section class="relative overflow-hidden rounded-[2rem] border border-teal-100 px-6 py-12 shadow-xl shadow-teal-900/5 sm:px-12 sm:py-16"
         style="background-color: {{ $siteSettings->aboutBackgroundColor() }};{{ $siteSettings->aboutBackgroundImageUrl() ? 'background-image: linear-gradient(90deg, rgba(240, 253, 250, .94), rgba(240, 253, 250, .72)), url('.$siteSettings->aboutBackgroundImageUrl().'); background-position: center; background-size: cover;' : '' }}">
    <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-teal-200/40 blur-3xl"></div>
    <div class="relative max-w-3xl">
        <span class="inline-flex rounded-full bg-white/75 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-teal-800 shadow-sm">
            Tentang Kami
        </span>
        <h1 class="mt-5 text-3xl font-black tracking-tight text-slate-900 sm:text-5xl">{{ $siteSettings->aboutTitle() }}</h1>
        <div class="mt-6 whitespace-pre-line text-base leading-8 text-slate-600 sm:text-lg">
            {{ $siteSettings->aboutDescription() }}
        </div>
    </div>
</section>

<div class="mt-8 flex justify-start">
    <a href="{{ route('home') }}" class="rounded-full bg-teal-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-teal-600/20 transition hover:bg-teal-700">
        Kembali ke beranda
    </a>
</div>
@endsection
