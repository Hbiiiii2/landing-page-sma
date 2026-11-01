<?php

namespace App\Providers;

use App\Models\PpdbSetting;
use App\Models\SchoolProfile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Safeguard for HTML sanitization on PHP < 8.4 when symfony/html-sanitizer v8 is loaded.
        // Symfony 8's NativeParser relies on \Dom\HTMLDocument which was added in PHP 8.4.
        // Without this fallback, Filament notifications crash with HTTP 500 when rendering on PHP 8.3.
        if (! class_exists(\Dom\HTMLDocument::class)) {
            $this->app->scoped(
                HtmlSanitizerInterface::class,
                fn () => new class implements HtmlSanitizerInterface {
                    public function sanitize(string $input): string
                    {
                        return strip_tags($input, ['b', 'strong', 'i', 'em', 'u', 'a', 'p', 'span', 'br', 'svg', 'path', 'div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'small']);
                    }

                    public function sanitizeFor(string $element, string $input): string
                    {
                        return $this->sanitize($input);
                    }
                }
            );

            Str::macro('sanitizeHtml', function (string $html): string {
                return strip_tags($html, ['b', 'strong', 'i', 'em', 'u', 'a', 'p', 'span', 'br', 'svg', 'path', 'div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'small']);
            });
        }

        // Force HTTPS only behind reverse proxy (Cloudflare) or in production when NOT on localhost
        $isLocalhost = in_array(request()->getHost(), ['localhost', '127.0.0.1', '::1']);
        if (request()->header('X-Forwarded-Proto') === 'https' || (app()->environment('production') && !$isLocalhost)) {
            URL::forceScheme('https');
        }

        // Dynamically align public storage URL with current request host and scheme to avoid CORS and mixed-content issues in Filament FileUpload
        if (! $this->app->runningInConsole()) {
            config(['filesystems.disks.public.url' => asset('storage')]);
        }

        // Configure default public disk for all Filament FileUpload components
        \Filament\Forms\Components\FileUpload::configureUsing(function (\Filament\Forms\Components\FileUpload $fileUpload) {
            $fileUpload->disk('public')->visibility('public');
        });

        // Always generate root-relative URLs for Vite assets (/build/assets/...)
        // This guarantees CSS/JS load seamlessly across localhost, IP, custom ports, and production HTTPS
        Vite::createAssetPathsUsing(fn ($path) => '/' . ltrim($path, '/'));

        Storage::disk('local')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
            return URL::temporarySignedRoute(
                'secure.private.file',
                $expiration,
                ['path' => $path]
            );
        });

        // Share schoolProfile and ppdbSetting to public views and components with safe fallback
        View::composer(['layouts.public', 'components.public.*'], function ($view) {
            $profile = null;
            $ppdbSetting = null;

            try {
                if (Schema::hasTable('school_profiles')) {
                    $profile = SchoolProfile::first();
                }
                if (Schema::hasTable('ppdb_settings')) {
                    $ppdbSetting = PpdbSetting::where('is_active', true)->latest()->first();
                }
            } catch (\Throwable $e) {
                // Graceful fallback if database is unavailable or migrating
            }

            $view->with([
                'schoolProfile' => $profile,
                'profile' => $profile,
                'ppdbSetting' => $ppdbSetting,
            ]);
        });
    }
}
