@extends('layouts.public')

@section('title', ($post->title ?? 'Berita') . ' — SMA Islam Al-Madinah BSD')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 160))
@section('og_type', 'article')
@section('og_title', ($post->title ?? 'Berita') . ' — SMA Islam Al-Madinah BSD')
@section('og_description', \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 160))
@section('og_image', !empty($post->featured_image) ? asset('storage/' . $post->featured_image) : asset('images/banner-almadinah.png'))

@push('schema')
@php
    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'headline' => $post->title ?? 'Berita',
        'image' => [
            !empty($post->featured_image) ? asset('storage/' . $post->featured_image) : asset('images/banner-almadinah.png')
        ],
        'datePublished' => ($post->published_at ?? $post->created_at ?? now())->toAtomString(),
        'dateModified' => ($post->updated_at ?? $post->published_at ?? now())->toAtomString(),
        'author' => [
            '@type' => 'Person',
            'name' => $post->author?->name ?? 'Humas SMA Islam Al-Madinah BSD',
        ],
        'publisher' => [
            '@type' => 'School',
            'name' => 'SMA Islam Al-Madinah BSD',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/logo-almadinah.png'),
            ],
        ],
        'description' => \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 160),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')
@php
    $catName = $post->categories->first()?->name ?? 'Warta Sekolah';
    $imgSrc = $post->featured_image 
        ? asset('storage/' . $post->featured_image) 
        : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=900&q=80';
    $dateStr = $post->published_at?->translatedFormat('d F Y') ?? $post->created_at?->translatedFormat('d F Y');
    $authorName = $post->author?->name ?? 'Humas SMA Islam Al-Madinah BSD';
@endphp

