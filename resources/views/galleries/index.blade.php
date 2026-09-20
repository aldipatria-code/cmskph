@extends('layouts.app')

@php($siteSettings = \App\Models\SiteSetting::current())

@section('title', 'Galeri Kegiatan - '.$siteSettings->site_name)

@section('content')
<div x-data="{ open: false, image: '', title: '', category: '', date: '' }"
     @open-gallery.window="image = $event.detail.image; title = $event.detail.title; category = $event.detail.category; date = $event.detail.date; open = true"
     @keydown.escape.window="open = false">
<section class="relative mb-10 overflow-hidden rounded-[2rem] px-6 py-10 text-white shadow-[0_30px_70px_-40px_rgba(15,118,110,0.45)] sm:px-12 sm:py-14"
         style="background: {{ $siteSettings->galleryHeroBackgroundColor() }};">
    <div class="pointer-events-none absolute -right-16 -top-20 h-72 w-72 rounded-full bg-white/15 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-20 left-12 h-52 w-52 rounded-full bg-white/10 blur-3xl"></div>
    <div class="relative grid items-center gap-8 lg:grid-cols-[1fr_0.8fr]">
        <div>
            <span class="inline-flex rounded-full bg-white/15 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-teal-50 ring-1 ring-white/20">{{ $siteSettings->galleryHeroBadge() }}</span>
            <h1 class="mt-5 max-w-xl text-4xl font-black leading-tight sm:text-6xl">{{ $siteSettings->galleryHeroTitle() }}</h1>
            <p class="mt-4 max-w-2xl text-sm leading-7 text-teal-50 sm:text-base">{{ $siteSettings->galleryHeroDescription() }}</p>
            <div class="mt-6 flex flex-wrap gap-3 text-sm">
                <div class="rounded-2xl border border-white/25 bg-white/10 px-4 py-3 backdrop-blur-sm">
                    <strong class="block text-2xl font-black">{{ $activeAlbumCount }}</strong>
                    <span class="text-teal-50">Album aktif</span>
                </div>
                <div class="rounded-2xl border border-white/25 bg-white/10 px-4 py-3 backdrop-blur-sm">
                    <strong class="block text-2xl font-black">{{ $categoryCount }}</strong>
                    <span class="text-teal-50">Kategori program</span>
                </div>
                <div class="rounded-2xl border border-white/25 bg-white/10 px-4 py-3 backdrop-blur-sm">
                    <strong class="block text-2xl font-black">24/7</strong>
                    <span class="text-teal-50">Terus diperbarui</span>
                </div>
            </div>
        </div>
        <div class="hidden justify-end lg:flex">
            <div class="grid w-72 grid-cols-2 gap-3 rotate-3">
                        @foreach ($featuredGalleries as $gallery)
                            <button type="button"
                                    class="block w-full cursor-zoom-in text-left"
                                    @click="$dispatch('open-gallery', { image: @js($gallery->imageUrl()), title: @js($gallery->title), category: @js($gallery->category), date: @js($gallery->event_date?->isoFormat('D MMMM Y')) })"
                                    aria-label="Buka foto {{ $gallery->title }}">
                                <img src="{{ $gallery->imageUrl() }}" alt="{{ $gallery->title }}" class="aspect-[4/5] w-full rounded-3xl object-cover shadow-xl {{ $loop->last ? 'mt-8 -rotate-6' : '' }}">
                            </button>
                        @endforeach
            </div>
        </div>
    </div>
</section>

<form method="GET" action="{{ route('galleries.index') }}" class="mb-7 rounded-[2rem] border border-slate-200 bg-white p-4 shadow-[0_25px_50px_-35px_rgba(15,23,42,0.2)] sm:p-5">
    <div class="flex flex-col gap-3 lg:flex-row">
        <label class="relative flex-1">
            <span class="sr-only">Cari galeri berdasarkan foto, judul, atau kategori</span>
            <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">⌕</span>
            <input type="search" name="search" value="{{ $search }}" placeholder="Cari foto, judul, atau kategori..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-100">
        </label>
        <label class="lg:w-56">
            <span class="sr-only">Pilih kategori galeri</span>
            <select name="category" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-100">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected($selectedCategory === $category)>{{ $category }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit" class="rounded-2xl bg-teal-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-teal-700/20 transition hover:bg-teal-800">Cari</button>
        @if ($search !== '' || filled($selectedCategory))
            <a href="{{ route('galleries.index') }}" class="rounded-2xl border border-slate-200 px-6 py-3 text-center text-sm font-bold text-slate-600 transition hover:bg-slate-50">Reset</a>
        @endif
    </div>
</form>

<nav class="mb-7 flex flex-wrap justify-center gap-x-6 gap-y-3 text-xs font-bold uppercase tracking-[0.12em] text-slate-500" aria-label="Filter kategori galeri">
    <a href="{{ route('galleries.index', array_filter(['search' => $search])) }}" class="{{ blank($selectedCategory) ? 'text-teal-700' : 'hover:text-teal-700' }}">Semua</a>
    @foreach ($categories as $category)
        <a href="{{ route('galleries.index', array_filter(['search' => $search, 'category' => $category])) }}" class="{{ $selectedCategory === $category ? 'text-teal-700' : 'hover:text-teal-700' }}">{{ $category }}</a>
    @endforeach
