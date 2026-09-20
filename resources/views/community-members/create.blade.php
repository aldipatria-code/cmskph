@extends('layouts.app')

@php($communitySiteSettings = \App\Models\SiteSetting::current())

@section('title', 'Gabung Komunitas - '.$communitySiteSettings->site_name)

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-8 text-center">
        <span class="inline-flex rounded-full bg-blue-50 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-blue-600 ring-1 ring-blue-100">
            Bergabung bersama kami
        </span>
        <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Daftar sebagai anggota komunitas</h1>
        <p class="mx-auto mt-3 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
            Bergabung untuk mendapatkan informasi edukasi, kegiatan, dan dukungan seputar hepatitis.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('community-members.store') }}" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_30px_70px_-35px_rgba(37,99,235,0.25)] sm:p-8">
        @csrf
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama lengkap <span class="text-red-500">*</span></label>
                <input id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition focus:border-blue-500 focus:bg-white focus:ring-blue-500" placeholder="Nama lengkap Anda">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email <span class="text-red-500">*</span></label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" inputmode="email" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition focus:border-blue-500 focus:bg-white focus:ring-blue-500" placeholder="nama@email.com">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="age" class="mb-2 block text-sm font-semibold text-slate-700">Umur <span class="text-red-500">*</span></label>
                <input id="age" type="number" name="age" value="{{ old('age') }}" min="1" max="120" inputmode="numeric" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition focus:border-blue-500 focus:bg-white focus:ring-blue-500" placeholder="Contoh: 30">
                <p class="mt-1 text-xs text-slate-500">Masukkan umur dalam tahun.</p>
                @error('age') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">Nomor WhatsApp</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" inputmode="numeric" pattern="[0-9]{8,15}" minlength="8" maxlength="15" autocomplete="tel" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition focus:border-blue-500 focus:bg-white focus:ring-blue-500" placeholder="08xxxxxxxxxx">
                <p class="mt-1 text-xs text-slate-500">Masukkan angka saja, 8-15 digit.</p>
                @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <p class="mb-2 block text-sm font-semibold text-slate-700">Pernah atau sedang terjangkit hepatitis</p>
                <div class="grid gap-3 sm:grid-cols-3">
                    @foreach (['a' => 'Hepatitis A', 'b' => 'Hepatitis B', 'c' => 'Hepatitis C'] as $type => $label)
                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition hover:border-blue-200 hover:bg-blue-50/40">
                            <input type="checkbox" name="hepatitis_{{ $type }}" value="1" @checked(old('hepatitis_'.$type)) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
                <p class="mt-1 text-xs text-slate-500">Centang sesuai kondisi yang pernah atau sedang dialami.</p>
            </div>
            <div>
                <label for="city" class="mb-2 block text-sm font-semibold text-slate-700">Kota domisili</label>
                <input id="city" name="city" value="{{ old('city') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition focus:border-blue-500 focus:bg-white focus:ring-blue-500" placeholder="Contoh: Jakarta">
            </div>
            <div>
                <label for="occupation" class="mb-2 block text-sm font-semibold text-slate-700">Pekerjaan</label>
                <input id="occupation" name="occupation" value="{{ old('occupation') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition focus:border-blue-500 focus:bg-white focus:ring-blue-500" placeholder="Pekerjaan atau aktivitas">
            </div>
            <div class="sm:col-span-2">
                <label for="reason" class="mb-2 block text-sm font-semibold text-slate-700">Alasan bergabung</label>
                <textarea id="reason" name="reason" rows="4" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm transition focus:border-blue-500 focus:bg-white focus:ring-blue-500" placeholder="Ceritakan ketertarikan Anda bergabung dengan komunitas...">{{ old('reason') }}</textarea>
            </div>
            <label class="flex items-start gap-3 rounded-xl bg-slate-50 p-4 sm:col-span-2">
                <input type="checkbox" name="consent" value="1" @checked(old('consent')) required class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <span class="text-xs leading-5 text-slate-600">Saya menyetujui data ini digunakan untuk keperluan komunikasi dan kegiatan Komunitas Peduli Hepatitis.</span>
            </label>
            @error('consent') <p class="text-xs text-red-600 sm:col-span-2">{{ $message }}</p> @enderror
        </div>
        <div class="mt-6 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('home') }}" class="rounded-xl px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Kembali</a>
            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700">Kirim pendaftaran</button>
        </div>
    </form>
</div>
@endsection
