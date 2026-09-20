@extends('layouts.app')

@php($siteSettings = \App\Models\SiteSetting::current())

@section('content')
<style>
    @keyframes gallery-marquee {
        from { transform: translate3d(0, 0, 0); }
        to { transform: translate3d(-50%, 0, 0); }
    }

    .kph-surface {
        background: linear-gradient(135deg, rgba(240, 253, 250, 0.96), rgba(255, 255, 255, 1));
    }

    .kph-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .kph-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 22px 38px -24px rgba(15, 118, 110, 0.28);
    }

    .gallery-marquee {
        position: relative;
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.95), rgba(255, 255, 255, 1));
    }

    .gallery-marquee-track {
        display: flex;
        width: max-content;
        min-width: 100%;
        animation: gallery-marquee 28s linear infinite;
        will-change: transform;
    }

    .gallery-marquee-group {
        display: flex;
        flex-shrink: 0;
        align-items: stretch;
        gap: 0;
    }

    .gallery-marquee-label {
        background: linear-gradient(135deg, #0f766e 0%, #134e4a 100%);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.16);
    }

    .gallery-marquee-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
    }

    .gallery-marquee:hover .gallery-marquee-track,
    .gallery-marquee:focus-within .gallery-marquee-track {
        animation-play-state: paused;
    }

    @media (prefers-reduced-motion: reduce) {
        .gallery-marquee-track {
            animation: none;
        }
    }
