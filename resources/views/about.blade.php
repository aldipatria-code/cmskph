@extends('layouts.app')

@php($siteSettings = \App\Models\SiteSetting::current())

@section('title', $siteSettings->aboutTitle().' - '.$siteSettings->site_name)

@section('content')
<section class="relative overflow-hidden rounded-[2rem] border border-teal-100 px-6 py-12 shadow-[0_30px_70px_-40px_rgba(15,118,110,0.35)] sm:px-12 sm:py-16"
         style="background-color: {{ $siteSettings->aboutBackgroundColor() }};{{ $siteSettings->aboutBackgroundImageUrl() ? 'background-image: linear-gradient(90deg, rgba(240, 253, 250, .94), rgba(240, 253, 250, .72)), url('.$siteSettings->aboutBackgroundImageUrl().'); background-position: center; background-size: cover;' : '' }}">
    <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-teal-200/40 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-16 left-10 h-48 w-48 rounded-full bg-cyan-200/30 blur-3xl"></div>
    <div class="relative max-w-3xl">
        <span class="inline-flex rounded-full bg-white/75 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-teal-800 shadow-sm ring-1 ring-teal-100">
            Tentang Kami
        </span>
        <h1 class="mt-5 text-3xl font-black tracking-tight text-slate-900 sm:text-5xl">{{ $siteSettings->aboutTitle() }}</h1>
        <div class="mt-6 whitespace-pre-line text-base leading-8 text-slate-600 sm:text-lg">
            {{ $siteSettings->aboutDescription() }}
        </div>
    </div>
</section>

<div class="mt-8 grid gap-4 md:grid-cols-3">
    <div class="rounded-[1.75rem] border border-teal-100 bg-white p-6 shadow-[0_20px_40px_-32px_rgba(15,118,110,0.45)]">
        <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-100 text-lg font-black text-teal-700">01</div>
        <h2 class="text-lg font-black text-slate-900">Visi</h2>
        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $siteSettings->aboutVision() }}</p>
    </div>
    <div class="rounded-[1.75rem] border border-sky-100 bg-white p-6 shadow-[0_20px_40px_-32px_rgba(14,165,233,0.4)]">
        <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-100 text-lg font-black text-sky-700">02</div>
        <h2 class="text-lg font-black text-slate-900">Misi</h2>
        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $siteSettings->aboutMission() }}</p>
    </div>
    <div class="rounded-[1.75rem] border border-amber-100 bg-white p-6 shadow-[0_20px_40px_-32px_rgba(245,158,11,0.35)]">
        <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-100 text-lg font-black text-amber-700">03</div>
        <h2 class="text-lg font-black text-slate-900">Komitmen</h2>
        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $siteSettings->aboutCommitment() }}</p>
    </div>
</div>

<div class="mt-8 rounded-[2rem] border border-teal-100 bg-gradient-to-r from-teal-600 via-teal-700 to-cyan-700 p-6 text-white shadow-[0_25px_60px_-35px_rgba(13,148,136,0.8)] sm:p-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-teal-50/80">{{ $siteSettings->aboutCtaBadge() }}</p>
            <h2 class="mt-2 text-2xl font-black">{{ $siteSettings->aboutCtaTitle() }}</h2>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('community-members.create') }}" class="rounded-full bg-white px-5 py-3 text-sm font-bold text-teal-700 transition hover:bg-teal-50">Gabung komunitas</a>
            <a href="{{ route('home') }}" class="rounded-full border border-white/30 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/10">Kembali ke beranda</a>
        </div>
    </div>
</div>
@endsection
