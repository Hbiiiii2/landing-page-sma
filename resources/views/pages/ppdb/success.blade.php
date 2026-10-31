@extends('layouts.public')

@section('title', 'Bukti Pendaftaran PPDB — ' . $registration->registration_number)

@push('styles')
<style>
@media print {
    /* Sembunyikan header, navbar, footer, tombol navigasi, dan elemen non-cetak */
    header, 
    footer, 
    nav, 
    #main-header,
    a[href="#main-content"],
    .no-print,
    .print\:hidden,
    #flash-alert,
    #receipt-actions,
    #back-to-home {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Reset background & margin browser untuk print */
    html, body {
        background: #ffffff !important;
        background-color: #ffffff !important;
        color: #111827 !important;
        margin: 0 !important;
        padding: 0 !important;
        min-height: auto !important;
        height: auto !important;
        font-size: 11pt !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    main, #main-content {
        margin: 0 !important;
        padding: 0 !important;
        display: block !important;
    }

    section {
        padding: 0 !important;
        margin: 0 !important;
        background: transparent !important;
    }

    .max-w-\[840px\] {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Format kartu bukti pendaftaran A4 */
    #printable-receipt {
        border: 2px solid #684681 !important;
        border-radius: 8px !important;
        box-shadow: none !important;
        margin: 0 auto !important;
        padding: 20px 26px !important;
        width: 100% !important;
        max-width: 100% !important;
        background: #ffffff !important;
        page-break-inside: avoid;
    }

    /* Header surat pada nota pendaftaran */
    #receipt-header {
        border-bottom: 2px solid #684681 !important;
        padding-bottom: 14px !important;
        margin-bottom: 18px !important;
    }

    /* Warna teks dan badge */
    .print-text-dark {
        color: #111827 !important;
    }

    .print-text-purple {
        color: #684681 !important;
    }

    @page {
        size: A4 portrait;
        margin: 1cm 1.2cm;
    }
}
</style>
@endpush

@section('content')
@php
    $schoolName = $profile->name ?? 'SMA Islam Al-Madinah BSD';
    $whatsapp = $profile->whatsapp ?? '0812-9988-7766';
    $whatsappClean = $profile?->whatsapp_ppdb_clean ?? $profile?->whatsapp_clean;
    if (! $whatsappClean) {
        $whatsappClean = preg_replace('/[^0-9]/', '', $whatsapp);
        if (str_starts_with($whatsappClean, '0')) {
            $whatsappClean = '62' . substr($whatsappClean, 1);
        }
    }

    $rawMessage = "Assalamu'alaikum Panitia PPDB SMA Islam Al-Madinah BSD,\n" .
        "Saya telah menyelesaikan pendaftaran online:\n" .
        "• No. Registrasi: {$registration->registration_number}\n" .
        "• Nama Calon Siswa: {$registration->full_name}\n" .
        "• Asal Sekolah: {$registration->origin_school}\n" .
        "• No. WA Wali: {$registration->parent_phone}\n\n" .
        "Mohon konfirmasi dan informasi jadwal observasi siswa. Terima kasih.";

    $waTargetUrl = $profile?->buildWhatsappUrl($whatsappClean, $rawMessage) 
        ?? ('https://wa.me/' . $whatsappClean . '?text=' . urlencode($rawMessage));
@endphp

