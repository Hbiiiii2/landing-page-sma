@extends('layouts.public')

@section('title', 'Tentang Kami & Profil — SMA Islam Al-Madinah BSD')
@section('meta_description', 'Profil lengkap, sejarah pendirian, visi & misi, dewan asatidz guru pengajar, dan fasilitas SMA Al-Madinah Islamic Center KKMB di Sektor XIV BSD City.')

@section('content')
@php
    $schoolName = $profile->name ?? 'SMA Al-Madinah BSD';
    $foundation = 'Islamic Center KKMB • Sektor XIV BSD';
    $headmasterPhoto = !empty($profile?->headmaster_photo) 
        ? (Str::startsWith($profile->headmaster_photo, ['http://', 'https://']) ? $profile->headmaster_photo : asset('storage/' . $profile->headmaster_photo))
        : (!empty($profile?->logo) ? (Str::startsWith($profile->logo, ['http://', 'https://']) ? $profile->logo : asset('storage/' . $profile->logo)) : asset('images/banner-almadinah.png'));
@endphp

<!-- Header Banner -->
<section class="bg-gradient-to-br from-[#3E2B52] via-[#543A70] to-[#704E94] text-white py-12 lg:py-16 border-b border-[#3E2B52]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-2.5">
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/15 border border-white/20 text-xs font-semibold text-purple-100 uppercase tracking-wider">
            PROFIL SEKOLAH
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Tentang {{ $schoolName }}
        </h1>
        <p class="text-xs sm:text-sm text-purple-100 max-w-xl mx-auto">
            Mengenal lebih dekat visi, misi, nilai pembinaan adab, fasilitas, serta dewan guru dan asatidz kami.
        </p>
    </div>
</section>