</style>
<section x-data="{
            slide: 0,
            slides: @js($siteSettings->heroSlides()),
            goTo(index) {
                if (this.slides.length > 0) {
                    this.slide = (index + this.slides.length) % this.slides.length;
                }
            }
         }"
         class="kph-surface relative mb-10 overflow-hidden rounded-[2rem] border border-teal-100 px-6 py-8 shadow-[0_30px_70px_-40px_rgba(15,118,110,0.35)] sm:mb-14 sm:px-10 sm:py-10 lg:px-12"
         style="background-color: color-mix(in srgb, {{ $siteSettings->heroBackgroundColor() }} 12%, white);">
    <div class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full bg-teal-300/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 left-1/3 h-72 w-72 rounded-full bg-cyan-300/20 blur-3xl"></div>
    <div class="relative grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-8">
        <div class="max-w-2xl">
        <span class="inline-flex items-center gap-2 rounded-full bg-teal-100 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-teal-800 shadow-sm ring-1 ring-teal-200/70">
            <span class="h-2 w-2 rounded-full bg-teal-500"></span>
            {{ $siteSettings->heroBadge() }}
        </span>
        <h1 class="mt-5 max-w-xl text-4xl font-black leading-[1.05] tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">{{ $siteSettings->heroTitle() }}</h1>
        <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 sm:text-lg">
            {{ $siteSettings->heroDescription() }}
        </p>
        <div class="mt-7 flex flex-wrap gap-3">
        <a href="{{ route('community-members.create') }}" class="inline-flex items-center rounded-full bg-teal-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-teal-600/20 transition duration-200 hover:-translate-y-0.5 hover:bg-teal-700 hover:shadow-teal-600/30">
            Gabung komunitas
            <span class="ml-2">→</span>
        </a>
        <a href="#informasi" class="inline-flex items-center rounded-full bg-white/80 px-5 py-3 text-sm font-bold text-teal-700 ring-1 ring-teal-100 transition duration-200 hover:bg-white hover:ring-teal-200">
            Lihat informasi
        </a>
        </div>
        <div class="mt-7 inline-flex items-center gap-3 rounded-2xl bg-white/80 px-4 py-3 ring-1 ring-teal-100 shadow-sm backdrop-blur-sm">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-teal-100 text-teal-700">✓</span>
            <span><strong class="block text-sm text-slate-800">Edukasi dan dukungan</strong><small class="text-xs text-slate-500">Informasi terpercaya untuk keluarga dan penyintas</small></span>
        </div>
        </div>
        <div class="relative mx-auto w-full max-w-lg">
            <div class="absolute -right-2 top-4 z-10 rounded-2xl bg-white px-4 py-3 shadow-xl ring-1 ring-slate-100 sm:right-0">
                <span class="block text-xs text-slate-500">Ruang komunitas</span>
                <strong class="text-lg text-slate-900">Peduli bersama</strong>
            </div>
            <div class="relative aspect-[4/3] overflow-hidden rounded-[2rem] border-8 border-white bg-teal-100 shadow-2xl shadow-teal-900/20">
                @if ($siteSettings->heroSlides())
                    <template x-for="(item, index) in slides" :key="index">
                        <img x-show="slide === index"
                             x-transition.opacity.duration.300ms
                             :src="item.image"
                             :alt="item.title || 'Kegiatan Komunitas Peduli Hepatitis'"
                             class="absolute inset-0 h-full w-full object-cover"
                             x-cloak>
                    </template>
                    <button type="button" @click="goTo(slide - 1)" class="absolute left-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-xl text-teal-700 shadow-lg transition hover:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500" aria-label="Gambar sebelumnya">‹</button>
                    <button type="button" @click="goTo(slide + 1)" class="absolute right-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-xl text-teal-700 shadow-lg transition hover:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500" aria-label="Gambar berikutnya">›</button>
                    <div class="absolute bottom-3 left-1/2 flex -translate-x-1/2 gap-1.5">
                        <template x-for="(item, index) in slides" :key="'dot-'+index">
                            <button type="button" @click="goTo(index)" class="h-2 w-2 rounded-full bg-white/70 transition" :class="{ 'w-6 bg-teal-600': slide === index }" :aria-label="'Pilih gambar ' + (index + 1)"></button>
                        </template>
                    </div>
                @elseif ($siteSettings->heroBackgroundImageUrl())
                    <img src="{{ $siteSettings->heroBackgroundImageUrl() }}" alt="Kegiatan Komunitas Peduli Hepatitis" class="aspect-[4/3] w-full object-cover">
                @else
                    <div class="flex aspect-[4/3] items-center justify-center bg-gradient-to-br from-teal-200 via-cyan-100 to-white p-8 text-center">
                        <div>
                            <span class="text-6xl">🤝</span>
                            <p class="mt-4 font-bold text-teal-800">Bersama menjaga kesehatan</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="absolute -bottom-4 -left-3 rounded-2xl bg-white px-4 py-3 shadow-xl ring-1 ring-slate-100 sm:-left-5">
                <span class="block text-xs text-slate-500">Komunitas</span>
                <strong class="text-lg text-teal-700">KPH</strong>
            </div>
        </div>
    </div>
    </div>
</section>