<!-- Breadcrumb bar -->
<div class="bg-white border-b border-[#E7E3EA] py-2.5 sm:py-3 text-xs">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-1.5 sm:gap-2 text-[#66676B] overflow-x-auto whitespace-nowrap scrollbar-none">
        <a href="{{ url('/') }}" class="hover:text-[#9377AD] transition-colors shrink-0">Beranda</a>
        <span class="shrink-0">/</span>
        <a href="{{ route('news') }}" class="hover:text-[#9377AD] transition-colors shrink-0">Berita</a>
        <span class="shrink-0">/</span>
        <span class="text-[#202124] font-medium truncate max-w-[180px] sm:max-w-md">{{ $post->title }}</span>
    </div>
</div>

<section class="py-10 sm:py-12 lg:py-16 bg-[#FAF9FB]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Main Content (8 cols) -->
            <article class="lg:col-span-8 bg-white rounded-3xl border border-[#E7E3EA] p-4 sm:p-8 lg:p-10 shadow-sm space-y-6">
                <!-- Metadata -->
                <div class="space-y-3">
                    <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold bg-[#F4F0F7] text-[#684681] border border-[#E3D9EC] uppercase tracking-wider">
                        {{ ucfirst($catName) }}
                    </span>
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-black text-[#202124] leading-tight">
                        {{ $post->title }}
                    </h1>
                    <div class="text-xs text-[#66676B] flex flex-wrap items-center gap-2 sm:gap-3 pt-2 border-b border-[#E7E3EA] pb-4">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#9377AD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $dateStr }}</span>
                        </span>
                        <span>•</span>
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#9377AD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            <span>{{ $authorName }}</span>
                        </span>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="h-52 sm:h-80 md:h-96 rounded-2xl overflow-hidden bg-[#FAF8FC] border border-[#E7E3EA] shadow-inner">
                    <img src="{{ $imgSrc }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-full object-cover"
                         onerror="this.src='https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=900&q=80'">
                </div>

                <!-- Excerpt Lead (jika ada) -->
                @if(!empty($post->excerpt))
                    <div class="p-4 sm:p-5 bg-[#F4F0F7] rounded-2xl border border-[#E3D9EC] text-xs sm:text-sm font-medium text-[#4A3362] leading-relaxed italic">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <!-- Body Text -->
                <div class="text-sm sm:text-base text-[#202124] leading-relaxed space-y-4 font-normal [&>p]:mb-4 [&>ul]:list-disc [&>ul]:pl-5 [&>ol]:list-decimal [&>ol]:pl-5 [&>h2]:text-xl sm:[&>h2]:text-2xl [&>h2]:font-bold [&>h2]:text-[#684681] [&>h2]:mt-6 [&>h3]:text-lg [&>h3]:font-bold [&>h3]:text-[#202124] [&>h3]:mt-4 [&>blockquote]:border-l-4 [&>blockquote]:border-[#9377AD] [&>blockquote]:pl-4 [&>blockquote]:italic [&>blockquote]:text-[#66676B] [&>blockquote]:my-4 [&_img]:max-w-full [&_img]:h-auto [&_img]:rounded-xl [&_img]:mx-auto [&_table]:w-full [&_table]:overflow-x-auto [&_table]:block">
                    @if(method_exists($post, 'renderRichContentUnsafe'))
                        {!! $post->renderRichContentUnsafe('content') !!}
                    @else
                        {!! $post->content !!}
                    @endif
                </div>

                <!-- Back Link & Share -->
                <div class="pt-6 border-t border-[#E7E3EA] flex items-center justify-between">
                    <a href="{{ route('news') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#9377AD] hover:text-[#684681] transition-colors">
                        <span>&larr;</span>
                        <span>Kembali ke Daftar Berita</span>
                    </a>
                </div>
            </article>

            <!-- Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                <!-- Recent Posts -->
                <div class="bg-white rounded-2xl border border-[#E7E3EA] p-6 shadow-sm space-y-4">
                    <h3 class="text-xs font-bold text-[#684681] uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#9377AD]"></span>
                        <span>Berita Terkait Lainnya</span>
                    </h3>
                    <div class="space-y-4 divide-y divide-[#E7E3EA]">
                        @forelse ($recentPosts as $item)
                            @php
                                $itemUrl = route('news.show', $item->slug ?: $item->id);
                                $itemDate = $item->published_at?->translatedFormat('d F Y') ?? $item->created_at?->translatedFormat('d F Y');
                            @endphp
                            <div class="pt-3 first:pt-0 space-y-1">
                                <span class="inline-flex items-center gap-1 text-[10px] text-[#66676B]">
                                    <svg class="w-3 h-3 text-[#9377AD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $itemDate }}</span>
                                </span>
                                <h4 class="text-xs font-bold text-[#202124] hover:text-[#9377AD] transition-colors leading-snug">
                                    <a href="{{ $itemUrl }}">
                                        {{ $item->title }}
                                    </a>
                                </h4>
                            </div>
                        @empty
                            <p class="text-xs text-[#66676B]">Belum ada berita lainnya.</p>
                        @endforelse
                    </div>
                </div>

                <!-- PPDB Banner Card in Sidebar -->
                <div class="rounded-2xl bg-gradient-to-br from-[#3E2B52] via-[#543A70] to-[#704E94] text-white p-7 shadow-lg space-y-3.5 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-white/5 pointer-events-none"></div>
                    <span class="inline-block px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/10 text-emerald-200 border border-white/15">
                        PPDB 2027/2028
                    </span>
                    <h4 class="text-lg font-black leading-snug">
                        Penerimaan Santri Baru Telah Dibuka!
                    </h4>
                    <p class="text-xs text-white/80 leading-relaxed">
                        Kuota terbatas maksimal 24 siswa per rombel. Segera amankan kursi ananda bersama SMA Islam Al-Madinah BSD.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('ppdb.index') }}" 
                           class="inline-flex items-center justify-center w-full py-3 rounded-full bg-[#2A923F] hover:bg-[#217333] text-white text-center font-extrabold text-xs uppercase tracking-wider transition-all shadow-md">
                            Daftar PPDB Online Sekarang
                        </a>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>
@endsection
