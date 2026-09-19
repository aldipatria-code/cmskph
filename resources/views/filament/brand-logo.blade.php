@php
    $settings = \App\Models\SiteSetting::current();
    $logoUrl = $settings->logoUrl($settings->login_logo_path ?? $settings->logo_path);
@endphp

<a href="{{ url('/admin') }}" class="flex min-w-0 max-w-full items-center gap-2 overflow-hidden">
    @if ($logoUrl)
        <img src="{{ $logoUrl }}"
             alt="{{ $settings->site_name }}"
             class="block w-auto object-contain"
             style="max-height: 2.5rem; max-width: 12rem;">
    @else
        <span class="truncate text-lg font-extrabold tracking-tight text-primary-600 sm:text-xl">
            {{ $settings->site_name }}
        </span>
    @endif
</a>
