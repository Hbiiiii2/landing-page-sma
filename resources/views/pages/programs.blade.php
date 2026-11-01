@extends('layouts.public')

@section('title', 'Program Pendidikan & Ekstrakurikuler — SMA Islam Al-Madinah BSD')
@section('meta_description', 'Program unggulan kurikulum nasional, tahfidz Al-Qur\'an bersanad, dwibahasa, serta beragam ekstrakurikuler sains, robotik, dan olahraga di SMA Islam Al-Madinah BSD.')

@section('content')
@php
    $schoolName = $profile->name ?? 'SMA Al-Madinah BSD';
@endphp

<!-- Header Banner -->
<section class="bg-gradient-to-br from-[#3E2B52] via-[#543A70] to-[#704E94] text-white py-12 lg:py-16 border-b border-[#3E2B52]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-2.5">
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/15 border border-white/20 text-xs font-semibold text-purple-100 uppercase tracking-wider">
            KURIKULUM & KEGIATAN
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Program Pendidikan & Ekstrakurikuler
        </h1>
        <p class="text-xs sm:text-sm text-purple-100 max-w-xl mx-auto">
            Memadukan keilmuan akademik, kemahiran Al-Qur'an, dan eksplorasi bakat siswa secara berimbang di SMA Al-Madinah BSD.
        </p>
    </div>
</section>

<!-- Program Sekolah Detail -->
<section class="py-12 sm:py-16 bg-white border-b border-[#E7E3EA]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-[#9377AD]">PILAR KURIKULUM</span>
            <h2 class="text-2xl font-extrabold text-[#202124] tracking-tight mt-1">Pilar Program Akademik & Keislaman</h2>
            <p class="text-xs text-[#66676B] mt-1">Struktur kurikulum terintegrasi untuk membentuk siswa yang unggul dan beradab.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
            @forelse ($programs as $prog)
                <div class="bg-[#FAF9FB] rounded-2xl sm:rounded-3xl border border-[#E7E3EA] overflow-hidden hover:border-[#9377AD] hover:bg-white hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                    @if ($prog->image_url)
                        <div class="relative h-48 sm:h-60 w-full overflow-hidden bg-slate-100">
                            <img src="{{ $prog->image_url }}" 
                                 alt="{{ $prog->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                            <div class="absolute bottom-3.5 left-4 right-4 flex items-center justify-between">
                                <span class="text-[11px] font-bold px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-[#684681] uppercase tracking-wider shadow-sm">
                                    {{ $prog->category ?? 'Program' }}
                                </span>
                                <span class="text-[11px] font-semibold text-white bg-black/40 backdrop-blur-md px-3 py-1 rounded-full border border-white/20">
                                    SMA Al-Madinah BSD
                                </span>
                            </div>
                        </div>
                    @endif

                    <div class="p-5 sm:p-7 space-y-3.5 flex-1 flex flex-col justify-between">
                        <div class="space-y-2.5">
                            @if (! $prog->image_url)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-mono font-bold text-[#9377AD] uppercase tracking-wider">
                                        {{ $prog->category ?? 'Program' }}
                                    </span>
                                    <span class="text-xs font-bold bg-[#F4F0F7] text-[#684681] px-3 py-1 rounded-full border border-[#E3D9EC]">
                                        SMA Al-Madinah BSD
                                    </span>
                                </div>
                            @endif

                            <h3 class="text-lg sm:text-xl font-black text-[#202124] group-hover:text-[#684681] transition-colors">
                                {{ $prog->name }}
                            </h3>

                            @if ($prog->summary && $prog->description)
                                <p class="text-xs sm:text-sm font-semibold text-[#2A923F] leading-snug">
                                    {{ $prog->summary }}
                                </p>
                            @endif

                            <p class="text-xs sm:text-sm text-[#66676B] leading-relaxed">
                                {{ $prog->description ?? $prog->summary }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center text-xs text-[#66676B] py-12 bg-[#FAF9FB] rounded-2xl border border-[#E7E3EA]">
                    Data program belum tersedia.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Ekstrakurikuler -->
<section class="py-12 sm:py-16 bg-[#FAF9FB]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-[#9377AD]">PENGEMBANGAN DIRI</span>
            <h2 class="text-2xl font-extrabold text-[#202124] tracking-tight mt-1">Kegiatan Ekstrakurikuler Siswa</h2>
            <p class="text-xs text-[#66676B] mt-1">Wadah pengembangan minat bakat, kepemimpinan, olahraga, dan seni Islami.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse ($extracurriculars as $ekskul)
                <div class="bg-white rounded-2xl border border-[#E7E3EA] p-5 space-y-2.5 shadow-xs hover:border-[#9377AD] hover:shadow-sm transition-all flex flex-col justify-between">
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-bold uppercase text-[#9377AD] tracking-wider">{{ $ekskul->category }}</span>
                        <h3 class="text-sm font-bold text-[#202124]">{{ $ekskul->name }}</h3>
                        <p class="text-xs text-[#66676B] leading-relaxed line-clamp-3">{{ $ekskul->description }}</p>
                    </div>
                    @if ($ekskul->schedule)
                        <div class="pt-2 border-t border-[#E7E3EA] text-[10px] text-[#66676B] flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#2A923F] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $ekskul->schedule }}</span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-4 text-center text-xs text-[#66676B] py-12 bg-white rounded-2xl border border-[#E7E3EA]">
                    Data ekstrakurikuler belum tersedia.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
