<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php($siteSettings = \App\Models\SiteSetting::current())
    <title>@yield('title', $siteSettings->site_name.' - Edukasi dan Dukungan Hepatitis')</title>
    <link rel="icon" href="{{ asset('img/favicon_io/favicon.ico') }}" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    @stack('seo')
</head>
<body class="bg-slate-50 font-[Inter] antialiased text-slate-900">

    <nav class="sticky top-0 z-50 border-b border-teal-100/80 bg-white/90 shadow-sm backdrop-blur-xl">
        <div class="mx-auto flex min-h-20 max-w-7xl flex-wrap items-center justify-between gap-x-4 gap-y-3 px-4 py-4 sm:flex-nowrap sm:px-6 lg:px-8">
            <a href="/" class="group flex min-w-0 shrink items-center gap-3">
                @if ($siteSettings->logoUrl($siteSettings->logo_path))
                    <img src="{{ $siteSettings->logoUrl($siteSettings->logo_path) }}"
                         alt="{{ $siteSettings->site_name }}"
                         class="block max-h-10 w-auto max-w-40 object-contain sm:max-h-12 sm:max-w-52">
                @else
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-teal-600 text-lg font-black text-white shadow-lg shadow-teal-600/20">
                        {{ mb_strtoupper(mb_substr($siteSettings->site_name, 0, 1)) }}
                    </span>
                    <span class="truncate text-lg font-extrabold tracking-tight text-slate-900 transition group-hover:text-teal-600 sm:text-xl">
                        {{ $siteSettings->site_name }}
                    </span>
                @endif
            </a>
            <div class="order-3 w-full overflow-x-auto sm:order-2 sm:w-auto">
                <div class="mx-auto flex w-max items-center gap-1 rounded-full border border-slate-200 bg-white/80 p-1 shadow-sm">
                <a href="/" class="rounded-full bg-teal-50 px-4 py-2 text-xs font-bold text-teal-700 transition hover:bg-teal-100 sm:text-sm">
                    Beranda
                </a>
                <a href="{{ route('community-members.create') }}" class="whitespace-nowrap rounded-full px-4 py-2 text-xs font-semibold text-slate-500 transition hover:bg-teal-50 hover:text-teal-700 sm:text-sm">
                    Gabung Komunitas
                </a>
                <a href="{{ route('about') }}" class="whitespace-nowrap rounded-full px-4 py-2 text-xs font-semibold text-slate-500 transition hover:bg-teal-50 hover:text-teal-700 sm:text-sm">
                    Tentang Kami
                </a>
                <a href="{{ route('galleries.index') }}" class="whitespace-nowrap rounded-full px-4 py-2 text-xs font-semibold text-slate-500 transition hover:bg-teal-50 hover:text-teal-700 sm:text-sm">
                    Galeri
                </a>
                <a href="{{ route('faq.index') }}" class="whitespace-nowrap rounded-full px-4 py-2 text-xs font-semibold text-slate-500 transition hover:bg-teal-50 hover:text-teal-700 sm:text-sm">
                    FAQ
                </a>
                </div>
            </div>
            <div class="order-2 ml-auto flex min-w-0 shrink-0 items-center gap-2 sm:order-3 sm:gap-3">
                <a href="/admin/login" class="hidden whitespace-nowrap rounded-full px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-teal-50 hover:text-teal-700 sm:inline-flex">
                    Pengurus
                </a>
                <a href="{{ route('community-members.create') }}" class="whitespace-nowrap rounded-full bg-teal-600 px-3 py-2 text-xs font-bold text-white shadow-lg shadow-teal-600/20 transition hover:-translate-y-0.5 hover:bg-teal-700 sm:px-5 sm:text-sm">
                    Gabung
                </a>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        @yield('content')
    </main>

    <footer class="mt-12 border-t border-teal-100 bg-white py-10 sm:mt-20 sm:py-14">
        <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <div class="mx-auto mb-6 h-1 w-12 rounded-full bg-teal-600"></div>
            <p class="text-sm text-slate-500">{{ $siteSettings->footerText() }}</p>
            <p class="mx-auto mt-3 max-w-2xl text-xs leading-5 text-slate-400">
                Informasi di website ini bersifat edukatif dan tidak menggantikan konsultasi dengan tenaga kesehatan.
            </p>
            @if ($siteSettings->socialLinks())
                <div class="mt-6 flex flex-wrap items-center justify-center gap-2">
                    @foreach ($siteSettings->socialLinks() as $socialLink)
                        <a href="{{ $socialLink['url'] }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:-translate-y-0.5 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-white text-[10px] font-black text-blue-600 shadow-sm">
                                {{ mb_strtoupper(mb_substr($socialLink['label'], 0, 1)) }}
                            </span>
                            {{ $socialLink['label'] }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </footer>

    @if ($siteSettings->helpWidgetEnabled())
        <div x-data="{ open: false }" class="fixed bottom-5 right-4 z-50 sm:bottom-7 sm:right-7">
            <button type="button" @click="open = true" class="flex items-center gap-3 rounded-full bg-white px-4 py-3 shadow-xl shadow-slate-900/15 ring-1 ring-slate-200 transition hover:-translate-y-1">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-green-500 text-xl text-white">◔</span>
                <span class="text-left">
                    <strong class="block text-sm font-black text-slate-900">Butuh Bantuan?</strong>
                    <small class="block text-xs text-slate-500">Konsultasi komunitas</small>
                </span>
                <span class="flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-[10px] font-bold text-green-700">
                    <span class="h-2 w-2 rounded-full bg-green-500"></span> Online
                </span>
            </button>

            <div x-cloak x-show="open" x-transition.opacity class="fixed inset-0 flex items-end justify-center bg-slate-950/30 p-4 sm:items-center" @click.self="open = false">
                <div x-show="open" x-transition class="w-full max-w-md rounded-[2rem] bg-white p-5 shadow-2xl sm:p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="inline-flex rounded-full bg-teal-50 px-3 py-1.5 text-xs font-bold text-teal-700">{{ $siteSettings->help_widget_badge }}</span>
                            <h2 class="mt-3 text-2xl font-black text-slate-900">{{ $siteSettings->help_widget_title }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">{{ $siteSettings->help_widget_description }}</p>
                        </div>
                        <button type="button" @click="open = false" class="rounded-xl bg-slate-100 px-3 py-2 text-lg text-slate-600 hover:bg-slate-200">×</button>
                    </div>
                    <div class="mt-5 rounded-2xl border border-teal-100 bg-teal-50/40 p-4 text-sm leading-6 text-slate-600">
                        <span class="mb-2 inline-flex rounded-full bg-white px-3 py-1 text-xs font-bold text-teal-700">● Online sekarang</span>
                        <p>Kami siap membantu pertanyaan, edukasi, dan dukungan seputar hepatitis.</p>
                    </div>
                    <div class="mt-4 space-y-3">
                        @if (filled($siteSettings->help_widget_whatsapp))
                            <a href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSettings->help_widget_whatsapp) }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 rounded-2xl bg-green-500 px-4 py-4 text-white shadow-lg shadow-green-500/20 transition hover:bg-green-600">
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-white/20 text-xl">◔</span>
                                <span><strong class="block">Chat WhatsApp</strong><small class="text-green-50">Admin: {{ $siteSettings->help_widget_whatsapp }}</small></span>
                            </a>
                        @endif
                        @if (filled($siteSettings->help_widget_faq_url))
                            <a href="{{ $siteSettings->help_widget_faq_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 rounded-2xl bg-slate-50 px-4 py-4 text-slate-800 transition hover:bg-teal-50">
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-teal-100 text-xl text-teal-700">?</span>
                                <span><strong class="block">Lihat FAQ</strong><small class="text-slate-500">Jawaban cepat pertanyaan umum</small></span>
                            </a>
                        @endif
                        @if (filled($siteSettings->help_widget_email))
                            <a href="mailto:{{ $siteSettings->help_widget_email }}" class="flex items-center gap-4 rounded-2xl bg-slate-50 px-4 py-4 text-slate-800 transition hover:bg-teal-50">
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-teal-100 text-xl text-teal-700">@</span>
                                <span><strong class="block">Email admin</strong><small class="block break-all text-slate-500">{{ $siteSettings->help_widget_email }}</small></span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

</body>
</html>