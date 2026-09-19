<?php

namespace App\Http\Controllers;

use App\Models\CommunityMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunityMemberController extends Controller
{
    public function create(): View
    {
        return view('community-members.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'hepatitis_a' => ['boolean'],
            'hepatitis_b' => ['boolean'],
            'hepatitis_c' => ['boolean'],
            'phone' => ['nullable', 'digits_between:8,15'],
            'city' => ['nullable', 'string', 'max:100'],
            'occupation' => ['nullable', 'string', 'max:150'],
            'reason' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Masukkan alamat email yang valid, contoh: nama@email.com.',
            'age.integer' => 'Umur harus berupa angka.',
            'age.required' => 'Umur wajib diisi.',
            'age.min' => 'Umur minimal 1 tahun.',
            'age.max' => 'Umur maksimal 120 tahun.',
            'phone.digits_between' => 'Nomor WhatsApp harus berupa angka 8 sampai 15 digit.',
            'consent.accepted' => 'Persetujuan pemrosesan data wajib dicentang.',
        ]);

        CommunityMember::create(array_merge([
            'hepatitis_a' => false,
            'hepatitis_b' => false,
            'hepatitis_c' => false,
        ], $validated, ['status' => 'pending']));

        return redirect()
            ->route('community-members.create')
            ->with('success', 'Pendaftaran berhasil dikirim. Tim kami akan menghubungi Anda setelah data ditinjau.');
    }
}
