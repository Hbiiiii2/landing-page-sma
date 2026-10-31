@extends('layouts.public')

@section('title', 'Prestasi Siswa — SMA Islam Al-Madinah BSD')
@section('meta_description', 'Daftar torehan prestasi akademik, tahfidz Al-Qur\'an, olimpiade sains, robotika, dan keolahragaan santri SMA Islam Al-Madinah BSD.')

@section('content')
@php
    $schoolName = $profile->name ?? 'SMA Al-Madinah BSD';
@endphp

<!-- Header Banner -->
<section class="bg-gradient-to-br from-[#3E2B52] via-[#543A70] to-[#704E94] text-white py-12 lg:py-16 border-b border-[#3E2B52]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-2.5">
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/15 border border-white/20 text-xs font-semibold text-purple-100 uppercase tracking-wider">
            ETALASE REKOGNISI
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Prestasi & Kejuaraan Siswa
        </h1>
        <p class="text-xs sm:text-sm text-purple-100 max-w-xl mx-auto">
            Capaian membanggakan siswa SMA Al-Madinah BSD di bidang tahfidz Al-Qur'an, sains, teknologi, dan keolahragaan.
        </p>
    </div>
</section>

<!-- Grid Prestasi -->
<section class="py-12 sm:py-16 bg-[#FAF9FB]">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse ($achievements as $ach)
                @php
                    $achPhoto = !empty($ach->photo) 
                        ? (\Illuminate\Support\Str::startsWith($ach->photo, ['http://', 'https://']) ? $ach->photo : asset('storage/' . $ach->photo)) 
                        : null;
                @endphp
                <div class="bg-white rounded-2xl border border-[#E7E3EA] p-5 sm:p-6 flex flex-col justify-between space-y-4 shadow-xs hover:border-[#9377AD] hover:shadow-md transition-all group">
                    <div class="space-y-3">
                        @if ($achPhoto)
                            <div class="h-40 rounded-xl overflow-hidden bg-[#FAF9FB] border border-[#E7E3EA]">
                                <img src="{{ $achPhoto }}" 
                                     alt="{{ $ach->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     loading="lazy">
                            </div>
                        @endif

                        <div class="flex flex-wrap items-center justify-between gap-1.5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ str_contains(strtolower($ach->rank), '1') || str_contains(strtolower($ach->rank), 'emas') || str_contains(strtolower($ach->rank), 'gold') ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-[#EAF6EC] text-[#217333] border border-[#D2EAD7]' }}">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.982-3.172M15 4.5a3 3 0 11-6 0 3 3 0 016 0zm6 3a3 3 0 11-6 0 3 3 0 016 0zm-12 0a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $ach->rank }}</span>
                            </span>
                            <span class="text-[11px] font-mono text-[#66676B]">
                                {{ ucfirst($ach->level ?? 'Nasional') }} • {{ $ach->year }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#202124] leading-snug group-hover:text-[#9377AD] transition-colors">{{ $ach->title }}</h3>
                            <p class="text-xs text-[#66676B] mt-1">{{ $ach->description }}</p>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <div class="w-6 h-6 rounded-full bg-[#F4F0F7] flex items-center justify-center text-[#9377AD] font-bold text-[10px] shrink-0">
                                {{ substr($ach->student_name, 0, 2) }}
                            </div>
                            <span class="text-xs font-semibold text-[#202124]">Oleh: {{ $ach->student_name }}</span>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-[#E7E3EA] flex items-center justify-between text-[11px] text-[#66676B]">
                        <span class="font-medium text-[#9377AD]">{{ ucfirst($ach->category) }}</span>
                        <span class="truncate max-w-[160px]">{{ $ach->organizer }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-xs text-[#66676B] py-16 bg-white rounded-2xl border border-[#E7E3EA]">
                    Belum ada data prestasi siswa yang dipublikasikan.
                </div>
            @endforelse
        </div>

        @if ($achievements->hasPages())
            <div class="pt-6 border-t border-[#E7E3EA] flex justify-center">
                {{ $achievements->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