@if ($homeGalleries->isNotEmpty())
    <section class="gallery-marquee mb-10 overflow-hidden rounded-[2rem] border border-slate-200 shadow-lg shadow-slate-900/5" aria-label="Galeri Kami">
        <div class="gallery-marquee-track">
            <div class="gallery-marquee-group">
                <a id="galeri-kami-title" href="{{ route('galleries.index') }}" class="gallery-marquee-label flex min-w-36 shrink-0 items-center gap-2 px-5 py-5 text-base font-black tracking-tight text-white transition hover:brightness-110 sm:min-w-40 sm:px-7 sm:text-lg">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-sm">✦</span>
                    Galeri Kami
                </a>
                @foreach ($homeGalleries as $gallery)
                    <a href="{{ route('galleries.show', $gallery) }}" class="gallery-marquee-card group flex min-w-[17rem] shrink-0 items-center gap-4 border-l border-slate-100 px-5 py-4 transition duration-300 hover:-translate-y-0.5 hover:bg-teal-50/80 sm:min-w-[21rem]">
                        <img src="{{ $gallery->imageUrl() }}" alt="{{ $gallery->title }}" class="h-12 w-12 shrink-0 rounded-xl object-cover ring-1 ring-slate-200 shadow-sm sm:h-14 sm:w-14">
                        <div class="min-w-0">
                            <span class="inline-flex rounded-full bg-sky-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-sky-700">{{ $gallery->category }}</span>
                            <h2 class="mt-2 truncate text-sm font-semibold text-slate-700 transition group-hover:text-teal-700">{{ $gallery->title }}</h2>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="gallery-marquee-group" aria-hidden="true">
                <a href="{{ route('galleries.index') }}" tabindex="-1" class="gallery-marquee-label flex min-w-36 shrink-0 items-center gap-2 px-5 py-5 text-base font-black tracking-tight text-white sm:min-w-40 sm:px-7 sm:text-lg">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-sm">✦</span>
                    Galeri Kami
                </a>
                @foreach ($homeGalleries as $gallery)
                    <div class="gallery-marquee-card group flex min-w-[17rem] shrink-0 items-center gap-4 border-l border-slate-100 px-5 py-4 sm:min-w-[21rem]">
                        <img src="{{ $gallery->imageUrl() }}" alt="" class="h-12 w-12 shrink-0 rounded-xl object-cover ring-1 ring-slate-200 shadow-sm sm:h-14 sm:w-14">
                        <div class="min-w-0">
                            <span class="inline-flex rounded-full bg-sky-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-sky-700">{{ $gallery->category }}</span>
                            <h2 class="mt-2 truncate text-sm font-semibold text-slate-700">{{ $gallery->title }}</h2>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="mb-10 grid gap-4 md:grid-cols-3">
    <div class="kph-card rounded-[2rem] border border-teal-100 bg-gradient-to-br from-teal-600 to-teal-700 p-6 text-white shadow-[0_25px_50px_-30px_rgba(13,148,136,0.7)]">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-xl">✦</div>
        <p class="text-3xl font-black">1.5K+</p>
        <p class="mt-2 text-sm text-teal-50/90">Anggota komunitas aktif yang terhubung dalam dukungan dan edukasi.</p>
    </div>
    <div class="kph-card rounded-[2rem] border border-sky-100 bg-white p-6 shadow-[0_25px_50px_-35px_rgba(14,165,233,0.4)]">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-100 text-xl text-sky-700">✓</div>
        <p class="text-3xl font-black text-slate-900">35+</p>
        <p class="mt-2 text-sm leading-6 text-slate-600">Program edukasi dan kegiatan komunitas yang terus berkembang setiap bulan.</p>
    </div>
    <div class="kph-card rounded-[2rem] border border-amber-100 bg-gradient-to-br from-amber-50 to-white p-6 shadow-[0_25px_50px_-35px_rgba(245,158,11,0.4)]">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-xl text-amber-700">◎</div>
        <p class="text-3xl font-black text-slate-900">24/7</p>
        <p class="mt-2 text-sm leading-6 text-slate-600">Informasi, bantuan, dan ruang diskusi untuk keluarga serta penyintas hepatitis.</p>
    </div>
</section>

<div id="informasi" class="mb-7 flex scroll-mt-28 flex-wrap items-end justify-between gap-4 sm:mb-9">
    <div>
        <p class="text-sm font-bold uppercase tracking-[0.16em] text-blue-600">{{ $siteSettings->postsSectionLabel() }}</p>
        <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">{{ $siteSettings->postsSectionTitle() }}</h2>
    </div>
    <p class="max-w-xs text-right text-sm leading-6 text-slate-500">{{ $siteSettings->postsSectionDescription() }}</p>
</div>