<!-- Statistik Capaian Lembaga -->
<section class="py-8 sm:py-10 bg-[#FAF9FB] border-b border-[#E7E3EA]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6 text-center">
            <div class="p-3.5 sm:p-5 rounded-2xl bg-white border border-[#E7E3EA] shadow-xs hover:border-[#9377AD] transition-all">
                <div class="text-2xl sm:text-4xl font-black text-[#9377AD] font-mono">
                    {{ $profile?->statistic_students ?? 350 }}+
                </div>
                <div class="text-xs font-bold text-[#202124] mt-1 sm:mt-1.5">Siswa Aktif</div>
                <div class="text-[10px] sm:text-[11px] text-[#66676B] mt-0.5">Pembinaan intensif</div>
            </div>
            <div class="p-3.5 sm:p-5 rounded-2xl bg-white border border-[#E7E3EA] shadow-xs hover:border-[#9377AD] transition-all">
                <div class="text-2xl sm:text-4xl font-black text-[#2A923F] font-mono">
                    {{ $profile?->statistic_teachers ?? 25 }}
                </div>
                <div class="text-xs font-bold text-[#202124] mt-1 sm:mt-1.5">Pendidik & Asatidz</div>
                <div class="text-[10px] sm:text-[11px] text-[#66676B] mt-0.5">Musyrif & sarjana</div>
            </div>
            <div class="p-3.5 sm:p-5 rounded-2xl bg-white border border-[#E7E3EA] shadow-xs hover:border-[#9377AD] transition-all">
                <div class="text-2xl sm:text-4xl font-black text-[#4779B5] font-mono">
                    {{ $profile?->statistic_achievements ?? 48 }}+
                </div>
                <div class="text-xs font-bold text-[#202124] mt-1 sm:mt-1.5">Prestasi Siswa</div>
                <div class="text-[10px] sm:text-[11px] text-[#66676B] mt-0.5">Kota s/d nasional</div>
            </div>
            <div class="p-3.5 sm:p-5 rounded-2xl bg-white border border-[#E7E3EA] shadow-xs hover:border-[#9377AD] transition-all">
                <div class="text-2xl sm:text-4xl font-black text-[#9377AD] font-mono">
                    {{ $profile?->statistic_year_founded ?? 2012 }}
                </div>
                <div class="text-xs font-bold text-[#202124] mt-1 sm:mt-1.5">Tahun Berdiri</div>
                <div class="text-[10px] sm:text-[11px] text-[#66676B] mt-0.5">Akreditasi {{ $profile?->accreditation ?? 'A' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Profil & Sambutan -->
<section class="py-12 sm:py-16 bg-white border-b border-[#E7E3EA]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-10 sm:space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
            
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-full max-w-sm">
                    <div class="rounded-3xl overflow-hidden shadow-lg border-2 border-[#E7E3EA] bg-[#FAF9FB]">
                        <img src="{{ $headmasterPhoto }}" 
                             alt="{{ $profile->headmaster_name ?? 'Kepala Sekolah' }}" 
                             class="w-full h-72 sm:h-96 object-cover"
                             onerror="this.src='{{ asset('images/banner-almadinah.png') }}'">
                    </div>
                    <div class="absolute -bottom-4 left-4 right-4 bg-white p-3 sm:p-3.5 rounded-2xl shadow-md border border-[#E7E3EA] text-center">
                        <div class="text-xs font-bold text-[#202124]">{{ $profile->headmaster_name ?? 'H. M. Syaifullah, M.Pd.' }}</div>
                        <div class="text-[11px] text-[#9377AD] font-semibold mt-0.5">Kepala Sekolah {{ $schoolName }}</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 space-y-4">
                <span class="text-xs font-bold text-[#9377AD] uppercase tracking-wider">SAMBUTAN KEPALA SEKOLAH</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#202124] tracking-tight">
                    {{ $profile?->tagline ?? 'Mendidik Karakter Islami yang Tangguh dan Berwawasan Global' }}
                </h2>
                <div class="text-xs sm:text-sm text-[#66676B] leading-relaxed space-y-3">
                    <p class="italic bg-[#F4F0F7] p-4 rounded-2xl border border-[#E3D9EC] text-[#202124]">
                        "{{ $profile->headmaster_welcome ?? 'Selamat datang di portal resmi SMA Al-Madinah BSD. Kami bertekad mewujudkan lingkungan pendidikan yang menumbuhkan kecintaan terhadap Al-Qur\'an, ketajaman intelektual sains, serta keluhuran akhlak mulia.' }}"
                    </p>
                    <p>
                        {{ $profile->about ?? 'SMA Al-Madinah BSD berdiri di bawah naungan Yayasan Kerukunan Keluarga Muslim BSD (YKKM BSD) di kawasan asri Sektor XIV BSD City. Dengan mengusung konsep pendidikan terpadu, siswa dibimbing secara holistik mencakup aspek ruhiyah (spiritual), aqliyah (intelektual), dan jasadiyah (fisik).' }}
                    </p>
                </div>
            </div>

        </div>

        <!-- Visi & Misi Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
            <div class="bg-[#FAF9FB] rounded-2xl border border-[#E7E3EA] p-6 sm:p-8 space-y-3">
                <div class="flex items-center gap-2 text-xs font-bold text-[#9377AD] uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#9377AD]"></span>
                    <span>Visi Sekolah</span>
                </div>
                <p class="text-sm font-semibold text-[#202124] leading-relaxed">
                    {{ $profile->vision ?? 'Terwujudnya Generasi yang Berakhlak Mulia, Cerdas, Mandiri, dan Berwawasan Global Berdasarkan Nilai-Nilai Islam.' }}
                </p>
            </div>

            <div class="bg-[#FAF9FB] rounded-2xl border border-[#E7E3EA] p-6 sm:p-8 space-y-3">
                <div class="flex items-center gap-2 text-xs font-bold text-[#2A923F] uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2A923F]"></span>
                    <span>Misi Utama</span>
                </div>
                <div class="text-xs text-[#66676B] leading-relaxed whitespace-pre-line space-y-1">
                    {{ $profile->mission ?? "1. Menumbuhkan akidah shalihah dan pembiasaan adab Islami dalam kehidupan sehari-hari.\n2. Menyelenggarakan proses pembelajaran berbasis teknologi dan literasi modern.\n3. Membina hafalan Al-Qur'an bersanad dan keterampilan berbahasa internasional.\n4. Mengembangkan potensi kepemimpinan dan kemandirian sosial siswa." }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dewan Guru & Tenaga Pendidik -->
@if ($teachers->isNotEmpty())
<section class="py-16 bg-[#FAF9FB] border-b border-[#E7E3EA]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="text-center max-w-xl mx-auto space-y-1.5">
            <span class="text-xs font-bold uppercase tracking-wider text-[#9377AD]">TENAGA PENDIDIK</span>
            <h2 class="text-2xl font-extrabold text-[#202124] tracking-tight">Dewan Asatidz & Guru Pengajar</h2>
            <p class="text-xs text-[#66676B]">Pendidik berdedikasi dan bersertifikasi di bidang akademik dan keagamaan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($teachers as $teacher)
                <div class="bg-white rounded-2xl border border-[#E7E3EA] p-5 text-center shadow-xs space-y-3 hover:border-[#9377AD] hover:shadow-sm transition-all group">
                    <div class="w-24 h-24 mx-auto rounded-full bg-[#F4F0F7] border-2 border-[#9377AD] flex items-center justify-center font-bold text-[#9377AD] text-xl overflow-hidden shadow-xs relative">
                        @if ($teacher->photo_url)
                            <img src="{{ $teacher->photo_url }}" 
                                 alt="{{ $teacher->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <span style="display: none;" class="w-full h-full items-center justify-center font-bold text-[#9377AD] text-xl">
                                {{ substr($teacher->name, 0, 2) }}
                            </span>
                        @else
                            <span>{{ substr($teacher->name, 0, 2) }}</span>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-[#202124] leading-snug group-hover:text-[#9377AD] transition-colors">{{ $teacher->name }}</h3>
                        <p class="text-xs text-[#9377AD] font-semibold mt-0.5">{{ $teacher->role }}</p>
                        @if ($teacher->subject)
                            <p class="text-[11px] text-[#66676B] mt-0.5">{{ $teacher->subject }}</p>
                        @endif
                    </div>
                    @if ($teacher->education)
                        <div class="pt-2 border-t border-[#E7E3EA] text-[10px] text-[#66676B]">
                            {{ $teacher->education }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Sarana & Fasilitas SMA Al-Madinah Islamic Center KKMB -->
@if (isset($facilities) && $facilities->isNotEmpty())
<section class="py-16 bg-white border-b border-[#E7E3EA]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="text-center max-w-xl mx-auto space-y-1.5">
            <span class="text-xs font-bold uppercase tracking-wider text-[#9377AD]">SARANA & PRASARANA</span>
            <h2 class="text-2xl font-extrabold text-[#202124] tracking-tight">Fasilitas SMA Al-Madinah Islamic Center KKMB</h2>
            <p class="text-xs text-[#66676B]">Sarana dan prasarana terstandarisasi untuk menunjang kegiatan belajar mengajar, ibadah harian, dan pengembangan potensi santri.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($facilities as $facility)
                <div class="bg-[#FAF9FB] rounded-2xl border border-[#E7E3EA] overflow-hidden shadow-xs hover:border-[#9377AD] hover:shadow-md transition-all flex flex-col justify-between group">
                    <div>
                        <!-- Cover / Main Photo -->
                        <div class="h-48 bg-[#F4F0F7] relative overflow-hidden flex items-center justify-center">
                            @if(!empty($facility->photo_url))
                                <img src="{{ $facility->photo_url }}" 
                                     alt="{{ $facility->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#F4F0F7] to-[#ECE5F2] text-[#9377AD] p-4 text-center">
                                    <svg class="w-10 h-10 opacity-70 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-[11px] font-bold text-[#684681]">{{ $facility->name }}</span>
                                </div>
                            @endif

                            @if (!empty($facility->category))
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/90 backdrop-blur-xs text-[#684681] border border-[#E3D9EC] shadow-xs">
                                    {{ $facility->category }}
                                </span>
                            @endif

                            @if (!empty($facility->gallery_urls) && count($facility->gallery_urls) > 0)
                                <span class="absolute bottom-3 right-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-black/60 backdrop-blur-xs text-white flex items-center gap-1 shadow-xs">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>+{{ count($facility->gallery_urls) }} Foto</span>
                                </span>
                            @endif
                        </div>

                        <!-- Keterangan & Deskripsi Fasilitas -->
                        <div class="p-5 space-y-2">
                            <h3 class="text-base font-bold text-[#202124] group-hover:text-[#9377AD] transition-colors">
                                {{ $facility->name }}
                            </h3>
                            <p class="text-xs text-[#66676B] leading-relaxed line-clamp-4">
                                {{ $facility->description }}
                            </p>

                            <!-- Gallery Thumbnails (Jika ada foto-foto tambahan) -->
                            @if (!empty($facility->gallery_urls) && count($facility->gallery_urls) > 0)
                                <div class="pt-2 border-t border-[#E7E3EA]/60">
                                    <span class="text-[10px] font-bold text-[#66676B] block mb-1.5 uppercase tracking-wider">Foto Pendukung:</span>
                                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-none">
                                        @foreach(array_slice($facility->gallery_urls, 0, 4) as $thumb)
                                            <a href="{{ $thumb }}" target="_blank" class="w-10 h-10 rounded-lg overflow-hidden shrink-0 border border-[#E7E3EA] hover:border-[#9377AD] transition-colors" title="Lihat foto penuh">
                                                <img src="{{ $thumb }}" alt="Foto {{ $facility->name }}" class="w-full h-full object-cover">
                                            </a>
                                        @endforeach
                                        @if(count($facility->gallery_urls) > 4)
                                            <span class="text-[10px] text-[#66676B] font-bold shrink-0">
                                                +{{ count($facility->gallery_urls) - 4 }} lagi
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Lokasi & Peta SMA Al-Madinah Islamic Center KKMB -->
<section class="py-16 bg-[#FAF9FB]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="text-center max-w-xl mx-auto space-y-1.5">
            <span class="text-xs font-bold uppercase tracking-wider text-[#9377AD]">LOKASI SMA AL-MADINAH ISLAMIC CENTER KKMB</span>
            <h2 class="text-2xl font-extrabold text-[#202124] tracking-tight">Kunjungi SMA Al-Madinah Islamic Center KKMB</h2>
            <p class="text-xs text-[#66676B]">Buka petunjuk arah melalui Google Maps atau hubungi resepsionis kami.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Info Kontak & Alamat (5 cols) -->
            <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border border-[#E7E3EA] shadow-xs space-y-5">
                <div>
                    <h3 class="text-base font-bold text-[#202124] flex items-center gap-2">
                        <span class="w-7 h-7 rounded-xl bg-[#F4F0F7] text-[#9377AD] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <span>Alamat SMA Al-Madinah Islamic Center KKMB</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-[#66676B] mt-2 leading-relaxed">
                        {{ $profile?->address ?? 'Komplek BSD City Sektor XIV, Serpong, Kota Tangerang Selatan, Banten' }}
                    </p>
                </div>

                <div class="space-y-2.5 pt-2 border-t border-[#E7E3EA] text-xs">
                    <div class="flex items-center justify-between py-1 border-b border-slate-100">
                        <span class="text-[#66676B]">Telepon:</span>
                        <strong class="text-[#202124]">{{ $profile?->phone ?? '(021) 538-8888' }}</strong>
                    </div>
                    <div class="flex items-center justify-between py-1 border-b border-slate-100">
                        <span class="text-[#66676B]">WhatsApp:</span>
                        <strong class="text-[#2A923F]">{{ $profile?->whatsapp ?? '0812-9988-7766' }}</strong>
                    </div>
                    <div class="flex items-center justify-between py-1">
                        <span class="text-[#66676B]">Email:</span>
                        <strong class="text-[#202124]">{{ $profile?->email ?? 'info@smpalmadinah.sch.id' }}</strong>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($schoolName . ' ' . ($profile?->address ?? 'Al Madinah Islamic Centre BSD')) }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="w-full inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-[#9377AD] hover:bg-[#796092] active:bg-[#684681] text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm">
                        <span>Buka Peta Google Maps</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Frame Google Maps (7 cols) -->
            <div class="lg:col-span-7">
                <div class="w-full h-80 sm:h-96 rounded-3xl overflow-hidden shadow-sm border border-[#E7E3EA] bg-slate-100 relative [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                    @if (!empty($profile?->google_maps_embed))
                        {!! $profile->google_maps_embed !!}
                    @else
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d495.7268564616415!2d106.67262261897964!3d-6.288050860278647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fb2125c0a82d%3A0x635e8df9edaa3b7f!2sAl%20Madinah%20Islamic%20centre%20BSD!5e0!3m2!1sid!2sid!4v1791386907445!5m2!1sid!2sid" 
                                width="600" 
                                height="450" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
