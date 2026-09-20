@extends('layouts.app')

@php($siteSettings = \App\Models\SiteSetting::current())

@section('title', $gallery->title.' - Galeri Kegiatan - '.$siteSettings->site_name)

@section('content')
<article class="mx-auto max-w-5xl" x-data="{ active: 0, images: @js($gallery->imageUrls()) }">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('galleries.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 shadow-sm transition hover:border-teal-200 hover:bg-teal-50 hover:text-teal-700">
            <span aria-hidden="true">←</span>
            Kembali ke galeri
        </a>
        <span class="rounded-full bg-teal-50 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-teal-700 ring-1 ring-teal-100">
            {{ $gallery->category }}
        </span>
    </div>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_30px_70px_-35px_rgba(15,23,42,0.2)]">
        <div class="relative bg-slate-950">
            <img :src="images[active]" alt="{{ $gallery->title }}" class="mx-auto max-h-[70vh] w-full object-contain">
            <template x-if="images.length > 1">
                <div>
                    <button type="button" @click="active = active === 0 ? images.length - 1 : active - 1"
                            class="absolute left-4 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-2xl font-bold text-slate-800 shadow-lg transition hover:bg-white"
                            aria-label="Foto sebelumnya">‹</button>
                    <button type="button" @click="active = active === images.length - 1 ? 0 : active + 1"
                            class="absolute right-4 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-2xl font-bold text-slate-800 shadow-lg transition hover:bg-white"
                            aria-label="Foto berikutnya">›</button>
                    <p class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-slate-950/70 px-3 py-1.5 text-xs font-bold text-white">
                        Foto <span x-text="active + 1"></span> dari <span x-text="images.length"></span>
                    </p>
                </div>
            </template>
        </div>
        <div class="p-6 sm:p-10">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-teal-700">Dokumentasi kegiatan</p>
                    <h1 class="mt-3 text-3xl font-black tracking-tight text-slate-900 sm:text-5xl">{{ $gallery->title }}</h1>
                </div>
                @if ($gallery->event_date)
                    <time datetime="{{ $gallery->event_date->toDateString() }}" class="rounded-xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600 ring-1 ring-slate-200">
                        {{ $gallery->event_date->isoFormat('D MMMM Y') }}
                    </time>
                @endif
            </div>

            @if ($gallery->description)
                <div class="mt-6 whitespace-pre-line text-base leading-8 text-slate-600">
                    {{ $gallery->description }}
                </div>
            @endif
        </div>
    </div>
</article>
@endsection
