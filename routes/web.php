<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\PpdbDocumentController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [PublicPageController::class, 'about'])->name('about');
Route::get('/program', [PublicPageController::class, 'programs'])->name('programs');
Route::get('/prestasi', [PublicPageController::class, 'achievements'])->name('achievements');
Route::get('/galeri', [PublicPageController::class, 'gallery'])->name('gallery');
Route::get('/berita', [PublicPageController::class, 'news'])->name('news');
Route::get('/berita/{slug}', [PublicPageController::class, 'newsDetail'])->name('news.show');

/*
|--------------------------------------------------------------------------
| PPDB Online Routes
|--------------------------------------------------------------------------
*/
Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');
Route::post('/ppdb', [PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/sukses/{number}', [PpdbController::class, 'success'])->name('ppdb.success');
Route::get('/ppdb/cek-status', [PpdbController::class, 'checkStatus'])->name('ppdb.check-status');

/*
|--------------------------------------------------------------------------
| Unduh Dokumen Sekolah (Brosur & Biaya PPDB)
|--------------------------------------------------------------------------
*/
Route::get('/brosur', function () {
    $profile = \App\Models\SchoolProfile::first();
    if (! empty($profile?->brochure_file) && Storage::disk('public')->exists($profile->brochure_file)) {
        return Storage::disk('public')->download(
            $profile->brochure_file,
            'Brosur-PPDB-' . \Illuminate\Support\Str::slug($profile->name ?? 'SMA-Al-Madinah') . '.' . pathinfo($profile->brochure_file, PATHINFO_EXTENSION)
        );
    }
    return redirect()->route('home')->with('info', 'Brosur digital sedang dipersiapkan oleh Panitia PPDB.');
})->name('school.brochure');

Route::get('/biaya-ppdb', function () {
    $profile = \App\Models\SchoolProfile::first();
    if (! empty($profile?->ppdb_fee_file) && Storage::disk('public')->exists($profile->ppdb_fee_file)) {
        return Storage::disk('public')->download(
            $profile->ppdb_fee_file,
            'Rincian-Biaya-PPDB-' . \Illuminate\Support\Str::slug($profile->name ?? 'SMA-Al-Madinah') . '.' . pathinfo($profile->ppdb_fee_file, PATHINFO_EXTENSION)
        );
    }
    return redirect()->route('home')->with('info', 'Rincian biaya sedang dipersiapkan oleh Panitia PPDB.');
})->name('school.fee');

/*
|--------------------------------------------------------------------------
| SEO & Search Engine Optimization (Sitemap & Robots)
|--------------------------------------------------------------------------
*/
Route::get('/robots.txt', function () {
    $sitemapUrl = url('/sitemap.xml');
    $content = "User-agent: *\n";
    $content .= "Allow: /\n";
    $content .= "Disallow: /admin/\n";
    $content .= "Disallow: /livewire/\n";
    $content .= "Disallow: /secure-files/\n\n";
    $content .= "Sitemap: {$sitemapUrl}\n";

    return response($content, 200, ['Content-Type' => 'text/plain; charset=utf-8']);
});

Route::get('/sitemap.xml', function () {
    $schoolProfile = \App\Models\SchoolProfile::first();
    $posts = collect();

    if (\Illuminate\Support\Facades\Schema::hasTable('tallcms_posts')) {
        $posts = \TallCms\Cms\Models\CmsPost::published()->latest('published_at')->get();
    }

    $staticRoutes = [
        ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => now()->toAtomString()],
        ['url' => route('about'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => ($schoolProfile?->updated_at ?? now())->toAtomString()],
        ['url' => route('programs'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()->toAtomString()],
        ['url' => route('ppdb.index'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->toAtomString()],
        ['url' => route('achievements'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()->toAtomString()],
        ['url' => route('gallery'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()->toAtomString()],
        ['url' => route('news'), 'priority' => '0.8', 'changefreq' => 'daily', 'lastmod' => now()->toAtomString()],
        ['url' => route('ppdb.check-status'), 'priority' => '0.6', 'changefreq' => 'daily', 'lastmod' => now()->toAtomString()],
    ];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

    foreach ($staticRoutes as $r) {
        $xml .= "    <url>\n";
        $xml .= "        <loc>" . htmlspecialchars($r['url']) . "</loc>\n";
        $xml .= "        <lastmod>" . $r['lastmod'] . "</lastmod>\n";
        $xml .= "        <changefreq>" . $r['changefreq'] . "</changefreq>\n";
        $xml .= "        <priority>" . $r['priority'] . "</priority>\n";
        $xml .= "    </url>\n";
    }

    foreach ($posts as $post) {
        $locale = config('app.locale', 'en');
        $slug = is_array($post->slug) ? ($post->slug[$locale] ?? reset($post->slug)) : $post->slug;
        $postUrl = route('news.show', ['slug' => $slug ?: $post->id]);
        $lastmod = ($post->updated_at ?? $post->published_at ?? now())->toAtomString();

        $xml .= "    <url>\n";
        $xml .= "        <loc>" . htmlspecialchars($postUrl) . "</loc>\n";
        $xml .= "        <lastmod>" . $lastmod . "</lastmod>\n";
        $xml .= "        <changefreq>weekly</changefreq>\n";
        $xml .= "        <priority>0.7</priority>\n";
        if (!empty($post->featured_image)) {
            $imgUrl = asset('storage/' . $post->featured_image);
            $xml .= "        <image:image>\n";
            $xml .= "            <image:loc>" . htmlspecialchars($imgUrl) . "</image:loc>\n";
            $xml .= "            <image:title>" . htmlspecialchars($post->title) . "</image:title>\n";
            $xml .= "        </image:image>\n";
        }
        $xml .= "    </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
});

/*
|--------------------------------------------------------------------------
| Auth & Admin Redirects
|--------------------------------------------------------------------------
*/
Route::redirect('/login', '/admin/login')->name('login');

Route::middleware(['auth'])->group(function () {
    // 1. Direct document viewer for PPDB Registrations
    Route::get('/admin/ppdb-registrations/{registration}/document/{field}', [PpdbDocumentController::class, 'show'])
        ->name('admin.ppdb.document');

    // 2. Signed temporary URL viewer for Filament form file uploads on local disk
    Route::get('/secure-files/{path}', function (Request $request, string $path) {
        if (! $request->hasValidSignature()) {
            abort(403, 'Tautan berkas tidak valid atau telah kedaluwarsa.');
        }

        if (! Storage::disk('local')->exists($path)) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        $fullPath = Storage::disk('local')->path($path);
        $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, private',
        ]);
    })->where('path', '.*')->name('secure.private.file');
});
