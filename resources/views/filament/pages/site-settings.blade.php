<x-filament-panels::page>
    <div class="mb-6 overflow-hidden rounded-2xl border border-primary-200 bg-gradient-to-br from-primary-50 via-white to-gray-50 shadow-sm">
        <div class="flex items-start gap-4 p-5 sm:p-6">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-primary-600 text-lg text-white shadow-sm">✦</div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-primary-700">Pengaturan Website</p>
                <h2 class="mt-1 text-lg font-bold text-gray-950">Kelola tampilan website</h2>
                <p class="mt-1 max-w-3xl text-sm leading-6 text-gray-600">Atur identitas, media sosial, konten beranda, galeri, FAQ, dan bantuan dari satu halaman.</p>
            </div>
        </div>
        <nav class="flex gap-2 overflow-x-auto border-t border-primary-100 bg-white/70 px-4 py-3 sm:px-6" aria-label="Navigasi pengaturan website">
            <a href="#identitas-website" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 transition hover:bg-primary-50 hover:text-primary-700">Identitas</a>
            <a href="#tampilan-beranda" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 transition hover:bg-primary-50 hover:text-primary-700">Beranda</a>
            <a href="#hero-galeri" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 transition hover:bg-primary-50 hover:text-primary-700">Galeri</a>
            <a href="#hero-faq" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 transition hover:bg-primary-50 hover:text-primary-700">FAQ</a>
            <a href="#slider-hero" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 transition hover:bg-primary-50 hover:text-primary-700">Slider Hero</a>
            <a href="#widget-bantuan" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 transition hover:bg-primary-50 hover:text-primary-700">Bantuan</a>
        </nav>
    </div>
    <form wire:submit="save">
        <div class="space-y-5">
            {{ $this->form }}
        </div>

        <div class="sticky bottom-4 z-20 mt-8 flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white/95 p-4 shadow-lg backdrop-blur sm:flex-row sm:items-center sm:justify-between sm:p-5">
            <p class="text-xs leading-5 text-gray-500">Periksa kembali perubahan sebelum disimpan. URL sosial media wajib diawali <span class="font-semibold text-gray-700">https://</span>.</p>
            <x-filament::button type="submit" icon="heroicon-m-check">
                Simpan pengaturan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
