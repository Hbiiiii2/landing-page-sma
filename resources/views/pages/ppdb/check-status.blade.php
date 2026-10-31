@extends('layouts.public')

@section('title', 'Cek Status Pendaftaran PPDB — SMA Islam Al-Madinah BSD')
@section('meta_description', 'Pantau status verifikasi berkas dan hasil seleksi santri baru PPDB SMA Islam Al-Madinah BSD secara mandiri.')

@section('content')
@php
    $schoolName = $profile->name ?? 'SMA Islam Al-Madinah BSD';
    $waUrlPanitia = $profile?->whatsapp_panitia_url ?? ('https://wa.me/' . ($profile?->whatsapp_ppdb_clean ?? '6281299887766'));
@endphp

<!-- Header Banner -->
<section class="relative bg-gradient-to-br from-[#3E2B52] via-[#543A70] to-[#704E94] text-white py-14 lg:py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
    <div class="relative max-w-[1280px] mx-auto px-4 lg:px-8 text-center space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-semibold text-emerald-200">
            <span class="w-1.5 h-1.5 rounded-full bg-[#2A923F]"></span>
            <span>STATUS REGISTRASI</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
            Cek Status Pendaftaran PPDB
        </h1>
        <p class="text-sm sm:text-base text-white/85 max-w-lg mx-auto leading-relaxed">
            Pantau status verifikasi berkas dan hasil seleksi santri baru SMA Islam Al-Madinah BSD secara mandiri.
        </p>
    </div>
</section>

<section class="py-12 lg:py-16 bg-[#FAF9FB]">
    <div class="max-w-[720px] mx-auto px-4 lg:px-8 space-y-8">
        
        <!-- Search Box Form -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#E7E3EA] p-5 sm:p-8 shadow-sm space-y-4">
            <h2 class="text-sm font-bold text-[#202124]">Masukkan Nomor Registrasi / NIK / NISN</h2>
            
            <form action="{{ route('ppdb.check-status') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5">
                <input type="text" 
                       name="search" 
                       value="{{ $query ?? '' }}"
                       required
                       placeholder="Contoh: REG-2027-0001 atau NIK/NISN" 
                       class="w-full px-4 py-3 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                <button type="submit" 
                        class="w-full sm:w-auto px-7 py-3 rounded-xl bg-[#9377AD] hover:bg-[#796092] text-white font-extrabold text-xs uppercase tracking-wide transition-all shadow-sm shrink-0 text-center">
                    Cek Status
                </button>
            </form>
            <p class="text-[11px] text-[#66676B]">
                Nomor registrasi tertera pada bukti pendaftaran yang didapatkan saat selesai mengisi formulir.
            </p>
        </div>

        <!-- Result Display -->
        @if ($query)
            @if ($registration)
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#E7E3EA] p-5 sm:p-8 shadow-md space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#E7E3EA] pb-5">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-[#66676B] tracking-wider">Nomor Registrasi:</span>
                            <div class="text-xl font-mono font-black text-[#684681]">
                                {{ $registration->registration_number }}
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div>
                            @if ($registration->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    <span>Menunggu Verifikasi</span>
                                </span>
                            @elseif ($registration->status === 'verified')
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200">
                                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Berkas Terverifikasi</span>
                                </span>
                            @elseif ($registration->status === 'accepted')
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span>Diterima (Lulus)</span>
                                </span>
                            @elseif ($registration->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-800 border border-red-200">
                                    <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    <span>Berkas Belum Memenuhi Syarat</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="space-y-1">
                            <span class="text-[#66676B] block">Nama Siswa:</span>
                            <strong class="text-[#202124] text-sm">{{ $registration->full_name }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-[#66676B] block">Tahun Ajaran:</span>
                            <strong class="text-[#202124]">{{ $registration->academic_year }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-[#66676B] block">Nama Orang Tua:</span>
                            <strong class="text-[#202124]">{{ $registration->parent_name }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-[#66676B] block">Tanggal Mendaftar:</span>
                            <strong class="text-[#202124]">{{ $registration->created_at?->translatedFormat('d F Y') }}</strong>
                        </div>
                    </div>

                    @if ($registration->verification_notes)
                        <div class="p-4 bg-[#FAF8FC] rounded-2xl border border-[#E7E3EA] text-xs space-y-1">
                            <span class="font-bold text-[#202124]">Catatan Panitia:</span>
                            <p class="text-[#66676B] leading-relaxed">{{ $registration->verification_notes }}</p>
                        </div>
                    @endif

                    <div class="pt-4 border-t border-[#E7E3EA] flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <a href="{{ route('ppdb.success', ['number' => $registration->registration_number]) }}" 
                           class="text-xs font-bold text-[#9377AD] hover:text-[#684681] hover:underline flex items-center justify-center sm:justify-start gap-1 py-1">
                            <span>Lihat Bukti Pendaftaran Lengkap</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ $waUrlPanitia }}" target="_blank" class="text-xs font-bold text-[#2A923F] hover:text-[#217333] hover:underline flex items-center justify-center sm:justify-start gap-1 py-1">
                            <span>Bantuan Panitia via WA</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-red-200 p-6 sm:p-8 text-center space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-full bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-[#202124]">Data Tidak Ditemukan</h3>
                    <p class="text-xs text-[#66676B] max-w-sm mx-auto">
                        Tidak ditemukan pendaftaran dengan nomor/identitas <strong>"{{ $query }}"</strong>. Pastikan data yang dimasukkan sudah benar.
                    </p>
                    <div class="pt-3">
                        <a href="{{ route('ppdb.index') }}" class="inline-flex items-center justify-center w-full sm:w-auto gap-2 px-6 py-2.5 rounded-full bg-[#9377AD] text-white font-bold text-xs hover:bg-[#796092] transition-all shadow-sm">
                            Daftar PPDB Baru
                        </a>
                    </div>
                </div>
            @endif
        @endif

        <div class="text-center pt-2">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#9377AD] hover:text-[#684681] transition-colors">
                <span>&larr;</span>
                <span>Kembali ke Halaman Utama</span>
            </a>
        </div>
    </div>
</section>
@endsection
