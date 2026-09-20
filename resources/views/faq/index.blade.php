@extends('layouts.app')

@section('title', 'FAQ - '.$siteSettings->site_name)

@section('content')
<div class="mb-6 text-sm text-slate-500">
    <a href="{{ route('home') }}" class="hover:text-teal-700">Beranda</a>
    <span class="mx-2">/</span>
    <span class="font-semibold text-teal-700">FAQ</span>
</div>

<section class="relative mb-8 overflow-hidden rounded-[2rem] border border-teal-100 bg-gradient-to-br from-teal-50 via-white to-cyan-50 px-6 py-10 shadow-[0_30px_70px_-40px_rgba(15,118,110,0.35)] sm:px-10 sm:py-14">
    <div class="pointer-events-none absolute -right-16 -top-20 h-72 w-72 rounded-full bg-teal-200/40 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-20 left-10 h-52 w-52 rounded-full bg-cyan-200/30 blur-3xl"></div>
    <div class="relative max-w-4xl">
        <span class="inline-flex rounded-full bg-teal-100 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-teal-800 ring-1 ring-teal-200/70">{{ $siteSettings->faqHeroBadge() }}</span>
        <h1 class="mt-5 text-4xl font-black leading-tight tracking-tight text-slate-900 sm:text-6xl">{{ $siteSettings->faqHeroTitle() }}</h1>
        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-600">{{ $siteSettings->faqHeroDescription() }}</p>
    </div>
</section>

@if ($faqs->isNotEmpty())
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($faqs as $faq)
            <article class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-[0_20px_40px_-35px_rgba(15,23,42,0.2)] transition duration-300 hover:-translate-y-1 hover:border-teal-200 hover:shadow-[0_26px_50px_-30px_rgba(13,148,136,0.35)]">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-teal-600 to-cyan-600 text-xl font-black text-white shadow-lg shadow-teal-600/20">?</div>
                <h2 class="mt-5 text-xl font-black leading-7 text-slate-900">{{ $faq->question }}</h2>
                <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-500">{{ $faq->answer }}</p>
            </article>
        @endforeach
    </div>

    @if ($faqs->hasPages())
        <nav class="mt-10 flex flex-wrap items-center justify-center gap-3 rounded-[2rem] border border-slate-200 bg-white p-4 shadow-sm sm:p-5" aria-label="Navigasi halaman FAQ">
            @if ($faqs->onFirstPage())
                <span class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-300" aria-disabled="true">← Sebelumnya</span>
            @else
                <a href="{{ $faqs->previousPageUrl() }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-teal-200 hover:bg-teal-50 hover:text-teal-700">← Sebelumnya</a>
            @endif

            <span class="rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-700/20">
                Halaman {{ $faqs->currentPage() }} dari {{ $faqs->lastPage() }}
            </span>

            @if ($faqs->hasMorePages())
                <a href="{{ $faqs->nextPageUrl() }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-teal-200 hover:bg-teal-50 hover:text-teal-700">Berikutnya →</a>
            @else
                <span class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-300" aria-disabled="true">Berikutnya →</span>
            @endif
        </nav>
    @endif
@else
    <div class="rounded-[2rem] border border-dashed border-slate-300 bg-white px-6 py-14 text-center shadow-sm">
        <p class="font-semibold text-slate-600">Belum ada FAQ yang dipublikasikan.</p>
    </div>
@endif

<div class="mt-10 rounded-[2rem] border border-teal-100 bg-gradient-to-r from-sky-50 via-white to-teal-50 p-6 shadow-[0_20px_45px_-35px_rgba(14,165,233,0.35)] sm:p-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-sky-700">{{ $siteSettings->faqCtaBadge() }}</p>
            <h2 class="mt-2 text-2xl font-black text-slate-900">{{ $siteSettings->faqCtaTitle() }}</h2>
        </div>
        <a href="{{ route('community-members.create') }}" class="rounded-full bg-teal-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-teal-600/20 transition hover:bg-teal-700">{{ $siteSettings->faqCtaButtonLabel() }}</a>
    </div>
</div>
@endsection
