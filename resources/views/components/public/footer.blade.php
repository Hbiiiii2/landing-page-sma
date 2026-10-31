@props(['profile' => null])

@php
    $schoolName = $profile->name ?? 'SMA Islam Al-Madinah BSD';
    $address = $profile->address ?? 'Komplek BSD City Sektor XIV, Serpong, Tangerang Selatan, Banten';
    $phone = $profile->phone ?? '(021) 538-8888';
    $email = $profile->email ?? 'info@smpalmadinah.sch.id';
    $whatsapp = !empty($profile?->whatsapp) ? $profile->whatsapp : '0812-9988-7766';
    $instagram = $profile->instagram_url ?? 'https://www.instagram.com/amickkmb.perguruan';
    $youtube = $profile->youtube_url ?? 'https://www.youtube.com/@SMP-SMAAl-MadinahIslamicCenter';
    $facebook = $profile->facebook_url ?? 'https://facebook.com/smpalmadinah';
    $logoSrc = !empty($profile?->logo) ? asset('storage/' . $profile->logo) : asset('images/logo-almadinah.png');
@endphp

<footer class="w-full bg-white border-t-2 border-[#2A923F] print:hidden">
    <!-- Main 3-Column Footer Section (Sesuai Referensi SMAN 2 Kebumen) -->
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-14">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            
            <!-- Column 1: Tentang (Pill Buttons with Open-Source Icons) -->
            <div class="space-y-4">
                <div class="border-b border-[#E7E3EA] pb-2.5">
                    <h3 class="text-base font-black text-[#202124] flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#2A923F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Tentang</span>
                    </h3>
                </div>
                <div class="flex flex-col gap-2.5">
                    <a href="{{ route('about') }}#kepala-sekolah" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2A923F] hover:bg-[#217333] text-white text-xs font-bold transition-all shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Kepala Sekolah</span>
                    </a>
                    <a href="{{ route('about') }}#visi-misi" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2A923F] hover:bg-[#217333] text-white text-xs font-bold transition-all shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Visi dan Misi</span>
                    </a>
                    <a href="{{ route('about') }}#sejarah" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2A923F] hover:bg-[#217333] text-white text-xs font-bold transition-all shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Sejarah Singkat</span>
                    </a>
                    <a href="{{ route('about') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2A923F] hover:bg-[#217333] text-white text-xs font-bold transition-all shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Profil Lengkap Sekolah</span>
                    </a>
                </div>
            </div>

            <!-- Column 2: Website Terkait (Pill Buttons with Open-Source Icons) -->
            <div class="space-y-4">
                <div class="border-b border-[#E7E3EA] pb-2.5">
                    <h3 class="text-base font-black text-[#202124] flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#2A923F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <span>Website Terkait</span>
                    </h3>
                </div>
                <div class="flex flex-col gap-2.5">
                    <a href="{{ route('ppdb.index') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2A923F] hover:bg-[#217333] text-white text-xs font-bold transition-all shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Penerimaan Siswa (PPDB)</span>
                    </a>
                    <a href="{{ route('ppdb.check-status') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2A923F] hover:bg-[#217333] text-white text-xs font-bold transition-all shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cek Status Pendaftaran</span>
                    </a>
                    <a href="{{ route('school.brochure') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2A923F] hover:bg-[#217333] text-white text-xs font-bold transition-all shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh Brosur Sekolah</span>
                    </a>
                    <a href="{{ route('school.fee') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2A923F] hover:bg-[#217333] text-white text-xs font-bold transition-all shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        <span>Rincian Biaya Pendidikan</span>
                    </a>
                </div>
            </div>

            <!-- Column 3: Identitas Sekolah & Sosial Media -->
            <div class="space-y-4 text-left flex flex-col items-start">
                <div class="flex items-center gap-3">
                    <img src="{{ $logoSrc }}" 
                         alt="Logo {{ $schoolName }}" 
                         class="w-14 h-14 object-contain shrink-0"
                         onerror="this.src='{{ asset('images/logo-almadinah.png') }}'">
                    <div>
                        <h4 class="text-base font-black text-[#202124] leading-snug">
                            {{ $schoolName }}
                        </h4>
                        <p class="text-xs text-[#2A923F] font-bold">Islamic Center KKMB BSD</p>
                    </div>
                </div>

                <p class="text-xs text-[#66676B] leading-relaxed">
                    {{ $address }}
                </p>

                <div class="text-xs text-[#66676B] space-y-1">
                    <div>Telepon: <strong class="text-[#202124]">{{ $phone }}</strong></div>
                    <div>WhatsApp: <strong class="text-[#202124]">{{ $whatsapp }}</strong></div>
                    <div>Email: <strong class="text-[#202124]">{{ $email }}</strong></div>
                </div>

                <!-- Social Icons -->
                <div class="flex items-center gap-2 pt-2">
                    <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-lg border border-[#E7E3EA] bg-slate-50 hover:bg-[#2A923F] hover:text-white hover:border-[#2A923F] text-[#202124] flex items-center justify-center transition-all shadow-xs" title="Facebook">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.597 0 9 1.583 9 4.615V8z" />
                        </svg>
                    </a>
                    <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-lg border border-[#E7E3EA] bg-slate-50 hover:bg-[#2A923F] hover:text-white hover:border-[#2A923F] text-[#202124] flex items-center justify-center transition-all shadow-xs" title="Instagram">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="{{ $youtube }}" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-lg border border-[#E7E3EA] bg-slate-50 hover:bg-[#2A923F] hover:text-white hover:border-[#2A923F] text-[#202124] flex items-center justify-center transition-all shadow-xs" title="YouTube">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Copyright Strip (Solid Green) -->
    <div class="bg-[#2A923F] text-white py-3.5 px-4 text-center text-xs border-t border-[#217333]">
        <div class="max-w-[1240px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-2.5">
            <div>
                &copy; {{ date('Y') }} <strong>SMA Islam Al-Madinah BSD</strong>. Hak Cipta Dilindungi Undang-Undang.
            </div>
            <div class="text-[11px] opacity-90 flex flex-wrap items-center justify-center sm:justify-end gap-x-2 gap-y-1">
                <span>Pendidikan Menengah Atas Islami, Berkarakter & Unggul</span>
                <span class="opacity-60 hidden sm:inline">•</span>
                <span>Powered by <a href="https://aybisa-workspace.my.id" target="_blank" rel="noopener noreferrer" class="font-bold text-white hover:underline underline-offset-2 transition-all">Aybisa Studio</a></span>
            </div>
        </div>
    </div>
</footer>
