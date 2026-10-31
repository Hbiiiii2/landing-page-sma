@props([
    'profile' => null,
    'ppdbSetting' => null,
])

@php
    $schoolName = $profile->name ?? 'SMA Al-Madinah BSD';
    $foundationName = 'Islamic Center KKMB • Sektor XIV BSD';
    $address = $profile->address ?? 'Komplek BSD City Sektor XIV, Serpong, Tangerang Selatan';
    $phone = $profile->phone ?? '(021) 538-8888';
    $email = $profile->email ?? 'info@smpalmadinah.sch.id';
    $whatsapp = !empty($profile?->whatsapp) ? $profile->whatsapp : '0812-9988-7766';
    $whatsappClean = $profile?->whatsapp_ppdb_clean ?? '6281299887766';
    $academicYear = $ppdbSetting->academic_year ?? '2027/2028';
    $logoSrc = !empty($profile?->logo) ? asset('storage/' . $profile->logo) : asset('images/logo-almadinah.png');
@endphp

<header class="w-full transition-all duration-200 print:hidden" id="main-header">
    <!-- Slim Green Top Bar (Sesuai Referensi SMAN 2 Kebumen) -->
    <div class="bg-[#2A923F] text-white text-[11px] sm:text-xs py-1.5 px-4 sm:px-6 lg:px-8 border-b border-[#217333]">
        <div class="max-w-[1240px] mx-auto flex items-center justify-between gap-2">
            <div class="flex items-center gap-1.5 truncate text-[10.5px] sm:text-xs">
                <svg class="w-3.5 h-3.5 shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="truncate">{{ $address }}</span>
            </div>
            <div class="flex items-center gap-2.5 sm:gap-4 shrink-0 text-[10.5px] sm:text-xs">
                <a href="tel:{{ preg_replace('/[^0-9]/', '', $phone) }}" class="flex items-center gap-1 hover:underline opacity-95">
                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>{{ $phone }}</span>
                </a>
                <span class="opacity-50 hidden sm:inline">|</span>
                <a href="mailto:{{ $email }}" class="hidden sm:flex items-center gap-1 hover:underline opacity-95">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>{{ $email }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main White Navbar -->
    <nav class="bg-white border-b border-[#E7E3EA] shadow-xs sticky top-0 z-40" aria-label="Navigasi Utama">
        <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- School Brand / Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group focus:outline-none focus:ring-2 focus:ring-[#2A923F] rounded-xl p-1 min-w-0">
                    <img src="{{ $logoSrc }}" 
                         alt="Logo {{ $schoolName }}" 
                         class="w-10 h-10 sm:w-12 sm:h-12 object-contain shrink-0 group-hover:scale-105 transition-transform"
                         onerror="this.src='{{ asset('images/logo-almadinah.png') }}'">
                    <div class="leading-tight min-w-0">
                        <div class="text-sm sm:text-base md:text-lg font-black text-[#202124] group-hover:text-[#2A923F] transition-colors tracking-tight truncate">
                            SMA Islam Al-Madinah
                        </div>
                        <div class="text-[10px] sm:text-[11px] text-[#66676B] font-semibold tracking-wide truncate">
                            BSD City • Islamic Center KKMB
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation Links with Open-Source Heroicons -->
                <div class="hidden lg:flex items-center gap-1 xl:gap-2 text-xs font-bold text-[#202124]">
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('home') ? 'text-[#2A923F] bg-[#EAF6EC]' : 'hover:text-[#2A923F] hover:bg-slate-50' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('home') ? 'text-[#2A923F]' : 'text-[#66676B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Beranda</span>
                    </a>

                    <a href="{{ route('about') }}" 
                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('about') ? 'text-[#2A923F] bg-[#EAF6EC]' : 'hover:text-[#2A923F] hover:bg-slate-50' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('about') ? 'text-[#2A923F]' : 'text-[#66676B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Profil</span>
                    </a>

                    <a href="{{ route('programs') }}" 
                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('programs') ? 'text-[#2A923F] bg-[#EAF6EC]' : 'hover:text-[#2A923F] hover:bg-slate-50' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('programs') ? 'text-[#2A923F]' : 'text-[#66676B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Program</span>
                    </a>

                    <a href="{{ route('achievements') }}" 
                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('achievements') ? 'text-[#2A923F] bg-[#EAF6EC]' : 'hover:text-[#2A923F] hover:bg-slate-50' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('achievements') ? 'text-[#2A923F]' : 'text-[#66676B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <span>Prestasi</span>
                    </a>

                    <a href="{{ route('gallery') }}" 
                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('gallery') ? 'text-[#2A923F] bg-[#EAF6EC]' : 'hover:text-[#2A923F] hover:bg-slate-50' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('gallery') ? 'text-[#2A923F]' : 'text-[#66676B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Galeri</span>
                    </a>

                    <a href="{{ route('news') }}" 
                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('news*') ? 'text-[#2A923F] bg-[#EAF6EC]' : 'hover:text-[#2A923F] hover:bg-slate-50' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('news*') ? 'text-[#2A923F]' : 'text-[#66676B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span>Berita</span>
                    </a>

                    <a href="{{ url('/#kontak') }}" 
                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg transition-colors hover:text-[#2A923F] hover:bg-slate-50">
                        <svg class="w-4 h-4 text-[#66676B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Kontak</span>
                    </a>
                </div>

                <!-- Right Actions (Search Icon + PPDB Button) -->
                <div class="hidden sm:flex items-center gap-2.5">
                    <a href="{{ route('news') }}" 
                       class="w-9 h-9 rounded-lg bg-[#2A923F]/10 text-[#2A923F] hover:bg-[#2A923F] hover:text-white flex items-center justify-center transition-all" 
                       title="Cari Berita">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>

                    <a href="{{ route('ppdb.index') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#2A923F] hover:bg-[#217333] active:bg-[#1E662D] text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-sm hover:shadow">
                        <span>PPDB Online</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Mobile Actions (PPDB link + Hamburger Toggle) -->
                <div class="flex items-center gap-2 lg:hidden">
                    <a href="{{ route('ppdb.index') }}" 
                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-[#2A923F] text-white font-extrabold text-[10px] uppercase tracking-wider shadow-xs sm:hidden">
                        <span>PPDB</span>
                    </a>

                    <button type="button" 
                            id="mobile-menu-toggle"
                            class="p-2 rounded-xl text-[#202124] hover:bg-slate-100 border border-[#E7E3EA] focus:outline-none focus:ring-2 focus:ring-[#2A923F] transition-colors"
                            aria-label="Buka Menu Navigasi"
                            aria-expanded="false"
                            aria-controls="mobile-menu">
                        <!-- Hamburger Icon -->
                        <svg id="hamburger-icon" class="w-5 h-5 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Close Icon -->
                        <svg id="close-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu with Clean Heroicons -->
        <div id="mobile-menu" 
             class="hidden lg:hidden border-t border-[#E7E3EA] bg-white px-4 py-4 space-y-1.5 shadow-xl max-h-[calc(100vh-5.5rem)] overflow-y-auto overscroll-contain">
            <a href="{{ route('home') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('home') ? 'bg-[#EAF6EC] text-[#2A923F]' : 'text-[#202124] hover:bg-slate-50' }}">
                <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Beranda</span>
            </a>
            <a href="{{ route('about') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('about') ? 'bg-[#EAF6EC] text-[#2A923F]' : 'text-[#202124] hover:bg-slate-50' }}">
                <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>Profil & Visi Misi</span>
            </a>
            <a href="{{ route('programs') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('programs') ? 'bg-[#EAF6EC] text-[#2A923F]' : 'text-[#202124] hover:bg-slate-50' }}">
                <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>Program Pendidikan</span>
            </a>
            <a href="{{ route('achievements') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('achievements') ? 'bg-[#EAF6EC] text-[#2A923F]' : 'text-[#202124] hover:bg-slate-50' }}">
                <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <span>Prestasi Santri</span>
            </a>
            <a href="{{ route('gallery') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('gallery') ? 'bg-[#EAF6EC] text-[#2A923F]' : 'text-[#202124] hover:bg-slate-50' }}">
                <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Galeri Foto</span>
            </a>
            <a href="{{ route('news') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('news*') ? 'bg-[#EAF6EC] text-[#2A923F]' : 'text-[#202124] hover:bg-slate-50' }}">
                <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span>Berita & Warta</span>
            </a>
            <a href="{{ url('/#kontak') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs text-[#202124] hover:bg-slate-50">
                <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Kontak & Lokasi</span>
            </a>

            <!-- Quick Action Links for Mobile -->
            <div class="pt-3 border-t border-[#E7E3EA] space-y-2">
                <a href="{{ route('ppdb.index') }}" 
                   class="block w-full text-center py-3 rounded-full bg-[#2A923F] hover:bg-[#217333] active:bg-[#1E662D] text-white font-extrabold text-xs uppercase tracking-wider shadow-sm transition-all">
                    Pendaftaran PPDB Online
                </a>
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <a href="{{ route('ppdb.check-status') }}" 
                       class="text-center py-2 px-3 rounded-xl border border-[#E7E3EA] bg-slate-50 hover:bg-white text-[11px] font-bold text-[#202124] transition-colors">
                        Cek Status PPDB
                    </a>
                    <a href="{{ route('school.brochure') }}" 
                       class="text-center py-2 px-3 rounded-xl border border-[#E7E3EA] bg-slate-50 hover:bg-white text-[11px] font-bold text-[#202124] transition-colors">
                        Unduh Brosur
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        if (toggleBtn && mobileMenu) {
            toggleBtn.addEventListener('click', function () {
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                toggleBtn.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');
                
                if (hamburgerIcon && closeIcon) {
                    if (!isExpanded) {
                        hamburgerIcon.classList.remove('block');
                        hamburgerIcon.classList.add('hidden');
                        closeIcon.classList.remove('hidden');
                        closeIcon.classList.add('block');
                    } else {
                        hamburgerIcon.classList.remove('hidden');
                        hamburgerIcon.classList.add('block');
                        closeIcon.classList.remove('block');
                        closeIcon.classList.add('hidden');
                    }
                }
            });

            // Close mobile menu on link click
            mobileMenu.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    mobileMenu.classList.add('hidden');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    if (hamburgerIcon && closeIcon) {
                        hamburgerIcon.classList.remove('hidden');
                        hamburgerIcon.classList.add('block');
                        closeIcon.classList.remove('block');
                        closeIcon.classList.add('hidden');
                    }
                });
            });
        }
    });
</script>
