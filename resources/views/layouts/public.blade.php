<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Page Title & Meta Tags -->
    <title>@yield('title', 'SMA Islam Al-Madinah BSD — Sekolah Menengah Atas Berkarakter & Unggul')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Resmi SMA Islam Al-Madinah BSD di bawah naungan Yayasan Kerukunan Keluarga Muslim BSD. Menyeimbangkan pendidikan karakter Islami, tahfidz Al-Qur\'an, dwibahasa, dan sains teknologi modern di Serpong, Tangerang Selatan.')">
    <meta name="keywords" content="@yield('meta_keywords', 'SMA Al-Madinah BSD, SMA Islam Al-Madinah BSD, PPDB SMA BSD, Sekolah Islam Tangerang Selatan, YKKM BSD, Islamic Center KKMB, SMA Swasta Terbaik BSD')">
    <meta name="author" content="SMA Islam Al-Madinah BSD">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="SMA Islam Al-Madinah BSD">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="@yield('og_title', 'SMA Islam Al-Madinah BSD — Mendidik Karakter, Membina Prestasi')">
    <meta property="og:description" content="@yield('og_description', 'Pendidikan menengah atas berkualitas berbasis karakter Islami, tahfidz, dan sains modern di Sektor XIV BSD City, Serpong, Tangerang Selatan.')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo-almadinah.png'))">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('og_title', 'SMA Islam Al-Madinah BSD — Mendidik Karakter, Membina Prestasi')">
    <meta name="twitter:description" content="@yield('og_description', 'Pendidikan menengah atas berkualitas berbasis karakter Islami, tahfidz, dan sains modern di Sektor XIV BSD City, Serpong, Tangerang Selatan.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo-almadinah.png'))">

    <!-- Local SEO & Geo Meta Tags -->
    <meta name="geo.region" content="ID-BT">
    <meta name="geo.placename" content="Tangerang Selatan">
    <meta name="geo.position" content="-6.3015;106.6710">
    <meta name="ICBM" content="-6.3015, 106.6710">

    <!-- Structured Data (JSON-LD Schema.org for School & WebSite) -->
    @php
        $mainSchema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'School',
                    '@id' => url('/') . '#school',
                    'name' => 'SMA Islam Al-Madinah BSD',
                    'alternateName' => ['SMA Al-Madinah BSD', 'SMA Al Madinah Islamic Center KKMB', 'SMA Al-Madinah YKKM'],
                    'url' => url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('images/logo-almadinah.png'),
                    ],
                    'image' => asset('images/logo-almadinah.png'),
                    'description' => 'Sekolah Menengah Atas Islam Al-Madinah BSD di bawah naungan Yayasan Kerukunan Keluarga Muslim BSD (YKKM BSD). Mengintegrasikan kurikulum nasional, tahfidz Al-Qur\'an, dwibahasa, dan sains modern.',
                    'telephone' => '(021) 538-8888',
                    'email' => 'info@smpalmadinah.sch.id',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'Komplek BSD City Sektor XIV',
                        'addressLocality' => 'Serpong',
                        'addressRegion' => 'Banten',
                        'postalCode' => '15310',
                        'addressCountry' => 'ID',
                    ],
                    'geo' => [
                        '@type' => 'GeoCoordinates',
                        'latitude' => -6.3015,
                        'longitude' => 106.6710,
                    ],
                    'sameAs' => [
                        'https://www.instagram.com/amickkmb.perguruan',
                        'https://www.youtube.com/@SMP-SMAAl-MadinahIslamicCenter',
                        'https://facebook.com/smpalmadinah',
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => url('/') . '#website',
                    'url' => url('/'),
                    'name' => 'SMA Islam Al-Madinah BSD',
                    'publisher' => [
                        '@id' => url('/') . '#school',
                    ],
                    'inLanguage' => 'id-ID',
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($mainSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
    @stack('schema')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-almadinah.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-almadinah.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Amiri -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Alpine.js Cloak & Scroll Reveal Styles -->
    <style>
        [x-cloak] { display: none !important; }

        /* Smooth Scroll Reveal Animations */
        .reveal-init {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-init.reveal-left {
            transform: translateX(-24px);
        }
        .reveal-init.reveal-right {
            transform: translateX(24px);
        }
        .reveal-init.reveal-scale {
            transform: scale(0.95);
        }
        .reveal-init.is-revealed {
            opacity: 1 !important;
            transform: translateY(0) translateX(0) scale(1) !important;
        }

        .delay-100 { transition-delay: 100ms; }
        .delay-150 { transition-delay: 150ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
        .delay-500 { transition-delay: 500ms; }

        @media (prefers-reduced-motion: reduce) {
            .reveal-init {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }

        /* Extracurriculars responsive grid: Mobile hide, Desktop show */
        @media (max-width: 767.98px) {
            .ekskul-desktop-grid {
                display: none !important;
            }
        }
        @media (min-width: 768px) {
            .ekskul-desktop-grid {
                display: block !important;
            }
        }
    </style>

    <!-- Styles & Scripts (Tailwind CSS v4 via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for public interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-[#FAF9FB] text-[#202124] font-sans antialiased selection:bg-[#9377AD]/25 selection:text-[#4A3362] flex flex-col min-h-screen overflow-x-hidden">
    <!-- Skip to Content for Accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 bg-[#9377AD] text-white px-4 py-2 rounded-xl z-50 text-xs font-semibold shadow-lg focus:outline-none focus:ring-2 focus:ring-[#796092] print:hidden">
        Langsung ke konten utama
    </a>

    <!-- Master Header -->
    <x-public.header :profile="$schoolProfile ?? $profile ?? null" :ppdbSetting="$ppdbSetting ?? null" />

    <!-- Main Content Slot -->
    <main id="main-content" class="flex-1 w-full overflow-x-hidden">
        @yield('content')
    </main>

    <!-- Master Footer -->
    <x-public.footer :profile="$schoolProfile ?? $profile ?? null" />

    @php
        $fabProfile = $schoolProfile ?? $profile ?? \App\Models\SchoolProfile::first();
        $fabWaUrl = $fabProfile?->whatsapp_floating_url ?? 'https://wa.me/6281299887766';
    @endphp

    <!-- Floating WhatsApp Panitia Button (Mobile Optimized) -->
    <div class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-40 flex items-center gap-2.5 print:hidden group">
        <a href="{{ $fabWaUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="flex items-center gap-2.5 bg-white pl-3.5 pr-2 py-1.5 sm:pl-4 sm:pr-2.5 sm:py-2 rounded-full shadow-lg border border-[#E7E3EA] hover:border-[#9377AD]/50 hover:shadow-xl transition-all duration-300 group-hover:scale-105 active:scale-95 touch-manipulation"
           title="Chat WhatsApp Panitia">
            <span class="text-xs font-bold text-[#202124] tracking-wide hidden sm:inline">
                Konsultasi WhatsApp
            </span>
            <div class="w-10 h-10 rounded-full bg-[#2A923F] text-white flex items-center justify-center shadow-md shrink-0">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.181-.076.355.101.173.449.742.964 1.201.662.591 1.221.774 1.394.861.173.086.275.072.376-.044.101-.116.433-.506.549-.679.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z" />
                </svg>
            </div>
        </a>
    </div>

    @stack('scripts')

    <!-- Native Scroll Reveal Engine -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var reveals = document.querySelectorAll('.reveal-init');
            if (!reveals.length) return;
            if (!('IntersectionObserver' in window)) {
                reveals.forEach(function(el) { el.classList.add('is-revealed'); });
                return;
            }

            var observer = new IntersectionObserver(function(entries, obs) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                rootMargin: '0px 0px -40px 0px',
                threshold: 0.08
            });

            reveals.forEach(function(el) {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