<section class="py-12 lg:py-16 bg-[#FAF9FB]">
    <div class="max-w-[840px] mx-auto px-4 lg:px-8 space-y-6">
        
        <!-- Flash Alert (Disembunyikan saat Cetak) -->
        <div id="flash-alert" class="no-print bg-[#EAF6EC] border border-[#CDE8D2] text-[#1E662D] p-5 rounded-2xl flex items-center gap-3.5 shadow-xs">
            <div class="w-10 h-10 rounded-full bg-[#2A923F] text-white flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold">Alhamdulillah, Pendaftaran Berhasil Disimpan!</h3>
                <p class="text-xs text-[#217333] mt-0.5">
                    Data pendaftaran telah tercatat resmi di sistem panitia PPDB SMA Islam Al-Madinah BSD.
                </p>
            </div>
        </div>

        <!-- Printable Registration Card (HANYA INI YANG DICETAK) -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#E7E3EA] p-4 sm:p-8 lg:p-10 shadow-lg space-y-6 sm:space-y-8" id="printable-receipt">
            
            <!-- School Header on Receipt -->
            <div id="receipt-header" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b-2 border-[#9377AD] pb-5 sm:pb-6">
                <div class="flex items-center gap-3 sm:gap-3.5">
                    <img src="{{ asset('images/logo-almadinah.png') }}" 
                         alt="Logo SMA Islam Al-Madinah BSD" 
                         class="w-12 h-12 sm:w-16 sm:h-16 object-contain shrink-0"
                         onerror="this.src='https://lh3.googleusercontent.com/aida-public/AB6AXuAmbTzxzgl6wWksQemxIkN-NrASOhgrQ43jj8Ie82Cr-QQ_hO3Nldfe9ifPaO9jd5ShbMBwhbhUe95-6ZJnxMykUPQy1mucK-BSdzNVvAN-PahWS4DL6O6pZ1FEuzzjZek6KT_3GLxGyKhNz4UZcySi6KGAzmo5b4mcmlisOO0y1YY4VOIMWnxczmaESHA2jdQb68UL-7N8WImgP0evy_Cq86tebAneTuXeWKLRBlUDDyshxu9H6sNI'">
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-[#684681] print-text-purple leading-tight">
                            {{ $schoolName }}
                        </h2>
                        <p class="text-[11px] sm:text-xs text-[#202124] font-semibold">Yayasan Kerukunan Keluarga Muslim BSD (YKKM BSD)</p>
                        <p class="text-[10px] sm:text-[11px] text-[#66676B] print-text-dark">Komplek BSD City Sektor XIV, Serpong, Kota Tangerang Selatan, Banten</p>
                        <p class="text-[9px] sm:text-[10px] text-[#66676B] print-text-dark">Website: smpalmadinah.sch.id • WhatsApp: {{ $whatsapp }}</p>
                    </div>
                </div>

                <div class="text-left sm:text-right border-t sm:border-t-0 pt-3 sm:pt-0 border-[#E7E3EA]">
                    <span class="text-[10px] uppercase font-bold text-[#66676B] tracking-wider block">BUKTI PENDAFTARAN RESMI</span>
                    <div class="text-lg sm:text-2xl font-mono font-black text-[#684681] print-text-purple">
                        {{ $registration->registration_number }}
                    </div>
                    <span class="text-xs text-[#66676B] font-medium">T.A. {{ $registration->academic_year }}</span>
                </div>
            </div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-8 text-xs">
                    <div>
                        <span class="text-[#66676B] block">Nama Calon Siswa:</span>
                        <strong class="text-[#202124] text-sm print-text-dark">{{ $registration->full_name }}</strong>
                    </div>

                    <div>
                        <span class="text-[#66676B] block">Jenis Kelamin:</span>
                        <strong class="text-[#202124] print-text-dark">{{ $registration->gender_label }}</strong>
                    </div>

                    @if ($registration->nik)
                    <div>
                        <span class="text-[#66676B] block">NIK Calon Siswa:</span>
                        <strong class="text-[#202124] font-mono print-text-dark">{{ $registration->nik }}</strong>
                    </div>
                    @endif

                    @if ($registration->nisn)
                    <div>
                        <span class="text-[#66676B] block">NISN Calon Siswa:</span>
                        <strong class="text-[#202124] font-mono print-text-dark">{{ $registration->nisn }}</strong>
                    </div>
                    @endif

                    <div>
                        <span class="text-[#66676B] block">Tempat, Tanggal Lahir:</span>
                        <strong class="text-[#202124] print-text-dark">{{ $registration->birth_place }}, {{ $registration->birth_date?->translatedFormat('d F Y') }}</strong>
                    </div>

                    <div>
                        <span class="text-[#66676B] block">Asal Sekolah:</span>
                        <strong class="text-[#202124] print-text-dark">{{ $registration->origin_school ?? '-' }}</strong>
                    </div>

                    <div>
                        <span class="text-[#66676B] block">Nama Orang Tua / Wali:</span>
                        <strong class="text-[#202124] print-text-dark">{{ $registration->parent_name }}</strong>
                    </div>

                    <div>
                        <span class="text-[#66676B] block">No. WhatsApp Wali:</span>
                        <strong class="text-[#202124] print-text-dark">{{ $registration->parent_phone }}</strong>
                    </div>

                    <div class="sm:col-span-2">
                        <span class="text-[#66676B] block">Alamat Tinggal:</span>
                        <span class="text-[#202124] print-text-dark">{{ $registration->address }}</span>
                    </div>

                    <div>
                        <span class="text-[#66676B] block">Waktu Mendaftar:</span>
                        <span class="text-[#202124] font-mono text-[11px] print-text-dark">{{ $registration->created_at?->format('d/m/Y H:i') }} WIB</span>
                    </div>

                    <div>
                        <span class="text-[#66676B] block">Status Verifikasi:</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                            Menunggu Verifikasi Berkas
                        </span>
                    </div>
                </div>
            </div>

            <!-- Petunjuk Langkah Selanjutnya -->
            <div class="p-4 bg-[#FAF8FC] rounded-2xl text-xs text-[#66676B] space-y-1.5 border border-[#E7E3EA]">
                <div class="font-bold text-[#202124] flex items-center gap-1.5">
                    <span>Petunjuk Pendaftar:</span>
                </div>
                <ol class="list-decimal list-inside space-y-1 pl-1">
                    <li>Simpan atau cetak bukti pendaftaran ini sebagai dokumen sah saat registrasi ulang.</li>
                    <li>Lakukan konfirmasi pendaftaran melalui WhatsApp panitia PPDB.</li>
                    <li>Panitia akan memverifikasi berkas dan menginformasikan jadwal observasi/wawancara santri.</li>
                </ol>
            </div>

            <!-- Kolom Pengesahan Tanda Tangan (Terlihat saat dicetak) -->
            <div class="pt-6 border-t border-[#E7E3EA] grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8 text-xs">
                <div>
                    <p class="text-[#66676B]">Catatan Resmi:</p>
                    <p class="text-[10px] text-[#66676B] mt-1 leading-relaxed">
                        Dokumen ini dicetak secara otomatis melalui portal resmi PPDB Online SMA Islam Al-Madinah BSD (YKKM BSD).
                    </p>
                </div>
                <div class="text-left sm:text-right space-y-8 sm:space-y-12">
                    <div>
                        <p class="text-[#66676B]">Tangerang Selatan, {{ now()->translatedFormat('d F Y') }}</p>
                        <p class="font-bold text-[#202124]">Panitia PPDB Al-Madinah</p>
                    </div>
                    <div>
                        <p class="font-bold text-[#202124] border-t border-gray-400 inline-block pt-1 px-8">( Panitia PPDB YKKM BSD )</p>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi (HANYA MUNCUL DI LAYAR, DISEMBUNYIKAN SAAT CETAK) -->
            <div id="receipt-actions" class="no-print pt-4 border-t border-[#E7E3EA] flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                <button type="button" 
                        onclick="window.print()" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-[#202124] font-bold text-xs uppercase tracking-wide transition-all shadow-xs">
                    <svg class="w-4 h-4 text-[#202124]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak Bukti</span>
                </button>

                <a href="{{ $waTargetUrl }}" 
                   target="_blank" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-[#2A923F] hover:bg-[#217333] text-white font-black text-xs uppercase tracking-wide transition-all shadow-md">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.181-.076.355.101.173.449.742.964 1.201.662.591 1.221.774 1.394.861.173.086.275.072.376-.044.101-.116.433-.506.549-.679.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z" />
                    </svg>
                    <span>Konfirmasi ke WhatsApp Panitia</span>
                </a>
            </div>
        </div>

        <!-- Kembali ke Beranda (Disembunyikan saat Cetak) -->
        <div id="back-to-home" class="no-print text-center pt-2">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#9377AD] hover:text-[#684681] transition-colors">
                <span>&larr;</span>
                <span>Kembali ke Halaman Utama</span>
            </a>
        </div>
    </div>
</section>
@endsection