<form method="GET" action="{{ route('home') }}" class="kph-card mb-8 rounded-[2rem] border border-slate-200 bg-white p-4 shadow-[0_20px_45px_-32px_rgba(15,23,42,0.18)] sm:p-5">
    <div class="flex flex-col gap-3 xl:flex-row">
        <label class="relative flex-1">
            <span class="sr-only">Cari berita berdasarkan judul atau isi</span>
            <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">⌕</span>
            <input type="search" name="post_search" value="{{ $postSearch }}" placeholder="Cari berita, judul, atau isi..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
        </label>
        <label class="xl:w-56">
            <span class="sr-only">Pilih kategori berita</span>
            <select name="post_category" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
                <option value="">Categories</option>
                @foreach ($postCategories as $category)
                    <option value="{{ $category->slug }}" @selected($postCategory === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="xl:w-56">
            <span class="sr-only">Pilih tag berita</span>
            <select name="post_tag" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
                <option value=""># Tags</option>
                @foreach ($postTags as $tag)
                    <option value="{{ $tag->slug }}" @selected($postTag === $tag->slug)># {{ $tag->name }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit" class="rounded-2xl bg-blue-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-700/20 transition hover:bg-blue-800">Cari</button>
        @if ($postSearch !== '' || filled($postCategory) || filled($postTag))
            <a href="{{ route('home') }}" class="rounded-2xl border border-slate-200 px-6 py-3 text-center text-sm font-bold text-slate-600 transition hover:bg-slate-50">Reset</a>
        @endif
    </div>
</form>

@if ($featuredPost || $archivePosts->isNotEmpty())
    @if ($featuredPost)
    <article class="kph-card group relative mb-6 grid overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_25px_60px_-30px_rgba(30,64,175,0.24)] transition duration-300 hover:border-blue-100 hover:shadow-xl hover:shadow-blue-900/10 lg:grid-cols-2">
        <div class="relative min-h-64 overflow-hidden lg:min-h-96">
            <img src="{{ $featuredPost->cover_image ? Storage::disk('public')->url($featuredPost->cover_image) : 'https://placehold.co/900x600?text=No+Image' }}"
                 alt="{{ $featuredPost->title }}"
                 class="h-full min-h-64 w-full bg-slate-100 object-cover transition duration-700 group-hover:scale-105 lg:min-h-96">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/65 via-slate-950/10 to-transparent"></div>
            <span class="absolute left-5 top-5 rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-blue-700 shadow-sm">
                Berita pilihan
            </span>
        </div>
        <div class="flex flex-col justify-center p-6 sm:p-8 lg:p-10">
            <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-xs">
                <time datetime="{{ $featuredPost->published_at?->toIso8601String() }}" class="text-gray-500">
                    {{ ($featuredPost->published_at ?? $featuredPost->updated_at)?->isoFormat('D MMMM Y') ?? 'Tanggal belum tersedia' }}
                </time>
                <span class="rounded-full bg-blue-50 px-3 py-1.5 font-semibold text-blue-600">
                    {{ $featuredPost->category->name }}
                </span>
            </div>
            <div class="group relative">
                <h3 class="mt-4 text-2xl font-black leading-tight text-slate-900 transition group-hover:text-blue-600 sm:text-3xl">
                    <a href="{{ route('posts.show', $featuredPost->slug) }}">
                        <span class="absolute inset-0"></span>
                        {{ $featuredPost->title }}
                    </a>
                </h3>
                <p class="mt-4 line-clamp-4 text-sm leading-7 text-slate-500 sm:text-base">
                    {{ Str::limit(strip_tags($featuredPost->content), 220) }}
                </p>
            </div>
            <div class="mt-auto flex items-center gap-x-3 border-t border-slate-100 pt-5">
                <div class="text-sm leading-6">
                    <p class="font-semibold text-slate-900">
                        <span class="font-normal text-slate-400">Oleh</span> {{ $featuredPost->author->name }}
                    </p>
                </div>
            </div>
        </div>
    </article>

    @endif

    @if ($archivePosts->isNotEmpty())
        <div class="mb-4 flex items-center gap-3">
            <span class="h-px flex-1 bg-slate-200"></span>
            <span class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Berita lainnya</span>
            <span class="h-px flex-1 bg-slate-200"></span>
        </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($archivePosts as $post)
            <article class="group flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-blue-100 hover:shadow-xl hover:shadow-blue-900/10">
                <div class="relative w-full overflow-hidden">
                    <img src="{{ $post->cover_image ? Storage::disk('public')->url($post->cover_image) : 'https://placehold.co/600x400?text=No+Image' }}"
                         alt="{{ $post->title }}"
                         class="aspect-[16/10] w-full bg-slate-100 object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-950/50 to-transparent"></div>
                </div>
                <div class="flex flex-1 flex-col p-5 sm:p-6">
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-xs">
                        <time datetime="{{ $post->published_at?->toIso8601String() }}" class="text-gray-500">
                            {{ ($post->published_at ?? $post->updated_at)?->isoFormat('D MMMM Y') ?? 'Tanggal belum tersedia' }}
                        </time>
                        <span class="rounded-full bg-blue-50 px-3 py-1.5 font-semibold text-blue-600">
                            {{ $post->category->name }}
                        </span>
                    </div>
                    <div class="group relative">
                        <h3 class="mt-4 text-lg font-bold leading-7 text-slate-900 transition group-hover:text-blue-600 sm:text-xl">
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <span class="absolute inset-0"></span>
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-500">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>
                    </div>
                    <div class="mt-auto flex items-center gap-x-3 border-t border-slate-100 pt-5">
                        <div class="text-sm leading-6">
                            <p class="font-semibold text-slate-900">
                                <span class="font-normal text-slate-400">Oleh</span> {{ $post->author->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        <nav class="mt-10 flex flex-wrap items-center justify-center gap-3 rounded-[2rem] border border-slate-200 bg-white p-4 shadow-sm sm:p-5" aria-label="Navigasi arsip berita">
            @if ($archivePosts->onFirstPage())
                <span class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-300" aria-disabled="true">← Previous</span>
            @else
                <a href="{{ $archivePosts->previousPageUrl() }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">← Previous</a>
            @endif

            <span class="rounded-xl bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-700">
                {{ $archivePosts->currentPage() }} / {{ $archivePosts->lastPage() }}
            </span>

            @if ($archivePosts->hasMorePages())
                <a href="{{ $archivePosts->nextPageUrl() }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">Next →</a>
            @else
                <span class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-300" aria-disabled="true">Next →</span>
            @endif
        </nav>
    @endif
@else
    <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
        <p class="text-sm font-semibold text-slate-600">Belum ada informasi yang dipublikasikan.</p>
        <p class="mt-2 text-sm text-slate-400">Silakan kembali lagi untuk membaca kabar terbaru komunitas.</p>
    </div>
@endif

<div class="mt-12 rounded-[2rem] border border-teal-100 bg-gradient-to-r from-teal-600 via-teal-700 to-cyan-700 p-6 text-white shadow-[0_25px_60px_-35px_rgba(13,148,136,0.8)] sm:p-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-teal-50/80">Bergabung bersama kami</p>
            <h2 class="mt-2 text-2xl font-black">Ikuti komunitas, dapatkan informasi, dan dukung perjuangan kesehatan bersama.</h2>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('community-members.create') }}" class="rounded-full bg-white px-5 py-3 text-sm font-bold text-teal-700 transition hover:bg-teal-50">Gabung komunitas</a>
            <a href="{{ route('galleries.index') }}" class="rounded-full border border-white/30 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/10">Lihat galeri</a>
        </div>
    </div>
</div>

@if ($youtubeVideos->isNotEmpty() || $videoSearch !== '' || filled($videoCategory))
    <section class="mt-14 rounded-[2rem] border border-teal-100 bg-teal-50/60 px-5 py-8 sm:px-8 sm:py-10">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-teal-700">Dokumentasi</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">Video YouTube</h2>
            </div>
            <p class="max-w-md text-sm leading-6 text-slate-500">Saksikan dokumentasi kegiatan dan cerita komunitas melalui kanal YouTube kami.</p>
        </div>
        <form method="GET" action="{{ route('home') }}" class="mb-7 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex flex-col gap-3 lg:flex-row">
                <label class="relative flex-1">
                    <span class="sr-only">Cari video berdasarkan judul, deskripsi, atau URL</span>
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">⌕</span>
                    <input type="search" name="video_search" value="{{ $videoSearch }}" placeholder="Cari judul atau deskripsi video..." class="w-full rounded-2xl border border-slate-200 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-teal-500 focus:ring-2 focus:ring-teal-100">
                </label>
                <label class="lg:w-56">
                    <span class="sr-only">Pilih kategori video</span>
                    <select name="video_category" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-teal-500 focus:ring-2 focus:ring-teal-100">
                        <option value="">Semua kategori</option>
                        @foreach ($videoCategories as $category)
                            <option value="{{ $category }}" @selected($videoCategory === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </label>
                <button type="submit" class="rounded-2xl bg-teal-700 px-6 py-3 text-sm font-bold text-white transition hover:bg-teal-800">Cari</button>
                @if ($videoSearch !== '' || filled($videoCategory))
                    <a href="{{ route('home') }}" class="rounded-2xl border border-slate-200 px-6 py-3 text-center text-sm font-bold text-slate-600 transition hover:bg-slate-50">Reset</a>
                @endif
            </div>
        </form>
        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($youtubeVideos as $video)
                @if ($video->youtubeId())
                    <article x-data="{ playing: false }" class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <div class="relative aspect-video overflow-hidden bg-slate-900">
                            <template x-if="playing">
                                <iframe src="{{ $video->embedUrl() }}?autoplay=1&rel=0"
                                        title="{{ $video->title }}"
                                        class="absolute inset-0 h-full w-full"
                                        loading="lazy"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                            </template>
                            <template x-if="!playing">
                                <button type="button"
                                        @click="playing = true"
                                        class="group absolute inset-0 h-full w-full"
                                        aria-label="Putar {{ $video->title }}">
                                    <img src="{{ $video->thumbnailUrl() }}" alt="{{ $video->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    <span class="absolute inset-0 flex items-center justify-center bg-slate-950/10 transition group-hover:bg-slate-950/25">
                                        <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl text-teal-600 shadow-xl">▶</span>
                                    </span>
                                </button>
                            </template>
                        </div>
                        <div class="flex items-center justify-between gap-4 p-5">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-teal-700">YouTube</p>
                                @if ($video->category)
                                    <span class="mt-2 inline-flex rounded-full bg-teal-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-teal-700">{{ $video->category }}</span>
                                @endif
                                <h3 class="mt-2 font-black text-slate-900">{{ $video->title }}</h3>
                            </div>
                            <span class="shrink-0 text-sm font-bold text-teal-700" x-show="!playing">Putar di sini →</span>
                            <span class="shrink-0 text-sm font-semibold text-slate-400" x-show="playing">Sedang diputar</span>
                        </div>
                    </article>
                @endif
            @endforeach
        </div>
        @if ($youtubeVideos->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-10 text-center">
                <p class="font-semibold text-slate-600">Video tidak ditemukan.</p>
                <p class="mt-2 text-sm text-slate-400">Coba gunakan kata kunci atau kategori lain.</p>
            </div>
        @endif
        @if ($youtubeVideos->hasPages())
            <nav class="mt-7 flex flex-wrap items-center justify-center gap-3" aria-label="Navigasi video YouTube">
                @if ($youtubeVideos->onFirstPage())
                    <span class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-300" aria-disabled="true">← Sebelumnya</span>
                @else
                    <a href="{{ $youtubeVideos->previousPageUrl() }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-teal-200 hover:bg-teal-50 hover:text-teal-700">← Sebelumnya</a>
                @endif

                <span class="rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-700/20">
                    Video {{ $youtubeVideos->currentPage() }} dari {{ $youtubeVideos->lastPage() }}
                </span>

                @if ($youtubeVideos->hasMorePages())
                    <a href="{{ $youtubeVideos->nextPageUrl() }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-teal-700 transition hover:border-teal-200 hover:bg-teal-50">Next →</a>
                @else
                    <span class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-300" aria-disabled="true">Next →</span>
                @endif
            </nav>
        @endif
    </section>
@endif

@endsection