</nav>

<div class="mb-7 rounded-[2rem] border border-teal-100 bg-gradient-to-r from-teal-50 via-cyan-50 to-sky-50 p-5 shadow-[0_25px_60px_-35px_rgba(13,148,136,0.25)] sm:p-7">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-4xl">
            <p class="text-sm font-black uppercase tracking-[0.18em] text-teal-700">{{ $siteSettings->gallerySectionBadge() }}</p>
            <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900 sm:text-4xl">{{ $siteSettings->gallerySectionTitle() }}</h2>
        </div>
        <a href="{{ route('community-members.create') }}" class="inline-flex items-center justify-center rounded-full bg-teal-600 px-6 py-3 text-sm font-black text-white shadow-lg shadow-teal-600/20 transition hover:bg-teal-700">{{ $siteSettings->galleryCtaButtonLabel() }}</a>
    </div>
</div>

@if ($galleries->isNotEmpty())
    <div class="grid auto-rows-[12rem] grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($galleries as $gallery)
            <a href="{{ route('galleries.show', $gallery) }}"
               class="group relative block overflow-hidden rounded-[1.75rem] bg-slate-900 shadow-[0_25px_50px_-30px_rgba(15,23,42,0.3)] transition duration-300 hover:-translate-y-1 {{ $loop->first ? 'sm:col-span-2 sm:row-span-2' : '' }}"
               aria-label="Lihat detail {{ $gallery->title }}">
                <img src="{{ $gallery->imageUrl() }}" alt="{{ $gallery->title }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/10 to-transparent"></div>
                <div class="absolute inset-x-0 bottom-0 p-5 text-white">
                    <span class="inline-flex rounded-full bg-white/20 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider backdrop-blur-sm">{{ $gallery->category }}</span>
                    <h3 class="mt-2 text-lg font-black leading-tight sm:text-xl">{{ $gallery->title }}</h3>
                    @if ($gallery->event_date)
                        <p class="mt-1 text-xs text-slate-200">{{ $gallery->event_date->isoFormat('D MMMM Y') }}</p>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
    @if ($galleries->hasPages())
        <nav class="mt-10 flex flex-wrap items-center justify-center gap-3 rounded-[2rem] border border-slate-200 bg-white p-4 shadow-sm sm:p-5" aria-label="Navigasi halaman galeri">
            <div class="flex items-center gap-2">
                @if ($galleries->onFirstPage())
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 text-slate-300" aria-disabled="true">‹</span>
                @else
                    <a href="{{ $galleries->previousPageUrl() }}" class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 text-lg font-bold text-slate-600 transition hover:border-teal-200 hover:bg-teal-50 hover:text-teal-700" aria-label="Halaman sebelumnya">‹</a>
                @endif

                @foreach ($galleries->getUrlRange(max(1, $galleries->currentPage() - 2), min($galleries->lastPage(), $galleries->currentPage() + 2)) as $page => $url)
                    @if ($page === $galleries->currentPage())
                        <span class="flex h-11 min-w-11 items-center justify-center rounded-xl bg-teal-700 px-3 font-bold text-white shadow-md shadow-teal-700/20" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="flex h-11 min-w-11 items-center justify-center rounded-xl border border-slate-200 px-3 font-semibold text-slate-600 transition hover:border-teal-200 hover:bg-teal-50 hover:text-teal-700">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($galleries->hasMorePages())
                    <a href="{{ $galleries->nextPageUrl() }}" class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 text-lg font-bold text-slate-600 transition hover:border-teal-200 hover:bg-teal-50 hover:text-teal-700" aria-label="Halaman berikutnya">›</a>
                @else
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 text-slate-300" aria-disabled="true">›</span>
                @endif
            </div>

            <div class="hidden h-8 w-px bg-slate-200 sm:block"></div>
            <p class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-500">
                Halaman <strong class="text-slate-800">{{ $galleries->currentPage() }}</strong> dari <strong class="text-slate-800">{{ $galleries->lastPage() }}</strong>
            </p>
        </nav>
    @endif
@else
    <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
        <p class="font-semibold text-slate-600">Belum ada galeri kegiatan.</p>
        <p class="mt-2 text-sm text-slate-400">Dokumentasi kegiatan komunitas akan tampil di sini.</p>
    </div>
@endif

</div>
</div>

<div x-cloak x-show="open" x-transition.opacity
     class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-950/85 p-4 sm:p-8"
     role="dialog"
     aria-modal="true"
     @click.self="open = false">
    <div x-show="open" x-transition class="relative flex max-h-[92vh] w-full max-w-5xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <button type="button"
                @click="open = false"
                class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-slate-950/70 text-2xl text-white transition hover:bg-slate-950"
                aria-label="Tutup foto">
            ×
        </button>
        <div class="flex min-h-0 items-center justify-center bg-slate-950">
            <img :src="image" :alt="title" class="max-h-[70vh] w-full object-contain">
        </div>
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 sm:px-7">
            <div>
                <span class="inline-flex rounded-full bg-teal-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-teal-700" x-text="category"></span>
                <h2 class="mt-2 text-lg font-black text-slate-900 sm:text-xl" x-text="title"></h2>
            </div>
            <p class="text-sm text-slate-500" x-text="date"></p>
        </div>
    </div>
</div>
@endsection
