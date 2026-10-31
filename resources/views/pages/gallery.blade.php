@extends('layouts.public')

@section('title', 'Galeri Kegiatan — SMA Islam Al-Madinah BSD')
@section('meta_description', 'Dokumentasi foto kegiatan belajar mengajar, pembiasaan ibadah, ekstrakurikuler, dan sarana prasarana di lingkungan SMA Islam Al-Madinah BSD.')

@section('content')
<!-- Header Banner -->
<section class="relative bg-gradient-to-br from-[#3E2B52] via-[#543A70] to-[#704E94] text-white py-12 sm:py-14 lg:py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
    <div class="relative max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-semibold text-emerald-200">
            <span class="w-1.5 h-1.5 rounded-full bg-[#2A923F]"></span>
            <span>DOKUMENTASI AKTIVITAS</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
            Galeri Kegiatan Siswa
        </h1>
        <p class="text-xs sm:text-sm md:text-base text-white/85 max-w-2xl mx-auto leading-relaxed">
            Merekam jejak pembiasaan adab Islami, pembelajaran terpadu, tahfidz Al-Qur'an, eksperimen sains, dan kreasi santri SMA Islam Al-Madinah BSD.
        </p>
    </div>
</section>

<!-- Grid Galeri -->
<section class="py-12 sm:py-16 bg-[#FAF9FB]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10">
        @php
            $sampleImages = [
                [
                    'url' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=700&q=80',
                    'title' => 'Pembiasaan Shalat Berjamaah & Tadarus Al-Qur\'an',
                    'tag' => 'Keislaman'
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=700&q=80',
                    'title' => 'Pembelajaran Aktif Berbasis Proyek Kelas Bilingual',
                    'tag' => 'Akademik'
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=700&q=80',
                    'title' => 'Kolaborasi Studi Lapangan & Sains Lingkungan',
                    'tag' => 'Laboratorium'
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=700&q=80',
                    'title' => 'Literasi Perpustakaan & Riset Siswa',
                    'tag' => 'Literasi'
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=700&q=80',
                    'title' => 'Pentas Seni Budaya & Kreasi Bahasa Santri',
                    'tag' => 'Kesenian'
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=700&q=80',
                    'title' => 'Praktikum Sains & Pengenalan Teknologi',
                    'tag' => 'Sains'
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=700&q=80',
                    'title' => 'Kunjungan Edukatif & Pembentukan Karakter Mandiri',
                    'tag' => 'Field Trip'
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=700&q=80',
                    'title' => 'Latihan Ekstrakurikuler Futsal & Olahraga Prestasi',
                    'tag' => 'Olahraga'
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @if (isset($galleries) && $galleries->isNotEmpty())
                @foreach ($galleries as $gallery)
                    @php
                        $fallback = $sampleImages[$loop->index % count($sampleImages)];
                        $img = $gallery->image_url ?? $fallback['url'];
                        $title = $gallery->title ?? $fallback['title'];
                        $tag = $gallery->category ?? $fallback['tag'];
                    @endphp
                    <div class="group relative rounded-2xl overflow-hidden bg-white border border-[#E7E3EA] shadow-sm hover:shadow-lg hover:border-[#9377AD]/50 transition-all duration-300 flex flex-col">
                        <div class="relative h-56 sm:h-60 overflow-hidden bg-[#FAF8FC]">
                            <img src="{{ $img }}" 
                                 alt="{{ $title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#202124]/90 via-[#202124]/20 to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                            
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/90 text-[#684681] backdrop-blur-sm shadow-sm">
                                    {{ $tag }}
                                </span>
                            </div>

                            <div class="absolute inset-x-0 bottom-0 p-4">
                                <h3 class="text-sm font-bold text-white leading-snug line-clamp-2 drop-shadow-sm">
                                    {{ $title }}
                                </h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @foreach ($sampleImages as $item)
                    <div class="group relative rounded-2xl overflow-hidden bg-white border border-[#E7E3EA] shadow-sm hover:shadow-lg hover:border-[#9377AD]/50 transition-all duration-300 flex flex-col">
                        <div class="relative h-56 sm:h-60 overflow-hidden bg-[#FAF8FC]">
                            <img src="{{ $item['url'] }}" 
                                 alt="{{ $item['title'] }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#202124]/90 via-[#202124]/20 to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                            
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/90 text-[#684681] backdrop-blur-sm shadow-sm">
                                    {{ $item['tag'] }}
                                </span>
                            </div>

                            <div class="absolute inset-x-0 bottom-0 p-4">
                                <h3 class="text-sm font-bold text-white leading-snug line-clamp-2 drop-shadow-sm">
                                    {{ $item['title'] }}
                                </h3>
                                <p class="text-[11px] text-white/75 mt-1">SMA Islam Al-Madinah BSD</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if (isset($galleries) && method_exists($galleries, 'hasPages') && $galleries->hasPages())
            <div class="pt-8 border-t border-[#E7E3EA] flex justify-center">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
