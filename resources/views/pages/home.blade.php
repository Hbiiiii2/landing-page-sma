@extends('layouts.public')

@section('title', 'SMA Islam Al-Madinah BSD — Mendidik Generasi Pemimpin Beradab & Berprestasi Global')
@section('meta_description', 'Portal Resmi SMA Islam Al-Madinah BSD di Sektor XIV BSD City, Serpong, Tangerang Selatan. Memadukan kurikulum nasional merdeka, bimbingan intensif PTN & kedinasan, riset sains & AI, tahfidz Al-Qur\'an bersanad, dan kepemimpinan berakhlak mulia.')
@section('canonical', url('/'))

@section('content')
@php
    $schoolName = $profile->name ?? 'SMA Islam Al-Madinah BSD';
    $foundation = 'Islamic Center KKMB • Sektor XIV BSD';
    $academicYear = $ppdbSetting->academic_year ?? '2027/2028';

    // WhatsApp Configuration & URLs
    $whatsapp = !empty($profile?->whatsapp) ? $profile->whatsapp : '0812-9988-7766';
    $whatsappClean = $profile?->whatsapp_ppdb_clean ?? '6281299887766';
    $waUrlPanitia = $profile?->whatsapp_panitia_url ?? ('https://wa.me/' . $whatsappClean);
    $waUrlBrosur = $profile?->whatsapp_brosur_url ?? $waUrlPanitia;
    $waUrlBiaya = $profile?->whatsapp_biaya_url ?? $waUrlPanitia;
    $waUrlFloating = $profile?->whatsapp_floating_url ?? $waUrlPanitia;

    // Hero Assets
    $heroImageFallback = asset('images/banner-almadinah.png');
    $heroImageSrc = !empty($profile?->hero_image) ? asset('storage/' . $profile->hero_image) : $heroImageFallback;
    $logoSrc = !empty($profile?->logo) ? asset('storage/' . $profile->logo) : asset('images/logo-almadinah.png');

    // Document & Download URLs
    $hasBrochure = !empty($profile?->brochure_file);
    $brochureUrl = $profile?->brochure_file_url ?? route('school.brochure');
    $isBrochurePdf = $profile?->isBrochurePdf() ?? false;

    $hasPpdbFee = !empty($profile?->ppdb_fee_file);
    $ppdbFeeUrl = $profile?->ppdb_fee_file_url ?? route('school.fee');
    $isPpdbFeePdf = $profile?->isPpdbFeePdf() ?? false;

    // QR Code
    $ppdbRegistrationUrl = route('ppdb.index');
    $ppdbQrCodeSrc = $profile?->ppdb_qr_code_src ?? ('https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($ppdbRegistrationUrl));

    // YouTube & Instagram Media
    $ytEmbedUrl = $profile?->youtube_embed_url;
    $hasRawIframe = !empty($profile?->youtube_embed) && str_contains($profile->youtube_embed, '<iframe');
    $igHtml = $profile?->getInstagramEmbedHtml();

    // Posts distribution
    $featuredPost = $posts->first();
    $recentNews = $posts->skip(1)->take(4);
    if ($recentNews->isEmpty() && $posts->count() > 0) {
        $recentNews = $posts->take(4);
    }
    $gridPosts = $posts->slice(0, 3);
@endphp

<!-- ========================================================
     01. HERO SECTION (MODERN PRESTIGIOUS HIGH-SCHOOL DESIGN)
     Deep Navy & Emerald Aesthetic — Clean, Mature, Elevated
     ======================================================== -->
<section class="relative bg-[#0B132B] text-white pt-10 pb-20 lg:pt-16 lg:pb-28 overflow-hidden">
    <!-- Subtle Modern Glows & Grid Pattern -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-32 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[700px] h-48 bg-emerald-600/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    </div>

    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Top Announcement Ticker / Live Status -->
        <div class="flex justify-center mb-6 sm:mb-8 px-2 sm:px-0">
            @php
                $hasAnnouncements = $announcements->isNotEmpty();
                $topAnnouncement = $hasAnnouncements ? $announcements->first() : null;
                $bannerTag = $hasAnnouncements ? 'INFO RESMI' : 'PPDB ' . $academicYear;
                $bannerUrl = $topAnnouncement?->url ?? '#ppdb-jalur';
                
                if ($hasAnnouncements) {
                    $tickerTitles = $announcements->pluck('title')->all();
                    $tickerText = implode('   •   ', $tickerTitles);
                } else {
                    $tickerText = 'Pendaftaran PPDB Online Tahun Ajaran ' . $academicYear . ' Resmi Dibuka!';
                }
                $desktopTitle = $topAnnouncement ? $topAnnouncement->title : ('Pendaftaran PPDB Online Tahun Ajaran ' . $academicYear . ' Resmi Dibuka!');
            @endphp

            <a href="{{ $bannerUrl }}" 
               class="inline-flex items-center gap-2.5 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/20 text-xs text-white transition-all shadow-lg group w-full max-w-[calc(100vw-2.5rem)] sm:w-auto sm:max-w-xl overflow-hidden relative cursor-pointer"
               title="{{ $desktopTitle }}">
                
                <!-- Fixed Badge on Left -->
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-500 text-slate-950 shrink-0 z-10 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-950 animate-ping"></span>
                    {{ $bannerTag }}
                </span>

                <!-- Mobile View: Smooth Infinite Running Text Marquee (< sm) -->
                <div class="sm:hidden flex-1 overflow-hidden relative whitespace-nowrap min-w-0 [mask-image:linear-gradient(to_right,transparent,black_8px,black_calc(100%-8px),transparent)] [-webkit-mask-image:linear-gradient(to_right,transparent,black_8px,black_calc(100%-8px),transparent)]">
                    <div class="animate-ticker-mobile flex items-center">
                        <span class="font-medium text-emerald-100 flex items-center gap-6 pr-6">
                            <span>{{ $tickerText }}</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400/70 inline-block"></span>
                        </span>
                        <span class="font-medium text-emerald-100 flex items-center gap-6 pr-6" aria-hidden="true">
                            <span>{{ $tickerText }}</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400/70 inline-block"></span>
                        </span>
                    </div>
                </div>

                <!-- Desktop View: Crisp Static Text with Arrow (sm+) -->
                <div class="hidden sm:flex items-center gap-2 min-w-0">
                    <span class="truncate font-medium text-emerald-100">{{ $desktopTitle }}</span>
                    <svg class="w-3.5 h-3.5 text-emerald-400 group-hover:translate-x-0.5 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- Left Column: High School Value Proposition & Action -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left reveal-init">
                
                <!-- Badge & Foundation -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2.5">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Terakreditasi A Unggul
                    </span>
                    <span class="text-xs font-semibold text-slate-300">
                        {{ $foundation }}
                    </span>
                </div>

                <!-- Main Bold Headline -->
                <div class="space-y-3">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-[1.18] tracking-tight">
                        Mendidik Generasi Pemimpin <br class="hidden sm:inline">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-300">
                            Beradab & Berprestasi Global
                        </span>
                    </h1>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-normal">
                        Mempersiapkan santri melangkah pasti menembus Perguruan Tinggi Negeri (PTN) favorit, kedinasan, dan universitas kelas dunia melalui kurikulum terintegrasi, riset sains & AI, tahfidz bersanad, dan kepemimpinan berkarakter Islami.
                    </p>
                </div>

                <!-- 4 Action CTAs Bar -->
                <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                    <!-- Button 1: DAFTAR ONLINE -->
                    <a href="{{ route('ppdb.index') }}" 
                       class="inline-flex items-center gap-2 px-5 sm:px-6 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs sm:text-sm uppercase tracking-wider transition-all duration-300 shadow-xl shadow-emerald-500/25 hover:shadow-emerald-400/35 hover:-translate-y-0.5 shrink-0">
                        <span>DAFTAR ONLINE</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>

                    <!-- Button 2: UNDUH BROSUR (Modal Trigger) -->
                    <button type="button" 
                            onclick="openBrosurPpdbModal()"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs sm:text-sm uppercase tracking-wider transition-all duration-300 shadow-md backdrop-blur-md cursor-pointer shrink-0">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>UNDUH BROSUR</span>
                    </button>

                    <!-- Button 3: BIAYA PPDB (Modal Trigger) -->
                    <button type="button" 
                            onclick="openBiayaPpdbModal()"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs sm:text-sm uppercase tracking-wider transition-all duration-300 shadow-md backdrop-blur-md cursor-pointer shrink-0">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>BIAYA PPDB</span>
                    </button>

                    <!-- Button 4: CHAT WA PANITIA -->
                    <a href="{{ $waUrlPanitia }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-[#25D366]/20 hover:bg-[#25D366]/30 border border-[#25D366]/40 text-[#25D366] font-bold text-xs sm:text-sm uppercase tracking-wider transition-all duration-300 shadow-md backdrop-blur-md shrink-0">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>CHAT WA PANITIA</span>
                    </a>

                    <!-- Video Profil Anchor Trigger -->
                    <a href="#video-profil" 
                       class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl text-slate-300 hover:text-white font-semibold text-xs sm:text-sm transition-colors group">
                        <span class="w-7 h-7 rounded-full bg-red-600/30 border border-red-500/40 text-red-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-3.5 h-3.5 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </span>
                        <span>Video Profil</span>
                    </a>

                    <!-- Scan QR Trigger Button -->
                    <button type="button" 
                            onclick="openPpdbQrModal()"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs text-slate-300 hover:text-white hover:bg-white/5 transition-all cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        <span>Scan QR</span>
                    </button>
                </div>

                <!-- Academic Pillar Tags (Clean Design without Emojis) -->
                <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-2 text-[11px] font-semibold text-slate-300">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white/5 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span>Sukses Jalur PTN & Kedinasan</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white/5 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                        <span>Laboratorium Riset & AI</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white/5 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>Tahfidz Al-Qur'an 3-5 Juz</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white/5 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        <span>Dwibahasa (Arab - Inggris)</span>
                    </span>
                </div>

            </div>

            <!-- Right Column: Visual Showcase with Layered Floating Badges (Clean SVG Icons) -->
            <div class="lg:col-span-5 reveal-init reveal-right delay-150">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    
                    <!-- Main School Banner Frame -->
                    <div class="relative rounded-3xl overflow-hidden border-2 border-white/20 shadow-2xl bg-slate-900 aspect-[4/3] group">
                        <img src="{{ $heroImageSrc }}" 
                             alt="Gedung Sekolah {{ $schoolName }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                             onerror="this.src='{{ asset('images/banner-almadinah.png') }}'">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                        
                        <div class="absolute bottom-4 left-4 right-4 text-left">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-300">Kawasan Sekolah Terpadu</span>
                            </div>
                            <h2 class="text-base sm:text-lg font-black text-white">
                                {{ $schoolName }}
                            </h2>
                            <p class="text-[11px] text-slate-300">Komplek BSD City Sektor XIV, Serpong</p>
                        </div>
                    </div>

                    <!-- Floating Badge 1: PTN Success Target (Top-Right) -->
                    <div class="absolute -top-5 -right-4 sm:-right-6 bg-slate-900/90 backdrop-blur-md border border-white/20 rounded-2xl p-3 sm:p-3.5 shadow-xl flex items-center gap-3 max-w-[210px] hidden sm:flex">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center font-black shadow-sm shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-black text-white">Target 100%</div>
                            <div class="text-[10px] text-slate-300 leading-tight">Lulusan Tembus PTN & Kedinasan</div>
                        </div>
                    </div>

                    <!-- Floating Badge 2: Tahfidz Bersanad (Bottom-Left) -->
                    <div class="absolute -bottom-5 -left-4 sm:-left-6 bg-slate-900/90 backdrop-blur-md border border-white/20 rounded-2xl p-3 sm:p-3.5 shadow-xl flex items-center gap-3 max-w-[200px] hidden sm:flex">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 text-slate-950 flex items-center justify-center font-black shadow-sm shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-black text-white">Tahfidz Mutqin</div>
                            <div class="text-[10px] text-slate-300 leading-tight">Target 3-5 Juz & Sanad</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Metric Counters Ribbon Bar -->
        <div class="mt-12 sm:mt-16 grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 max-w-5xl mx-auto">
            <div class="p-4 sm:p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md text-center hover:bg-white/10 transition-colors">
                <div class="text-2xl sm:text-3xl font-black text-emerald-400">Akreditasi A</div>
                <div class="text-xs font-semibold text-slate-200 mt-1">Standar Unggul BAN-SM</div>
                <div class="text-[10px] text-slate-400 mt-0.5">NPSN: 20613809</div>
            </div>

            <div class="p-4 sm:p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md text-center hover:bg-white/10 transition-colors">
                <div class="text-2xl sm:text-3xl font-black text-amber-400">
                    {{ $profile->statistic_achievements ?? ($achievements->count() > 0 ? $achievements->count() . '+' : '45+') }}
                </div>
                <div class="text-xs font-semibold text-slate-200 mt-1">Kejuaraan & Prestasi</div>
                <div class="text-[10px] text-slate-400 mt-0.5">Nasional, Provinsi & Daerah</div>
            </div>

            <div class="p-4 sm:p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md text-center hover:bg-white/10 transition-colors">
                <div class="text-2xl sm:text-3xl font-black text-teal-400">24 Siswa</div>
                <div class="text-xs font-semibold text-slate-200 mt-1">Maksimal per Kelas</div>
                <div class="text-[10px] text-slate-400 mt-0.5">Pembelajaran Personal</div>
            </div>

            <div class="p-4 sm:p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md text-center hover:bg-white/10 transition-colors">
                <div class="text-2xl sm:text-3xl font-black text-white">3-5 Juz</div>
                <div class="text-xs font-semibold text-slate-200 mt-1">Target Tahfidz Al-Qur'an</div>
                <div class="text-[10px] text-slate-400 mt-0.5">Talaqqi & Tasmi' Mutqin</div>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================
     MODAL POPUP 1: SCAN QR CODE DAFTAR CEPAT PPDB ONLINE
     ======================================================== -->
<div id="ppdb-qr-modal" 
     class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm transition-opacity duration-300"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="qr-modal-title">
    
    <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-emerald-100 overflow-hidden transform transition-all duration-300 scale-95 opacity-0"
         id="ppdb-qr-modal-box">
        
        <div class="bg-gradient-to-r from-[#08493B] via-[#0D6B57] to-[#117C65] text-white p-5 sm:p-6 text-center relative">
            <button type="button" 
                    onclick="closePpdbQrModal()" 
                    class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 active:bg-white/30 text-white flex items-center justify-center transition-all cursor-pointer focus:outline-none"
                    aria-label="Tutup modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 border border-white/20 text-[11px] font-semibold text-emerald-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                <span>PPDB Online {{ $academicYear }}</span>
            </div>
            <h3 id="qr-modal-title" class="text-lg sm:text-xl font-extrabold text-white tracking-tight">
                Scan untuk Daftar Cepat
            </h3>
            <p class="text-xs text-emerald-100/90 mt-1 max-w-xs mx-auto">
                {{ $schoolName }}
            </p>
        </div>

        <div class="p-6 sm:p-7 space-y-5 text-center">
            <div class="inline-block relative p-3 sm:p-4 bg-white rounded-2xl border-2 border-emerald-100 shadow-md">
                <div class="w-48 h-48 sm:w-56 sm:h-56 mx-auto flex items-center justify-center overflow-hidden bg-white">
                    <img id="ppdb-qr-modal-image" 
                         src="{{ $ppdbQrCodeSrc }}" 
                         alt="QR Code PPDB {{ $schoolName }}" 
                         class="w-full h-full object-contain">
                </div>
                <div class="mt-2 text-[11px] font-bold text-[#0D6B57] flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    <span>Arahkan Kamera HP / Google Lens ke Sini</span>
                </div>
            </div>

            <p class="text-xs text-slate-600 leading-relaxed max-w-sm mx-auto">
                Buka kamera smartphone Anda lalu arahkan ke kode QR di atas untuk langsung membuka formulir pendaftaran PPDB SMA Islam Al-Madinah.
            </p>

            <div class="bg-slate-50 border border-slate-200 rounded-xl p-2.5 flex items-center justify-between gap-2 text-left">
                <div class="truncate text-xs text-slate-600 font-mono pl-1 select-all">
                    {{ $ppdbRegistrationUrl }}
                </div>
                <button type="button" 
                        onclick="copyPpdbUrl('{{ $ppdbRegistrationUrl }}')" 
                        id="btn-copy-ppdb-url"
                        class="shrink-0 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs flex items-center gap-1.5 transition-all cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span id="copy-text-label">Salin Link</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================
     MODAL POPUP 2: UNDUH BROSUR RESMI PPDB ONLINE
     ======================================================== -->
<div id="ppdb-brosur-modal" 
     class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm transition-opacity duration-300"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="brosur-modal-title">
    
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-emerald-100 overflow-hidden transform transition-all duration-300 scale-95 opacity-0 max-h-[90vh] flex flex-col"
         id="ppdb-brosur-modal-box">
        
        <div class="bg-gradient-to-r from-[#08493B] via-[#0D6B57] to-[#117C65] text-white p-5 sm:p-6 text-center relative shrink-0">
            <button type="button" 
                    onclick="closeBrosurPpdbModal()" 
                    class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 active:bg-white/30 text-white flex items-center justify-center transition-all cursor-pointer focus:outline-none"
                    aria-label="Tutup modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 border border-white/20 text-[11px] font-semibold text-emerald-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                <span>Brosur Informasi PPDB {{ $academicYear }}</span>
            </div>
            <h3 id="brosur-modal-title" class="text-lg sm:text-xl font-extrabold text-white tracking-tight">
                Unduh Brosur Resmi
            </h3>
            <p class="text-xs text-emerald-100/90 mt-1 max-w-xs mx-auto">
                {{ $schoolName }}
            </p>
        </div>

        <div class="p-6 sm:p-7 space-y-5 text-center overflow-y-auto flex-1">
            @if ($hasBrochure)
                @if (!$isBrochurePdf)
                    <div class="max-h-64 sm:max-h-72 overflow-hidden rounded-2xl border-2 border-emerald-100 bg-slate-50 shadow-inner group relative">
                        <img src="{{ $brochureUrl }}" 
                             alt="Brosur {{ $schoolName }}" 
                             class="w-full h-full object-contain">
                    </div>
                @else
                    <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200 text-left flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="space-y-1">
                            <div class="text-xs font-extrabold text-[#0D6B57]">Dokumen Brosur Resmi (PDF)</div>
                            <div class="text-[11px] text-slate-600 leading-relaxed">
                                Memuat kurikulum lengkap, profil lulusan, program unggulan, tahfidz Al-Qur'an, dan fasilitas sekolah.
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                    <a href="{{ $brochureUrl }}" download 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh File Brosur</span>
                    </a>
                    <a href="{{ $waUrlBrosur }}" target="_blank" rel="noopener noreferrer"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-all">
                        <span>Minta via WhatsApp</span>
                    </a>
                </div>
            @else
                <div class="p-6 rounded-2xl bg-amber-50/80 border border-amber-200 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="space-y-1">
                        <div class="text-xs font-bold text-amber-900">Brosur Digital Sedang Diperbarui</div>
                        <div class="text-[11px] text-amber-800/80 max-w-sm mx-auto leading-relaxed">
                            Brosur resmi PPDB {{ $academicYear }} dapat diminta langsung ke panitia melalui layanan WhatsApp humas sekolah.
                        </div>
                    </div>
                    <a href="{{ $waUrlBrosur }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#25D366] hover:bg-[#20ba59] text-white font-bold text-xs shadow-md transition-all">
                        <span>Hubungi Panitia via WhatsApp</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ========================================================
     MODAL POPUP 3: RINCIAN BIAYA PPDB ONLINE
     ======================================================== -->
<div id="ppdb-biaya-modal" 
     class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm transition-opacity duration-300"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="biaya-modal-title">
    
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-emerald-100 overflow-hidden transform transition-all duration-300 scale-95 opacity-0 max-h-[90vh] flex flex-col"
         id="ppdb-biaya-modal-box">
        
        <div class="bg-gradient-to-r from-[#08493B] via-[#0D6B57] to-[#117C65] text-white p-5 sm:p-6 text-center relative shrink-0">
            <button type="button" 
                    onclick="closeBiayaPpdbModal()" 
                    class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 active:bg-white/30 text-white flex items-center justify-center transition-all cursor-pointer focus:outline-none"
                    aria-label="Tutup modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 border border-white/20 text-[11px] font-semibold text-emerald-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                <span>Transparansi Pembiayaan</span>
            </div>
            <h3 id="biaya-modal-title" class="text-lg sm:text-xl font-extrabold text-white tracking-tight">
                Rincian Biaya PPDB {{ $academicYear }}
            </h3>
            <p class="text-xs text-emerald-100/90 mt-1 max-w-xs mx-auto">
                {{ $schoolName }}
            </p>
        </div>

        <div class="p-6 sm:p-7 space-y-5 text-center overflow-y-auto flex-1">
            @if ($hasPpdbFee)
                @if (!$isPpdbFeePdf)
                    <div class="max-h-64 sm:max-h-72 overflow-hidden rounded-2xl border-2 border-emerald-100 bg-slate-50 shadow-inner group relative">
                        <img src="{{ $ppdbFeeUrl }}" 
                             alt="Tabel Biaya {{ $schoolName }}" 
                             class="w-full h-full object-contain">
                    </div>
                @else
                    <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200 text-left flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <div class="space-y-1">
                            <div class="text-xs font-extrabold text-[#0D6B57]">Dokumen Rincian Biaya Resmi (PDF)</div>
                            <div class="text-[11px] text-slate-600 leading-relaxed">
                                Rincian lengkap biaya pendaftaran, uang pangkal / pengembangan sarana, SPP bulanan, biaya seragam, dan buku paket.
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                    <a href="{{ $ppdbFeeUrl }}" download 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh Rincian Biaya</span>
                    </a>
                    <a href="{{ $waUrlBiaya }}" target="_blank" rel="noopener noreferrer"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-all">
                        <span>Konsultasi Biaya via WA</span>
                    </a>
                </div>
            @else
                <div class="p-6 rounded-2xl bg-amber-50/80 border border-amber-200 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div class="space-y-1">
                        <div class="text-xs font-bold text-amber-900">Konsultasi Rincian Biaya Pendidikan</div>
                        <div class="text-[11px] text-amber-800/80 max-w-sm mx-auto leading-relaxed">
                            Informasi detail rincian biaya pendaftaran, SPP, dan skema beasiswa prestasi dapat dikonsultasikan langsung bersama bendahara PPDB.
                        </div>
                    </div>
                    <a href="{{ $waUrlBiaya }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#25D366] hover:bg-[#20ba59] text-white font-bold text-xs shadow-md transition-all">
                        <span>Tanya Biaya via WhatsApp</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ========================================================
     02. PILAR KEUNGGULAN SMA (ACADEMIC EXCELLENCE PILLARS)
     ======================================================== -->
<section id="keunggulan" class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="text-center space-y-3 max-w-2xl mx-auto reveal-init">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                Pilar Mutu Pendidikan SMA
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Empat Fondasi Keunggulan Menuju Masa Depan
            </h2>
            <div class="w-16 h-1 bg-emerald-600 rounded-full mx-auto"></div>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                Kurikulum SMA Islam Al-Madinah dirancang terintegrasi guna memastikan keseimbangan optimal antara prestasi akademik tingkat tinggi, kedalaman spiritual, dan keterampilan abad ke-21.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Pillar 1: Bimbingan PTN & Kedinasan -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 group">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
                <div class="space-y-2">
                    <h3 class="text-base font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                        Bimbingan Sukses PTN & Karir
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Program intensif persiapan SNBP, SNBT/UTBK, dan seleksi Perguruan Tinggi Kedinasan sejak kelas X dengan tryout berkala dan konseling minat bakat.
                    </p>
                </div>
                <ul class="text-[11px] text-slate-600 space-y-1.5 pt-1 border-t border-slate-100">
                    <li class="flex items-center gap-2 text-emerald-800 font-semibold">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Kelas Sukses UTBK & TPS</span>
                    </li>
                    <li class="flex items-center gap-2 text-emerald-800 font-semibold">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Portofolio Akademik & Minat</span>
                    </li>
                </ul>
            </div>

            <!-- Pillar 2: Riset Sains & AI Technology -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 group">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <div class="space-y-2">
                    <h3 class="text-base font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                        Riset Sains & AI Terapan
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Inkubator Karya Ilmiah Remaja (KIR), praktikum sains lanjutan di laboratorium representatif, coding, serta pengenalan Artificial Intelligence.
                    </p>
                </div>
                <ul class="text-[11px] text-slate-600 space-y-1.5 pt-1 border-t border-slate-100">
                    <li class="flex items-center gap-2 text-emerald-800 font-semibold">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Laboratorium Sains Modern</span>
                    </li>
                    <li class="flex items-center gap-2 text-emerald-800 font-semibold">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Coding & Robotika AI</span>
                    </li>
                </ul>
            </div>

            <!-- Pillar 3: Tahfidz Bersanad & Adab Islami -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 group">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="space-y-2">
                    <h3 class="text-base font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                        Tahfidz Al-Qur'an Bersanad
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Metode tahfidz mutqin berjenjang 3 hingga 5 juz, bimbingan talaqqi dari para asatidz muqri bersanad, serta ujian tasmi' akbar tahunan.
                    </p>
                </div>
                <ul class="text-[11px] text-slate-600 space-y-1.5 pt-1 border-t border-slate-100">
                    <li class="flex items-center gap-2 text-emerald-800 font-semibold">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Halaqah Talaqqi Bersanad</span>
                    </li>
                    <li class="flex items-center gap-2 text-emerald-800 font-semibold">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Pembiasaan Adab Salafush Shalih</span>
                    </li>
                </ul>
            </div>

            <!-- Pillar 4: Bilingual & Kepemimpinan Global -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 group">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="space-y-2">
                    <h3 class="text-base font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                        Bilingual & Leadership
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Kecakapan berkomunikasi aktif dwibahasa (Arab & Inggris), public speaking, kepemimpinan OSIS, dan partisipasi forum kepemudaan nasional.
                    </p>
                </div>
                <ul class="text-[11px] text-slate-600 space-y-1.5 pt-1 border-t border-slate-100">
                    <li class="flex items-center gap-2 text-emerald-800 font-semibold">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>English & Arabic Active Day</span>
                    </li>
                    <li class="flex items-center gap-2 text-emerald-800 font-semibold">
                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Forum Diplomasi & OSIS</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================
     03. MENGAPA MEMILIH KAMI & AKREDITASI (DYNAMIC PHOTOS & BADGES)
     Supports why_choose_us_image, why_choose_us_badge_title, etc.
     ======================================================== -->
<section class="py-16 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- Left: Text & Features List -->
            <div class="lg:col-span-7 space-y-6 text-left reveal-init">
                <div class="space-y-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                        Standar Keunggulan SMA
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                        Mengapa Memilih SMA Islam Al-Madinah BSD?
                    </h2>
                    <div class="w-16 h-1 bg-emerald-600 rounded-full"></div>
                </div>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Kami hadir sebagai mitra terbaik orang tua dalam membimbing generasi muda melewati masa transisi krusial menuju kematangan intelektual, emosional, dan spiritual.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                        <div class="flex items-center gap-2.5 font-bold text-xs text-slate-900">
                            <div class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span>Kurikulum Merdeka Plus</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed pl-7">Terintegrasi bimbingan intensif persiapan seleksi perguruan tinggi negeri favorit.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                        <div class="flex items-center gap-2.5 font-bold text-xs text-slate-900">
                            <div class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span>Halaqah Tahfidz Bersanad</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed pl-7">Metode mutqin berjenjang dengan pembinaan talaqqi muqri bersanad resmi.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                        <div class="flex items-center gap-2.5 font-bold text-xs text-slate-900">
                            <div class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span>Laboratorium Riset & AI</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed pl-7">Inkubator Karya Ilmiah Remaja (KIR), coding, dan robotika aplikatif.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                        <div class="flex items-center gap-2.5 font-bold text-xs text-slate-900">
                            <div class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span>Rasio Maksimal 24 Santri</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed pl-7">Setiap santri didampingi secara personal untuk memaksimalkan potensi uniknya.</p>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('about') }}" 
                       class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-600 hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-xs">
                        <span>Pelajari Selengkapnya</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- Right: Student Portrait & Dynamic Accreditation Badge -->
            <div class="lg:col-span-5 flex justify-center reveal-init reveal-right delay-150">
                <div class="relative w-full max-w-sm">
                    @php
                        $whyImg = $profile?->why_choose_us_image_src ?? 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=700&q=80';
                        $badgeTitle = $profile?->why_choose_us_badge_title ?: 'Akreditasi ' . ($profile?->accreditation ?? 'A') . ' Unggul';
                        $badgeSubtitle = $profile?->why_choose_us_badge_subtitle ?: 'BAN-S/M Kemendikbud';
                    @endphp
                    <div class="rounded-3xl overflow-hidden border-4 border-white shadow-2xl bg-slate-100 aspect-[4/5] relative">
                        <img src="{{ $whyImg }}" 
                             alt="Santri Berprestasi {{ $schoolName }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                    </div>

                    <!-- Floating Accreditation Badge Card -->
                    <div class="absolute -bottom-5 right-4 bg-white p-3.5 sm:p-4 rounded-2xl shadow-xl border border-slate-200 flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-lg shadow-sm">
                            {{ substr($profile?->accreditation ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <div class="text-xs font-black text-slate-900">{{ $badgeTitle }}</div>
                            <div class="text-[10px] text-slate-500">{{ $badgeSubtitle }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     04. SAMBUTAN KEPALA SEKOLAH & PROFIL INSTITUSI
     Executive Card with Headmaster Profile
     ======================================================== -->
<section id="sambutan" class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-[#0F1E36] rounded-3xl p-6 sm:p-10 lg:p-12 text-white shadow-2xl relative overflow-hidden">
            
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center relative z-10">
                
                <!-- Left: Headmaster Photo Card -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="w-full max-w-sm rounded-2xl bg-white/10 p-3.5 backdrop-blur-md border border-white/20 shadow-xl space-y-3 text-center">
                        <div class="relative h-64 sm:h-72 rounded-xl overflow-hidden bg-slate-800 border border-white/10">
                            @php
                                $headmasterPhoto = !empty($profile?->headmaster_photo) 
                                    ? asset('storage/' . $profile->headmaster_photo) 
                                    : 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=600&q=80';
                            @endphp
                            <img src="{{ $headmasterPhoto }}" 
                                 alt="Kepala Sekolah {{ $schoolName }}" 
                                 class="w-full h-full object-cover object-top">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 left-3 right-3 text-left">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-emerald-500 text-slate-950">
                                    Kepala Sekolah
                                </span>
                                <h4 class="text-sm sm:text-base font-black text-white mt-1">
                                    {{ $profile->headmaster_name ?? 'Drs. H. M. Syarifuddin, M.Pd.' }}
                                </h4>
                                <p class="text-[11px] text-emerald-200">{{ $schoolName }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs text-slate-300 px-2 pt-1">
                            <span>Status: <strong>Swasta Terakreditasi A</strong></span>
                            <span class="text-emerald-400 font-bold">YKKM BSD</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Welcome Speech & Vision Statement -->
                <div class="lg:col-span-7 space-y-4 text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        Sambutan Kepala Sekolah
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-white leading-tight">
                        "Membentuk Generasi Berintelektual Tinggi yang Berpijak Teguh pada Adab Islam"
                    </h2>

                    <div class="space-y-3 text-xs sm:text-sm text-slate-300 leading-relaxed">
                        <p>
                            {{ $profile->headmaster_welcome ?? 'Assalamu’alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi SMA Islam Al-Madinah BSD. Jenjang Sekolah Menengah Atas adalah fase emas dalam membentuk arah masa depan generasi muda. Di sini, kami berkomitmen tidak sekadar mengantarkan santri menembus perguruan tinggi terbaik, melainkan juga menanamkan adab, integritas moral, dan kecintaan pada Al-Qur\'an.' }}
                        </p>
                        <p class="hidden sm:block">
                            Dengan bimbingan para pendidik profesional dan lingkungan Islami yang kondusif di BSD City, kami membekali setiap santri dengan pemikiran kritis, riset sains, kemahiran dwibahasa, serta kemandirian mental untuk menjawab tantangan global.
                        </p>
                    </div>

                    <div class="pt-3 flex flex-wrap items-center gap-3">
                        <a href="{{ route('about') }}" 
                           class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition-all shadow-md">
                            <span>Profil Lengkap & Visi Misi</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="#kontak" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs uppercase tracking-wider transition-all">
                            <span>Jadwalkan Kunjungan Sekolah</span>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     05. PROGRAM JURUSAN & PEMINATAN SMA (DINAMIS DARI DATABASE)
     ======================================================== -->
<section id="program" class="py-16 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="text-center space-y-3 max-w-2xl mx-auto reveal-init">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                Peminatan Akademik
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Program Jurusan & Jalur Peminatan SMA
            </h2>
            <div class="w-16 h-1 bg-emerald-600 rounded-full mx-auto"></div>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                Pilihan peminatan terpadu kurikulum merdeka yang dirancang untuk mendukung persiapan studi lanjut ke jenjang perguruan tinggi impian.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($programs as $progIndex => $prog)
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group overflow-hidden">
                    <div class="space-y-4">
                        @if ($prog->image_url)
                            <div class="h-36 -mx-6 -mt-6 mb-4 overflow-hidden bg-slate-100">
                                <img src="{{ $prog->image_url }}" alt="{{ $prog->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            </div>
                        @else
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-lg group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                        @endif
                        <div class="space-y-1.5">
                            <span class="text-[10px] uppercase font-bold text-emerald-700 tracking-wider">Jalur Peminatan SMA</span>
                            <h3 class="text-base font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                                {{ $prog->name }}
                            </h3>
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                {{ $prog->summary ?? Str::limit(strip_tags($prog->description ?? ''), 120) }}
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-200 mt-4">
                        <a href="{{ route('programs') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                            <span>Pelajari Kurikulum</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h3 class="text-base font-black text-slate-900">MIPA & Riset Sains</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Persiapan Jurusan Kedokteran, Teknik, Farmasi, dan Sains Terapan.</p>
                </div>
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-800 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-base font-black text-slate-900">IPS & Global Studies</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Persiapan Jurusan Ekonomi, Hukum, Hubungan Internasional, dan Psikologi.</p>
                </div>
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-base font-black text-slate-900">Tahfidz & Dirasah Islamiyah</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Studi Lanjutan Universitas Timur Tengah (Al-Azhar, Madinah) & Syariah.</p>
                </div>
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-800 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </div>
                    <h3 class="text-base font-black text-slate-900">Bilingual & International Class</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Pembelajaran dwibahasa dan sertifikasi TOEFL/IELTS & TOAFL.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('programs') }}" 
               class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-600 hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-xs">
                <span>Lihat Seluruh Struktur Kurikulum</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

    </div>
</section>

<!-- ========================================================
     06. DAFTAR SEKARANG JUGA! (4-PHOTO COLLAGE + CTA PPDB)
     Dynamic Collage: cta_collage_image_1..4
     ======================================================== -->
<section class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left: 4-Photo Collage -->
            <div class="lg:col-span-5 reveal-init reveal-left">
                <div class="grid grid-cols-2 gap-3.5 max-w-md mx-auto">
                    <img src="{{ $profile?->getCtaCollageImage(1) ?? 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=400&q=80' }}" 
                         alt="Foto Santri SMA 1" 
                         class="w-full h-36 sm:h-44 object-cover rounded-2xl shadow-sm border border-slate-200"
                         onerror="this.src='https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=400&q=80'">
                    <img src="{{ $profile?->getCtaCollageImage(2) ?? 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=400&q=80' }}" 
                         alt="Foto Santri SMA 2" 
                         class="w-full h-36 sm:h-44 object-cover rounded-2xl shadow-sm border border-slate-200"
                         onerror="this.src='https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=400&q=80'">
                    <img src="{{ $profile?->getCtaCollageImage(3) ?? 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=400&q=80' }}" 
                         alt="Foto Santri SMA 3" 
                         class="w-full h-36 sm:h-44 object-cover rounded-2xl shadow-sm border border-slate-200"
                         onerror="this.src='https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=400&q=80'">
                    <img src="{{ $profile?->getCtaCollageImage(4) ?? 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=400&q=80' }}" 
                         alt="Foto Santri SMA 4" 
                         class="w-full h-36 sm:h-44 object-cover rounded-2xl shadow-sm border border-slate-200"
                         onerror="this.src='https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=400&q=80'">
                </div>
            </div>

            <!-- Right: Title + 4 Action Buttons -->
            <div class="lg:col-span-7 space-y-6 text-left reveal-init reveal-right delay-150">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-200">
                        Penerimaan Santri Baru
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight mt-3">
                        Daftar SMA Islam Al-Madinah BSD <br>
                        <span class="text-emerald-600">Sekarang Juga!</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                        Segera daftarkan putra-putri Anda pada Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran {{ $academicYear }}. Kuota terbatas (maksimal 24 santri per kelas) demi menjaga kualitas bimbingan personal.
                    </p>
                </div>

                <!-- 4 Action Pill Buttons -->
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('ppdb.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all">
                        <span>DAFTAR ONLINE</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>

                    <button type="button" 
                            onclick="openBrosurPpdbModal()" 
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs uppercase tracking-wider border border-slate-200 shadow-2xs hover:shadow-xs transition-all cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>UNDUH BROSUR</span>
                    </button>

                    <button type="button" 
                            onclick="openBiayaPpdbModal()" 
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs uppercase tracking-wider border border-slate-200 shadow-2xs hover:shadow-xs transition-all cursor-pointer">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>BIAYA PPDB</span>
                    </button>

                    <a href="{{ $waUrlPanitia }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-[#25D366] hover:bg-[#20ba59] text-white font-bold text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>CHAT WA PANITIA</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     07. KEJUARAAN & REKAM JEJAK PRESTASI (INTERACTIVE CAROUSEL)
     Dinamis dari Filament Resource: App\Models\Achievement
     ======================================================== -->
<section id="prestasi" class="py-16 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 reveal-init">
            <div class="space-y-2 max-w-xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200">
                    <svg class="w-3.5 h-3.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <span>Prestasi Santri SMA</span>
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Rekam Jejak Kejuaraan & Prestasi
                </h2>
                <div class="w-16 h-1 bg-emerald-600 rounded-full"></div>
                <p class="text-xs sm:text-sm text-slate-600">
                    Membina potensi santri berprestasi dalam bidang tahfidz Al-Qur'an, olimpiade sains, riset KIR, bahasa asing, dan olahraga.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('achievements') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-300 hover:border-emerald-600 text-slate-700 hover:text-emerald-700 text-xs font-bold transition-all shadow-2xs">
                    <span>Lihat Semua Prestasi</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left: Stat Card -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-gradient-to-br from-slate-900 to-[#132238] rounded-3xl p-6 sm:p-7 text-white shadow-xl space-y-6 relative overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>

                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center font-black text-xl shadow-md">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-300">Etalase Prestasi</span>
                            <h3 class="text-base font-black text-white">{{ $schoolName }}</h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-1">
                        <div class="p-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                            <div class="text-xl sm:text-2xl font-black text-white">
                                {{ $profile->statistic_achievements ?? ($achievements->count() > 0 ? $achievements->count() . '+' : '45+') }}
                            </div>
                            <div class="text-[10px] text-slate-300 mt-0.5">Total Prestasi</div>
                        </div>
                        <div class="p-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                            <div class="text-xl sm:text-2xl font-black text-emerald-400">
                                {{ ($nationalAchievementsCount ?? 0) > 0 ? $nationalAchievementsCount . '+' : '12+' }}
                            </div>
                            <div class="text-[10px] text-slate-300 mt-0.5">Tingkat Nasional</div>
                        </div>
                        <div class="p-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                            <div class="text-xl sm:text-2xl font-black text-amber-400">100%</div>
                            <div class="text-[10px] text-slate-300 mt-0.5">Binaan Pendidik</div>
                        </div>
                        <div class="p-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                            <div class="text-xl sm:text-2xl font-black text-teal-300">Juara 1</div>
                            <div class="text-[10px] text-slate-300 mt-0.5">OSN / FLS2N / MTQ</div>
                        </div>
                    </div>

                    <p class="text-xs text-slate-300 leading-relaxed italic border-t border-white/10 pt-4">
                        {{ $profile->motto ?? '"Mendidik generasi berilmu tinggi, berakhlak mulia, dan berprestasi unggul."' }}
                    </p>
                </div>
            </div>

            <!-- Right: Interactive Dynamic Achievement Slider -->
            <div class="lg:col-span-8 w-full"
                 id="achievements-carousel"
                 x-data="{
                    activeIndex: 0,
                    total: {{ max($achievements->count(), 1) }},
                    timer: null,
                    init() {
                        this.startAuto();
                    },
                    next() {
                        this.activeIndex = (this.activeIndex + 1) % this.total;
                        this.restartAuto();
                    },
                    prev() {
                        this.activeIndex = (this.activeIndex - 1 + this.total) % this.total;
                        this.restartAuto();
                    },
                    select(idx) {
                        this.activeIndex = idx;
                        this.restartAuto();
                    },
                    startAuto() {
                        if (this.total > 1) {
                            this.timer = setInterval(() => {
                                this.activeIndex = (this.activeIndex + 1) % this.total;
                            }, 5000);
                        }
                    },
                    stopAuto() {
                        if (this.timer) {
                            clearInterval(this.timer);
                            this.timer = null;
                        }
                    },
                    restartAuto() {
                        this.stopAuto();
                        this.startAuto();
                    }
                 }"
                 @mouseenter="stopAuto()"
                 @mouseleave="startAuto()">

                @if($achievements->isNotEmpty())
                    @foreach($achievements as $index => $achieve)
                        <div id="achievement-item-{{ $index }}"
                             x-show="activeIndex === {{ $index }}"
                             {{ $index > 0 ? 'x-cloak' : '' }}
                             x-transition:enter="transition ease-out duration-400 transform"
                             x-transition:enter-start="opacity-0 translate-y-3 scale-98"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             class="achievement-item-card bg-slate-50 rounded-3xl border border-slate-200 p-5 sm:p-7 shadow-sm space-y-4 relative">
                            
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-600 text-white">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                                    <span>{{ $achieve->rank ? $achieve->rank . ' • ' : '' }}{{ $achieve->level_label }}</span>
                                </span>
                                <span class="text-xs font-semibold text-slate-600 bg-white px-3 py-1 rounded-full border border-slate-200">
                                    Tahun {{ $achieve->year }}
                                </span>
                            </div>

                            <div class="h-52 sm:h-64 rounded-2xl overflow-hidden bg-slate-200 border border-slate-200 relative group">
                                <img src="{{ $achieve->photo_url }}" 
                                     alt="{{ $achieve->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>
                                @if(!empty($achieve->category))
                                    <span class="absolute bottom-3 left-3 px-3 py-1 rounded-lg bg-black/70 backdrop-blur-xs text-[10px] font-semibold text-white uppercase tracking-wider">
                                        {{ $achieve->category_label }}
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-1.5">
                                <h4 class="text-base sm:text-lg font-black text-slate-900 leading-snug">
                                    {{ $achieve->title }}
                                </h4>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-600">
                                    <span>Peraih: <strong class="text-slate-900">{{ $achieve->student_name }}</strong></span>
                                    @if(!empty($achieve->organizer))
                                        <span class="hidden sm:inline text-slate-300">•</span>
                                        <span class="text-slate-500 italic">{{ $achieve->organizer }}</span>
                                    @endif
                                </div>
                                @if(!empty($achieve->description))
                                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed pt-1">
                                        {{ $achieve->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-3 flex flex-wrap items-center justify-between gap-3 border-t border-slate-200">
                                <a href="{{ route('achievements') }}" class="text-xs font-bold text-emerald-700 hover:underline flex items-center gap-1.5 group">
                                    <span>Buka Galeri Prestasi</span>
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>

                                <div class="flex items-center gap-2">
                                    <div class="hidden sm:flex items-center gap-1 mr-1">
                                        @foreach($achievements as $dotIdx => $dotItem)
                                            <button type="button"
                                                    @click="select({{ $dotIdx }})"
                                                    :class="activeIndex === {{ $dotIdx }} ? 'w-5 bg-emerald-600' : 'w-1.5 bg-slate-300 hover:bg-slate-400'"
                                                    class="h-1.5 rounded-full transition-all duration-300 cursor-pointer"
                                                    title="Prestasi {{ $dotIdx + 1 }}"
                                                    aria-label="Prestasi {{ $dotIdx + 1 }}"></button>
                                        @endforeach
                                    </div>

                                    <span class="text-[11px] font-semibold text-slate-600 bg-white px-2.5 py-0.5 rounded-md tabular-nums border border-slate-200 achievement-counter">
                                        {{ $index + 1 }} / {{ $achievements->count() }}
                                    </span>

                                    <button type="button" 
                                            @click="prev()" 
                                            class="w-8 h-8 rounded-full border border-slate-300 bg-white flex items-center justify-center text-slate-700 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all text-xs cursor-pointer shadow-2xs" 
                                            title="Prestasi Sebelumnya" 
                                            aria-label="Prestasi Sebelumnya">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <button type="button" 
                                            @click="next()" 
                                            class="w-8 h-8 rounded-full border border-slate-300 bg-white flex items-center justify-center text-slate-700 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all text-xs cursor-pointer shadow-2xs" 
                                            title="Prestasi Berikutnya" 
                                            aria-label="Prestasi Berikutnya">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-slate-50 rounded-3xl border border-slate-200 p-8 text-center space-y-3">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900">Belum Ada Data Prestasi</h4>
                        <p class="text-xs text-slate-500">Data prestasi dapat dikelola melalui admin panel Filament.</p>
                    </div>
                @endif

            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     08. EKSTRAKURIKULER & PENGEMBANGAN DIRI SMA
     Dinamis dari Filament Resource: App\Models\Extracurricular
     ======================================================== -->
@php
    $getEkskulMeta = function ($category, $name = '') {
        $text = strtolower(($category ?? '') . ' ' . ($name ?? ''));
        if (str_contains($text, 'wajib') || str_contains($text, 'pramuka') || str_contains($text, 'scout')) {
            return ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'type' => 'scout'];
        }
        if (str_contains($text, 'qur') || str_contains($text, 'tahfidz') || str_contains($text, 'agama') || str_contains($text, 'hifdz')) {
            return ['bg' => 'bg-teal-50', 'text' => 'text-teal-700', 'type' => 'quran'];
        }
        if (str_contains($text, 'robot') || str_contains($text, 'sains') || str_contains($text, 'it') || str_contains($text, 'cod') || str_contains($text, 'stem') || str_contains($text, 'kir')) {
            return ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'type' => 'tech'];
        }
        if (str_contains($text, 'futsal') || str_contains($text, 'basket') || str_contains($text, 'panah') || str_contains($text, 'olahraga') || str_contains($text, 'silat') || str_contains($text, 'bela diri')) {
            return ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'type' => 'sport'];
        }
        if (str_contains($text, 'pmr') || str_contains($text, 'uks') || str_contains($text, 'sehat') || str_contains($text, 'medis')) {
            return ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'type' => 'health'];
        }
        if (str_contains($text, 'bahasa') || str_contains($text, 'speech') || str_contains($text, 'inggris') || str_contains($text, 'arab') || str_contains($text, 'debate')) {
            return ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'type' => 'language'];
        }
        if (str_contains($text, 'seni') || str_contains($text, 'desain') || str_contains($text, 'multi') || str_contains($text, 'jurnalistik') || str_contains($text, 'kreatif')) {
            return ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'type' => 'art'];
        }
        return ['bg' => 'bg-slate-100', 'text' => 'text-slate-800', 'type' => 'default'];
    };
@endphp

<section id="ekstrakurikuler" class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="text-center space-y-3 max-w-2xl mx-auto reveal-init">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                Pengembangan Karakter
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Ekstrakurikuler & Eksplorasi Bakat SMA
            </h2>
            <div class="w-16 h-1 bg-emerald-600 rounded-full mx-auto"></div>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                Wadah penyaluran minat bakat, kepemimpinan, riset ilmiah, dan pembinaan karakter tangguh berlandaskan nilai-nilai Islam.
            </p>
        </div>

        @if($extracurriculars->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-start max-w-5xl mx-auto"
                 id="ekstrakurikuler-container"
                 x-data="{
                    selected: 0,
                    total: {{ max($extracurriculars->count(), 1) }},
                    timer: null,
                    touchStartX: 0,
                    init() {
                        this.startAuto();
                    },
                    next() {
                        this.selected = (this.selected + 1) % this.total;
                        this.restartAuto();
                    },
                    prev() {
                        this.selected = (this.selected - 1 + this.total) % this.total;
                        this.restartAuto();
                    },
                    select(idx) {
                        this.selected = idx;
                        this.restartAuto();
                    },
                    startAuto() {
                        if (this.total > 1) {
                            this.timer = setInterval(() => {
                                this.selected = (this.selected + 1) % this.total;
                            }, 5000);
                        }
                    },
                    stopAuto() {
                        if (this.timer) {
                            clearInterval(this.timer);
                            this.timer = null;
                        }
                    },
                    restartAuto() {
                        this.stopAuto();
                        this.startAuto();
                    }
                 }"
                 @mouseenter="stopAuto()"
                 @mouseleave="startAuto()">
                
                <!-- Left: Featured Extracurricular Spotlight -->
                <div class="col-span-1 md:col-span-6 flex justify-center w-full reveal-init reveal-left delay-100">
                    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 text-center space-y-5 shadow-md relative min-h-[440px] flex flex-col justify-between touch-pan-y select-none"
                         @touchstart="touchStartX = $event.changedTouches[0].screenX"
                         @touchend="if ($event.changedTouches[0].screenX < touchStartX - 40) next(); if ($event.changedTouches[0].screenX > touchStartX + 40) prev();">
                        
                        <button type="button" 
                                @click="prev()" 
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-slate-50 border border-slate-200 text-slate-700 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-all shadow-xs cursor-pointer z-10" 
                                title="Ekstrakurikuler Sebelumnya" 
                                aria-label="Ekstrakurikuler Sebelumnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button type="button" 
                                @click="next()" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-slate-50 border border-slate-200 text-slate-700 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-all shadow-xs cursor-pointer z-10" 
                                title="Ekstrakurikuler Berikutnya" 
                                aria-label="Ekstrakurikuler Berikutnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>

                        @foreach($extracurriculars as $index => $ekskul)
                            @php
                                $meta = $getEkskulMeta($ekskul->category, $ekskul->name);
                            @endphp
                            <div id="ekskul-slide-{{ $index }}"
                                 x-show="selected === {{ $index }}"
                                 {{ $index > 0 ? 'x-cloak' : '' }}
                                 x-transition:enter="transition ease-out duration-400 transform"
                                 x-transition:enter-start="opacity-0 translate-y-3 scale-98"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 class="ekskul-slide-item space-y-4 flex-1 flex flex-col justify-center">

                                @if(!empty($ekskul->image))
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-2xl overflow-hidden border-2 border-slate-200 shadow-sm bg-white">
                                        <img src="{{ $ekskul->image_url }}" alt="{{ $ekskul->name }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-2xl {{ $meta['bg'] }} {{ $meta['text'] }} p-3 sm:p-4 shadow-xs flex items-center justify-center">
                                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                    </div>
                                @endif

                                <div class="space-y-1.5">
                                    <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">
                                        {{ $ekskul->name }}
                                    </h3>
                                    <p class="text-xs text-emerald-700 font-bold">
                                        {{ $ekskul->category_label }} • SMA Islam Al-Madinah
                                    </p>
                                    
                                    @if(!empty($ekskul->coach_name) || !empty($ekskul->schedule))
                                        <div class="flex flex-wrap items-center justify-center gap-x-3 gap-y-1 text-[11px] text-slate-600 bg-slate-50 py-1.5 px-3 rounded-xl border border-slate-200 inline-flex max-w-xs mx-auto">
                                            @if(!empty($ekskul->coach_name))
                                                <span><strong>Pembina:</strong> {{ $ekskul->coach_name }}</span>
                                            @endif
                                            @if(!empty($ekskul->schedule))
                                                <span><strong>Jadwal:</strong> {{ $ekskul->schedule }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    <p class="text-xs text-slate-600 leading-relaxed max-w-xs mx-auto line-clamp-3">
                                        {{ $ekskul->description ?? 'Membina kemandirian, karakter beradab, serta potensi kepemimpinan santri berlandaskan nilai Islam.' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        <div class="pt-2 space-y-3">
                            <div>
                                <a href="{{ route('programs') }}" 
                                   class="inline-flex items-center gap-2 px-5 py-2 rounded-full border border-emerald-600 text-emerald-700 hover:bg-emerald-600 hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-2xs">
                                    <span>Lihat Semua Program & Ekskul</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>

                            <div class="flex items-center justify-center gap-1.5 pt-1">
                                @foreach($extracurriculars as $index => $ekskul)
                                    <button type="button" 
                                            id="ekskul-dot-{{ $index }}"
                                            @click="select({{ $index }})" 
                                            :class="selected === {{ $index }} ? 'w-6 bg-emerald-600 shadow-xs' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                                            class="ekskul-dot-indicator h-2 rounded-full transition-all duration-300 cursor-pointer" 
                                            title="{{ $ekskul->name }}"
                                            aria-label="{{ $ekskul->name }}"></button>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right: Desktop Interactive Grid -->
                <div class="ekskul-desktop-grid hidden md:block md:col-span-6 w-full space-y-3 reveal-init reveal-right delay-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($extracurriculars as $index => $item)
                            @php
                                $itemMeta = $getEkskulMeta($item->category, $item->name);
                            @endphp
                            <div id="ekskul-card-{{ $index }}"
                                 @click="select({{ $index }})"
                                 :class="{
                                     'border-emerald-500 bg-white ring-2 ring-emerald-500/30 shadow-md scale-[1.02] border-l-4 border-l-emerald-600': selected === {{ $index }},
                                     'border-slate-200 bg-white hover:border-emerald-300 opacity-90 hover:opacity-100': selected !== {{ $index }}
                                 }"
                                 class="ekskul-card-item p-3.5 rounded-2xl border transition-all duration-300 space-y-2 group cursor-pointer text-left relative">
                                
                                <div class="flex items-center justify-between">
                                    <div class="w-9 h-9 rounded-xl {{ $itemMeta['bg'] }} {{ $itemMeta['text'] }} flex items-center justify-center p-2 transition-transform duration-300"
                                         :class="selected === {{ $index }} ? 'scale-110 shadow-xs' : ''">
                                        @if(!empty($item->image))
                                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        @endif
                                    </div>

                                    <div :class="selected === {{ $index }} ? 'bg-emerald-600 text-white font-bold' : 'bg-slate-100 text-slate-600 font-semibold'"
                                         class="text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded-full flex items-center gap-1 transition-all duration-200">
                                        <span x-text="selected === {{ $index }} ? 'Aktif' : 'Pilih'"></span>
                                    </div>
                                </div>

                                <div>
                                    <h4 :class="selected === {{ $index }} ? 'text-emerald-700 font-black' : 'text-slate-900 group-hover:text-emerald-700 font-bold'"
                                        class="text-xs transition-colors line-clamp-1">
                                        {{ $item->name }}
                                    </h4>
                                    <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">
                                        {{ $item->schedule ?? $item->coach_name ?? $item->category_label }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-2 flex items-center justify-between text-xs text-slate-500">
                        <span>Tersedia {{ $extracurriculars->count() }} kegiatan ekstrakurikuler santri</span>
                        <a href="{{ route('programs') }}" class="font-bold text-emerald-700 hover:underline flex items-center gap-1">
                            <span>Jadwal Lengkap</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        @endif

    </div>
</section>

<!-- ========================================================
     09. MULTIMEDIA RESMI: VIDEO PROFIL & INSTAGRAM RESMI (#video-profil)
     Crucial: Supports Video Profil SMA Al-Madinah & Instagram Resmi
     ======================================================== -->
<section id="video-profil" class="py-16 lg:py-24 bg-white border-b border-slate-200 relative overflow-hidden">
    <div class="absolute -top-24 right-0 w-96 h-96 bg-emerald-100/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 left-0 w-96 h-96 bg-amber-100/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-12">
        
        <div class="text-center max-w-3xl mx-auto space-y-3 reveal-init">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-[#0D6B57] text-xs font-bold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                <span>MULTIMEDIA & KABAR MEDIA SOSIAL</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0D6B57] tracking-tight">
                Video Profil & Aktivitas Terkini
            </h2>
            <p class="text-xs sm:text-sm text-slate-600">
                Saksikan lingkungan belajar, pembinaan akhlak santri, dan ikuti kabar terbaru SMA Al-Madinah langsung melalui saluran YouTube dan Instagram resmi kami.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            <!-- LEFT (7 Cols): YouTube Video Profile Player -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-7 shadow-lg border border-emerald-100/80 hover:shadow-xl transition-shadow flex flex-col justify-between reveal-init reveal-left">
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 shadow-xs">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug">
                                    Video Profil SMA Al-Madinah
                                </h3>
                                <p class="text-xs text-slate-500">
                                    Mengenal lebih dekat lingkungan dan budaya sekolah
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-[11px] font-bold border border-rose-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-ping"></span>
                            YouTube
                        </span>
                    </div>

                    @if(!empty($ytEmbedUrl))
                        <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-900 shadow-md border border-slate-200">
                            <iframe 
                                src="{{ $ytEmbedUrl }}" 
                                title="Video Profil {{ $schoolName }}"
                                class="w-full h-full border-0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen
                                loading="lazy">
                            </iframe>
                        </div>
                    @elseif($hasRawIframe)
                        <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-900 shadow-md border border-slate-200 [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                            {!! $profile->youtube_embed !!}
                        </div>
                    @else
                        <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-gradient-to-tr from-[#08493B] to-[#117C65] shadow-md border border-emerald-800 flex flex-col items-center justify-center text-center p-6 text-white group">
                            <img src="{{ $heroImageSrc }}" alt="{{ $schoolName }}" class="absolute inset-0 w-full h-full object-cover opacity-25 group-hover:scale-105 transition-transform duration-500">
                            <div class="relative z-10 space-y-3">
                                <a href="{{ $profile?->youtube_url ?? 'https://youtube.com' }}" target="_blank" rel="noopener noreferrer" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white/20 backdrop-blur-md hover:bg-rose-600 text-white flex items-center justify-center mx-auto shadow-2xl transition-all transform hover:scale-110">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 fill-current translate-x-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </a>
                                <h4 class="text-base sm:text-lg font-extrabold text-white">Video Profil Resmi SMA</h4>
                                <p class="text-xs text-emerald-100 max-w-sm">Tonton dinamika pembelajaran dan fasilitas sekolah langsung di saluran YouTube resmi.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-xs text-slate-500">
                        Diproduksi oleh Tim Multimedia & Humas {{ $schoolName }}
                    </span>
                    <a href="{{ $profile?->youtube_url ?? 'https://youtube.com' }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all shadow-xs">
                        <span>Buka Channel YouTube</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>

            <!-- RIGHT (5 Cols): Instagram Official Embed / Feed -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-7 shadow-lg border border-emerald-100/80 hover:shadow-xl transition-shadow flex flex-col justify-between reveal-init reveal-right delay-150">
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 text-white flex items-center justify-center shadow-xs">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug">
                                    Instagram Resmi
                                </h3>
                                <p class="text-xs text-slate-500">
                                    {{ '@' . ($profile?->instagram_handle ?? 'smpalmadinah') }}
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-[11px] font-bold border border-pink-200">
                            Terbaru
                        </span>
                    </div>

                    @if(!empty($igHtml))
                        <div class="w-full flex justify-center items-center py-2 min-h-[380px] max-h-[520px] overflow-y-auto rounded-2xl bg-slate-50 border border-slate-100">
                            {!! $igHtml !!}
                        </div>
                    @else
                        <div class="rounded-2xl p-5 bg-gradient-to-b from-slate-50 to-white border border-slate-200 space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full p-0.5 bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600">
                                    <img src="{{ $logoSrc }}" alt="Logo" class="w-full h-full object-contain rounded-full bg-white p-1">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-sm font-extrabold text-slate-900 truncate">{{ $schoolName }}</span>
                                        <svg class="w-4 h-4 text-sky-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <p class="text-xs text-slate-500 truncate">{{ '@' . ($profile?->instagram_handle ?? 'smpalmadinah') }}</p>
                                </div>
                            </div>

                            <p class="text-xs text-slate-600 leading-relaxed">
                                Ikuti dokumentasi visual, reels motivasi santri, liputan prestasi, dan info pendaftaran PPDB terhangat langsung dari tim humas kami.
                            </p>

                            <div class="grid grid-cols-3 gap-2 pt-1">
                                <div class="aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=300&q=80" alt="Santri" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                </div>
                                <div class="aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    <img src="https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=300&q=80" alt="Kegiatan" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                </div>
                                <div class="aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=300&q=80" alt="Kelas" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-xs text-slate-500">
                        Update setiap hari di feed & stories
                    </span>
                    <a href="{{ $profile?->instagram_url ?? ('https://instagram.com/' . ($profile?->instagram_handle ?? 'smpalmadinah')) }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 via-rose-500 to-purple-600 hover:opacity-95 text-white text-xs font-bold transition-all shadow-xs">
                        <span>Lihat Instagram</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================
     10. FASILITAS SEKOLAH SMA (REPRESENTATIF & LENGKAP)
     Dinamis dari Filament Resource: App\Models\Facility
     ======================================================== -->
@if($facilities->isNotEmpty())
<section class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="text-center space-y-3 max-w-2xl mx-auto reveal-init">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                Sarana & Prasarana
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Fasilitas Sekolah Representatif
            </h2>
            <div class="w-16 h-1 bg-emerald-600 rounded-full mx-auto"></div>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                Menyediakan lingkungan belajar yang modern, nyaman, dan berstandar unggul untuk menunjang optimalisasi potensi akademik dan kepribadian santri.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($facilities as $fac)
                <div class="rounded-3xl border border-slate-200 bg-white overflow-hidden shadow-xs hover:shadow-lg transition-all group">
                    <div class="h-44 bg-slate-100 overflow-hidden relative">
                        <img src="{{ $fac->image_url }}" 
                             alt="{{ $fac->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @if(!empty($fac->category))
                            <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-md bg-black/60 backdrop-blur-xs text-[10px] font-semibold text-white uppercase tracking-wider">
                                {{ $fac->category }}
                            </span>
                        @endif
                    </div>
                    <div class="p-4 space-y-1.5">
                        <h4 class="text-sm font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                            {{ $fac->name }}
                        </h4>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $fac->description }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- ========================================================
     11. WARTA & BERITA TERKINI SMA (TALLCMS ARTICLES)
     ======================================================== -->
<section id="berita" class="py-16 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 reveal-init">
            <div class="space-y-2 max-w-xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                    <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <span>Warta & Publikasi</span>
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Kabar Terkini SMA Al-Madinah
                </h2>
                <div class="w-16 h-1 bg-emerald-600 rounded-full"></div>
                <p class="text-xs sm:text-sm text-slate-600">
                    Dokumentasi kegiatan akademik, agenda santri, prestasi terkini, dan pengumuman resmi yayasan.
                </p>
            </div>

            <a href="{{ route('news') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-300 hover:border-emerald-600 text-slate-700 hover:text-emerald-700 text-xs font-bold transition-all shadow-2xs">
                <span>Buka Seluruh Arsip Warta</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            @if($featuredPost)
                @php
                    $featImg = !empty($featuredPost->featured_image) 
                        ? (Str::startsWith($featuredPost->featured_image, ['http://', 'https://']) ? $featuredPost->featured_image : asset('storage/' . $featuredPost->featured_image)) 
                        : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80';
                    $featUrl = route('news.show', $featuredPost->slug ?: $featuredPost->id);
                    $featCat = $featuredPost->categories->first()?->name ?? 'Warta Utama';
                @endphp
                <div class="lg:col-span-6 bg-slate-50 rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="h-64 sm:h-72 overflow-hidden bg-slate-200 relative">
                        <img src="{{ $featImg }}" 
                             alt="{{ $featuredPost->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-emerald-600 text-white text-[10px] font-extrabold uppercase tracking-wider shadow">
                            {{ $featCat }}
                        </span>
                    </div>

                    <div class="p-6 sm:p-7 space-y-3">
                        <div class="flex items-center gap-3 text-xs text-slate-500">
                            <span>{{ $featuredPost->author?->name ?? 'Humas SMA Islam Al-Madinah' }}</span>
                            <span>•</span>
                            <span>{{ $featuredPost->published_at ? $featuredPost->published_at->translatedFormat('d F Y') : 'Terbaru' }}</span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-black text-slate-900 group-hover:text-emerald-700 transition-colors leading-snug">
                            <a href="{{ $featUrl }}">{{ $featuredPost->title }}</a>
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">
                            {{ $featuredPost->excerpt ?: Str::limit(strip_tags($featuredPost->content), 160) }}
                        </p>

                        <div class="pt-2">
                            <a href="{{ $featUrl }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="lg:col-span-6 space-y-3.5">
                @forelse($recentNews as $newsItem)
                    @php
                        $itemUrl = route('news.show', $newsItem->slug ?: $newsItem->id);
                        $itemImg = !empty($newsItem->featured_image) 
                            ? (Str::startsWith($newsItem->featured_image, ['http://', 'https://']) ? $newsItem->featured_image : asset('storage/' . $newsItem->featured_image)) 
                            : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=400&q=80';
                        $itemCat = $newsItem->categories->first()?->name ?? 'Warta Sekolah';
                    @endphp
                    <div class="bg-slate-50 rounded-2xl border border-slate-200 p-3.5 sm:p-4 hover:border-emerald-500 hover:shadow-md transition-all flex items-center gap-4 group">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl overflow-hidden bg-slate-200 shrink-0">
                            <img src="{{ $itemImg }}" alt="{{ $newsItem->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        </div>

                        <div class="flex-1 min-w-0 space-y-1">
                            <div class="flex items-center gap-2 text-[10px] text-slate-500">
                                <span class="font-bold text-emerald-700 uppercase">{{ $itemCat }}</span>
                                <span>•</span>
                                <span>{{ $newsItem->published_at ? $newsItem->published_at->translatedFormat('d M Y') : 'Terbaru' }}</span>
                            </div>

                            <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug">
                                <a href="{{ $itemUrl }}" class="hover:underline">{{ $newsItem->title }}</a>
                            </h4>

                            <p class="text-[11px] text-slate-500 line-clamp-1">
                                {{ $newsItem->excerpt ?: Str::limit(strip_tags($newsItem->content), 80) }}
                            </p>
                        </div>

                        <a href="{{ $itemUrl }}" class="p-2 text-slate-400 group-hover:text-emerald-600 transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                @empty
                    <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 text-center text-xs text-slate-500">
                        Belum ada warta tambahan.
                    </div>
                @endforelse
            </div>

        </div>

    </div>
</section>

<!-- ========================================================
     12. ALUR & JALUR PPDB SMA 2027/2028 (ADMISSION PATHWAY)
     ======================================================== -->
<section id="alur-ppdb" class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="text-center space-y-3 max-w-2xl mx-auto reveal-init">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                Informasi Pendaftaran
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Alur Pendaftaran Peserta Didik Baru (PPDB)
            </h2>
            <div class="w-16 h-1 bg-emerald-600 rounded-full mx-auto"></div>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                Tiga tahapan mudah proses pendaftaran calon santri SMA Islam Al-Madinah BSD Tahun Ajaran {{ $academicYear }}.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl p-6 border border-slate-200 text-center space-y-3 relative group hover:border-emerald-500 transition-colors shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white font-black text-lg flex items-center justify-center mx-auto shadow-md">
                    01
                </div>
                <h3 class="text-sm font-black text-slate-900">1. Pendaftaran Online</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Mengisi formulir digital di website resmi dan melengkapi data rapor SMP/MTs, NISN, serta identitas santri & wali.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200 text-center space-y-3 relative group hover:border-emerald-500 transition-colors shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white font-black text-lg flex items-center justify-center mx-auto shadow-md">
                    02
                </div>
                <h3 class="text-sm font-black text-slate-900">2. Asesmen & Wawancara</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Mengikuti tes potensi akademik, tes membaca & tahfidz Al-Qur'an, serta wawancara peminatan jurusan bersama orang tua.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200 text-center space-y-3 relative group hover:border-emerald-500 transition-colors shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white font-black text-lg flex items-center justify-center mx-auto shadow-md">
                    03
                </div>
                <h3 class="text-sm font-black text-slate-900">3. Pengumuman & Daftar Ulang</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Mengecek hasil kelulusan secara online di sistem, konfirmasi kelulusan, dan menyelesaikan administrasi daftar ulang.
                </p>
            </div>
        </div>

        <!-- PPDB Action Banner -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 rounded-3xl p-8 sm:p-10 text-white shadow-xl max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div class="space-y-1.5">
                <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-400">Siap Bergabung dengan Kami?</span>
                <h3 class="text-xl sm:text-2xl font-black text-white">Pendaftaran Tahun Ajaran {{ $academicYear }}</h3>
                <p class="text-xs text-emerald-200/80">Kuota santri terbatas demi menjamin bimbingan intensif.</p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3 shrink-0">
                <a href="{{ route('ppdb.index') }}" 
                   class="px-6 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider transition-all shadow-lg">
                    Daftar Sekarang
                </a>
                <a href="{{ route('ppdb.check-status') }}" 
                   class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs uppercase tracking-wider transition-all">
                    Cek Status
                </a>
                <button type="button" 
                        onclick="openBiayaPpdbModal()"
                        class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs uppercase tracking-wider transition-all cursor-pointer">
                    Rincian Biaya
                </button>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================
     13. HUBUNGI KAMI & PETA LOKASI SEKOLAH BSD
     ======================================================== -->
<section id="kontak" class="py-16 sm:py-20 bg-white relative">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="max-w-4xl mx-auto bg-slate-50 rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-10 reveal-init">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                
                <!-- Left: Contact Form connecting to WhatsApp -->
                <div class="space-y-4">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full border border-emerald-200">
                        Layanan Informasi
                    </span>
                    <h3 class="text-xl font-black text-slate-900">
                        Hubungi Tim Panitia SMA
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Sampaikan pertanyaan atau jadwalkan janji temu konsultasi pendidikan langsung dengan staf humas sekolah.
                    </p>

                    <form action="{{ $waUrlPanitia }}" method="GET" target="_blank" class="space-y-3 pt-1">
                        <div>
                            <input type="text" 
                                   name="nama" 
                                   required 
                                   placeholder="Nama Lengkap Orang Tua / Santri *" 
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 bg-white">
                        </div>
                        <div>
                            <input type="text" 
                                   name="kontak" 
                                   required 
                                   placeholder="Nomor WhatsApp Aktif *" 
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 bg-white">
                        </div>
                        <div>
                            <textarea name="pesan" 
                                      rows="3" 
                                      required 
                                      placeholder="Pertanyaan seputar program SMA, PPDB, atau biaya pendidikan..." 
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 bg-white"></textarea>
                        </div>
                        <div>
                            <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md">
                                <span>Kirim via WhatsApp</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right: School Info & Google Maps Embed -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-base font-black text-slate-900">
                            {{ $schoolName }}
                        </h4>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            {{ $profile->address ?? 'Komplek BSD City Sektor XIV, Serpong, Kota Tangerang Selatan, Banten' }}
                        </p>
                        <p class="text-xs text-emerald-700 font-bold mt-1.5">
                            Telepon: {{ $profile?->phone ?? '(021) 538-8888' }} • WA: {{ $whatsapp }}
                        </p>
                    </div>

                    <div class="h-56 rounded-2xl overflow-hidden border border-slate-200 shadow-inner bg-slate-100">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8016482813137!2d106.6806782!3d-6.3028731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fb7a2c56d787%3A0xe543596706903737!2sSMP%20Al%20Madinah%20Islamic%20Center%20KKMB!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta Lokasi {{ $schoolName }}">
                        </iframe>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- Floating WhatsApp Action Hook (Supports whatsapp_floating_url) -->
<div class="hidden" data-floating-hook="{{ $waUrlFloating }}"></div>

@push('scripts')
<script>
    // 1. QR Code Modal
    function openPpdbQrModal() {
        const modal = document.getElementById('ppdb-qr-modal');
        const box = document.getElementById('ppdb-qr-modal-box');
        if (!modal || !box) return;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closePpdbQrModal() {
        const modal = document.getElementById('ppdb-qr-modal');
        const box = document.getElementById('ppdb-qr-modal-box');
        if (!modal || !box) return;
        
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 200);
    }

    // 2. Brosur Modal
    function openBrosurPpdbModal() {
        const modal = document.getElementById('ppdb-brosur-modal');
        const box = document.getElementById('ppdb-brosur-modal-box');
        if (!modal || !box) return;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeBrosurPpdbModal() {
        const modal = document.getElementById('ppdb-brosur-modal');
        const box = document.getElementById('ppdb-brosur-modal-box');
        if (!modal || !box) return;
        
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 200);
    }

    // 3. Biaya PPDB Modal
    function openBiayaPpdbModal() {
        const modal = document.getElementById('ppdb-biaya-modal');
        const box = document.getElementById('ppdb-biaya-modal-box');
        if (!modal || !box) return;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeBiayaPpdbModal() {
        const modal = document.getElementById('ppdb-biaya-modal');
        const box = document.getElementById('ppdb-biaya-modal-box');
        if (!modal || !box) return;
        
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 200);
    }

    function copyPpdbUrl(url) {
        const label = document.getElementById('copy-text-label');
        const btn = document.getElementById('btn-copy-ppdb-url');

        const onSuccess = () => {
            if (label && btn) {
                const prev = label.textContent;
                label.textContent = 'Tersalin!';
                btn.classList.add('bg-amber-500');
                btn.classList.remove('bg-emerald-600');
                setTimeout(() => {
                    label.textContent = prev;
                    btn.classList.remove('bg-amber-500');
                    btn.classList.add('bg-emerald-600');
                }, 2000);
            }
        };

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(onSuccess).catch(() => fallbackCopy(url, onSuccess));
        } else {
            fallbackCopy(url, onSuccess);
        }
    }

    function fallbackCopy(text, callback) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-9999px';
        textArea.style.top = '0';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            callback();
        } catch (err) {
            console.error('Failed to copy text', err);
        }
        document.body.removeChild(textArea);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const modals = [
            { id: 'ppdb-qr-modal', close: closePpdbQrModal },
            { id: 'ppdb-brosur-modal', close: closeBrosurPpdbModal },
            { id: 'ppdb-biaya-modal', close: closeBiayaPpdbModal },
        ];

        modals.forEach(({ id, close }) => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('click', (e) => {
                    if (e.target === el) close();
                });
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closePpdbQrModal();
                closeBrosurPpdbModal();
                closeBiayaPpdbModal();
            }
        });
    });

    // Fallback scripts if Alpine.js is delayed
    window.cycleAchievement = function(dir) {
        if (window.Alpine) return;
        var cards = document.querySelectorAll('.achievement-item-card');
        if (!cards.length) return;
        var currentIdx = 0;
        cards.forEach(function(card, idx) {
            if (card.style.display !== 'none' && !card.classList.contains('hidden')) {
                currentIdx = idx;
            }
        });
        var nextIdx = (currentIdx + dir + cards.length) % cards.length;
        cards.forEach(function(card, idx) {
            card.style.display = (idx === nextIdx) ? 'block' : 'none';
        });
    };

    window.cycleEkskul = function(dir) {
        if (window.Alpine) return;
        var slides = document.querySelectorAll('.ekskul-slide-item');
        if (!slides.length) return;
        var currentIdx = 0;
        slides.forEach(function(slide, idx) {
            if (slide.style.display !== 'none' && !slide.classList.contains('hidden')) {
                currentIdx = idx;
            }
        });
        var nextIdx = (currentIdx + dir + slides.length) % slides.length;
        window.selectEkskul(nextIdx);
    };

    window.selectEkskul = function(targetIdx) {
        if (window.Alpine) return;
        var slides = document.querySelectorAll('.ekskul-slide-item');
        var dots = document.querySelectorAll('.ekskul-dot-indicator');
        var cards = document.querySelectorAll('.ekskul-card-item');

        slides.forEach(function(slide, idx) {
            slide.style.display = (idx === targetIdx) ? 'block' : 'none';
        });

        dots.forEach(function(dot, idx) {
            if (idx === targetIdx) {
                dot.className = 'ekskul-dot-indicator h-2 rounded-full transition-all duration-300 cursor-pointer w-6 bg-emerald-600 shadow-xs';
            } else {
                dot.className = 'ekskul-dot-indicator h-2 rounded-full transition-all duration-300 cursor-pointer w-2 bg-slate-300 hover:bg-slate-400';
            }
        });

        cards.forEach(function(card, idx) {
            if (idx === targetIdx) {
                card.classList.add('border-emerald-500', 'bg-white', 'ring-2', 'ring-emerald-500/30', 'shadow-md', 'scale-[1.02]', 'border-l-4', 'border-l-emerald-600');
                card.classList.remove('border-slate-200', 'opacity-90');
            } else {
                card.classList.remove('border-emerald-500', 'ring-2', 'ring-emerald-500/30', 'shadow-md', 'scale-[1.02]', 'border-l-4', 'border-l-emerald-600');
                card.classList.add('border-slate-200', 'opacity-90');
            }
        });
    };
</script>

@if(!empty($profile?->hasInstagramEmbed()))
    <script async src="//www.instagram.com/embed.js"></script>
@endif
@endpush

@endsection
