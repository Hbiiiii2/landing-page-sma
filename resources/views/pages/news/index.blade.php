@extends('layouts.public')

@section('title', 'Berita & Warta — SMA Islam Al-Madinah BSD')
@section('meta_description', 'Kumpulan berita terkini, artikel edukasi, warta kegiatan santri, dan pengumuman resmi SMA Islam Al-Madinah BSD.')

@section('content')
<!-- Header Banner -->
<section class="relative bg-gradient-to-br from-[#3E2B52] via-[#543A70] to-[#704E94] text-white py-12 sm:py-14 lg:py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
    <div class="relative max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-semibold text-emerald-200">
            <span class="w-1.5 h-1.5 rounded-full bg-[#2A923F]"></span>
            <span>PUBLIKASI RESMI</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
            Berita & Warta Sekolah
        </h1>
        <p class="text-xs sm:text-sm md:text-base text-white/85 max-w-2xl mx-auto leading-relaxed">
            Informasi terkini seputar agenda akademik, prestasi santri, pengumuman yayasan, dan dinamika pembelajaran di SMA Islam Al-Madinah BSD.
        </p>
    </div>
</section>

<!-- Filter & Search Bar -->
<section class="bg-white border-b border-[#E7E3EA] py-3.5 sm:py-4 relative sm:sticky sm:top-20 z-20 shadow-xs">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
            <!-- Categories Pills (Mobile Swipeable) -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1.5 md:pb-0 scrollbar-none text-xs -mx-4 px-4 sm:mx-0 sm:px-0">
                <a href="{{ route('news') }}" 
                   class="px-3.5 sm:px-4 py-1.5 sm:py-2 rounded-full font-bold transition-all whitespace-nowrap shrink-0 {{ !request('kategori') ? 'bg-[#9377AD] text-white shadow-sm' : 'bg-[#FAF8FC] text-[#66676B] border border-[#E7E3EA] hover:border-[#9377AD] hover:text-[#684681]' }}">
                    Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('news', ['kategori' => $cat->slug, 'q' => request('q')]) }}" 
                       class="px-3.5 sm:px-4 py-1.5 sm:py-2 rounded-full font-bold transition-all whitespace-nowrap shrink-0 {{ request('kategori') === $cat->slug ? 'bg-[#9377AD] text-white shadow-sm' : 'bg-[#FAF8FC] text-[#66676B] border border-[#E7E3EA] hover:border-[#9377AD] hover:text-[#684681]' }}">
                        {{ ucfirst($cat->name) }} ({{ $cat->posts_count }})
                    </a>
                @endforeach
            </div>

            <!-- Search Form -->
            <form action="{{ route('news') }}" method="GET" class="relative w-full md:max-w-xs shrink-0">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <input type="text" 
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari berita atau artikel..." 
                       class="w-full px-4 py-2 pr-10 rounded-full border border-[#E7E3EA] text-xs text-[#202124] placeholder-[#66676B]/60 focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                <button type="submit" class="absolute right-3 top-2.5 text-[#66676B] hover:text-[#9377AD] transition-colors" title="Cari">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Content Grid -->
<section class="py-12 sm:py-16 bg-[#FAF9FB]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10">
        
        @if(request('q') || request('kategori'))
            <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-[#66676B] pb-3 border-b border-[#E7E3EA]">
                <span>
                    Menampilkan hasil untuk: 
                    @if(request('q')) <strong class="text-[#202124]">"{{ request('q') }}"</strong> @endif
                    @if(request('kategori')) (Kategori: <strong class="text-[#9377AD]">{{ ucfirst(request('kategori')) }}</strong>) @endif
                </span>
                <a href="{{ route('news') }}" class="text-[#9377AD] font-bold hover:underline inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>Reset Filter</span>
                </a>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-7">
            @forelse ($posts as $item)
                @php
                    $catName = $item->categories->first()?->name ?? 'Warta';
                    $imgSrc = $item->featured_image 
                        ? asset('storage/' . $item->featured_image) 
                        : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80';
                    $itemUrl = route('news.show', $item->slug ?: $item->id);
                    $dateStr = $item->published_at?->translatedFormat('d F Y') ?? $item->created_at?->translatedFormat('d F Y');
                    $authorStr = $item->author?->name ?? 'Humas';
                    $excerptStr = $item->excerpt ?: Str::limit(strip_tags($item->content), 120);
                @endphp
                <article class="bg-white rounded-2xl border border-[#E7E3EA] overflow-hidden shadow-sm hover:shadow-lg hover:border-[#9377AD]/50 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="h-48 bg-[#FAF8FC] relative overflow-hidden">
                            <img src="{{ $imgSrc }}" 
                                 alt="{{ $item->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                 onerror="this.src='https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80'">
                            <span class="absolute top-3.5 left-3.5 bg-[#9377AD] text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">
                                {{ ucfirst($catName) }}
                            </span>
                        </div>
                        <div class="p-6 space-y-2.5">
                            <div class="flex items-center gap-3 text-[11px] text-[#66676B]">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3 h-3 text-[#9377AD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $dateStr }}</span>
                                </span>
                                <span>•</span>
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3 h-3 text-[#9377AD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    <span>{{ $authorStr }}</span>
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-[#202124] group-hover:text-[#9377AD] transition-colors leading-snug line-clamp-2">
                                <a href="{{ $itemUrl }}">
                                    {{ $item->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-[#66676B] leading-relaxed line-clamp-3">
                                {{ $excerptStr }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 pb-6 pt-2 border-t border-[#FAF8FC]">
                        <a href="{{ $itemUrl }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#9377AD] group-hover:text-[#684681] transition-colors">
                            <span>Baca Selengkapnya</span>
                            <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-16 px-4 bg-white rounded-2xl border border-[#E7E3EA] space-y-3">
                    <div class="w-14 h-14 mx-auto rounded-full bg-[#F4F0F7] flex items-center justify-center text-[#9377AD]">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-[#202124]">Belum Ada Berita yang Sesuai</h3>
                    <p class="text-xs text-[#66676B] max-w-sm mx-auto">
                        Silakan kembali lagi nanti atau cari artikel dengan kata kunci yang berbeda.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('news') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#9377AD] text-white text-xs font-bold hover:bg-[#796092] transition-all shadow-sm">
                            Lihat Semua Berita
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if (method_exists($posts, 'hasPages') && $posts->hasPages())
            <div class="pt-8 border-t border-[#E7E3EA] flex justify-center">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
