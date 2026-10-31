<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Helper to get the single school profile record (singleton pattern)
     */
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'name' => 'SMA Al-Madinah',
            'accreditation' => 'A',
            'tagline' => 'Membentuk Generasi Berkarakter, Cerdas, dan Berakhlak Mulia',
            'statistic_students' => 350,
            'statistic_teachers' => 25,
            'statistic_achievements' => 48,
            'statistic_year_founded' => 2012,
        ]);
    }

    public function getBrochureUrlAttribute(): ?string
    {
        return !empty($this->brochure_file) ? asset('storage/' . $this->brochure_file) : null;
    }

    public function getPpdbFeeUrlAttribute(): ?string
    {
        return !empty($this->ppdb_fee_file) ? asset('storage/' . $this->ppdb_fee_file) : null;
    }

    public function isBrochurePdf(): bool
    {
        if (empty($this->brochure_file)) return false;
        return strtolower(pathinfo($this->brochure_file, PATHINFO_EXTENSION)) === 'pdf';
    }

    public function isPpdbFeePdf(): bool
    {
        if (empty($this->ppdb_fee_file)) return false;
        return strtolower(pathinfo($this->ppdb_fee_file, PATHINFO_EXTENSION)) === 'pdf';
    }

    /**
     * Extract 11-char YouTube video ID from various URL formats or iframe code
     */
    public function getYoutubeVideoId(): ?string
    {
        $raw = trim($this->youtube_embed ?: ($this->hero_video_url ?: ''));
        if (empty($raw)) {
            return null;
        }

        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $raw)) {
            return $raw;
        }

        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|shorts\/))([a-zA-Z0-9_-]{11})/i', $raw, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get clean embed URL for YouTube iframe player
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $videoId = $this->getYoutubeVideoId();
        if ($videoId) {
            return "https://www.youtube-nocookie.com/embed/{$videoId}?rel=0&modestbranding=1";
        }

        $raw = trim($this->youtube_embed ?: ($this->hero_video_url ?: ''));
        if (str_contains($raw, '<iframe') && preg_match('/src="([^"]+)"/i', $raw, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function hasYoutubeVideo(): bool
    {
        return !empty($this->youtube_video_id) || !empty($this->youtube_embed) || !empty($this->hero_video_url);
    }

    /**
     * Get HTML snippet for Instagram embed
     */
    public function getInstagramEmbedHtml(): ?string
    {
        $raw = trim($this->instagram_embed ?: '');
        if (empty($raw)) {
            return null;
        }

        if (str_contains($raw, '<blockquote') && str_contains($raw, 'instagram-media')) {
            return $raw;
        }

        if (preg_match('~https?://(?:www\.)?instagram\.com/(?:p|reel|tv)/([^/?&#]+)~i', $raw, $matches)) {
            $cleanUrl = 'https://www.instagram.com/p/' . $matches[1] . '/';
            return '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="' . e($cleanUrl) . '" data-instgrm-version="14" style="background:#FFF; border:0; border-radius:12px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 0 auto; max-width:540px; min-width:326px; padding:0; width:100%;"></blockquote>';
        }

        return null;
    }

    public function hasInstagramEmbed(): bool
    {
        return !empty($this->instagram_embed);
    }

    /**
     * Clean Instagram handle (e.g. smpalmadinah)
     */
    public function getInstagramHandleAttribute(): string
    {
        if (!empty($this->instagram_url)) {
            $path = parse_url($this->instagram_url, PHP_URL_PATH);
            $clean = trim($path ?: '', '/');
            if (!empty($clean)) {
                return $clean;
            }
        }
        return 'smpalmadinah';
    }

    /**
     * Sanitize phone number to international WhatsApp format (e.g. 6281234567890)
     */
    public static function sanitizePhone(?string $phone, string $default = '6281299887766'): string
    {
        if (empty($phone)) {
            return $default;
        }
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        } elseif (str_starts_with($clean, '8')) {
            $clean = '62' . $clean;
        }
        return !empty($clean) ? $clean : $default;
    }

    public function getWhatsappCleanAttribute(): string
    {
        return self::sanitizePhone($this->whatsapp, '6281299887766');
    }

    public function getWhatsappPpdbCleanAttribute(): string
    {
        if (!empty($this->whatsapp_ppdb)) {
            return self::sanitizePhone($this->whatsapp_ppdb, $this->whatsapp_clean);
        }
        return $this->whatsapp_clean;
    }

    /**
     * Generate dynamic WhatsApp URL respecting custom URL override and pre-filled message
     */
    public function buildWhatsappUrl(string $phoneClean, ?string $message = null): string
    {
        if (!empty($this->whatsapp_custom_url)) {
            $url = trim($this->whatsapp_custom_url);
            if (!preg_match('#^https?://#i', $url)) {
                $url = 'https://' . $url;
            }
            if (!empty($message) && (str_contains($url, 'wa.me') || str_contains($url, 'whatsapp.com')) && !str_contains($url, 'text=')) {
                $separator = str_contains($url, '?') ? '&' : '?';
                return $url . $separator . 'text=' . urlencode($message);
            }
            return $url;
        }

        $base = "https://wa.me/{$phoneClean}";
        return !empty($message) ? "{$base}?text=" . urlencode($message) : $base;
    }

    public function getWhatsappPanitiaUrlAttribute(): string
    {
        $school = $this->name ?? 'SMA Al-Madinah';
        $defaultMsg = "Assalamu'alaikum Panitia PPDB {$school}, saya ingin konsultasi mengenai Penerimaan Santri Baru (PPDB). Mohon informasinya. Terima kasih.";
        $msg = !empty($this->whatsapp_message_panitia) ? $this->whatsapp_message_panitia : $defaultMsg;
        return $this->buildWhatsappUrl($this->whatsapp_ppdb_clean, $msg);
    }

    public function getWhatsappBrosurUrlAttribute(): string
    {
        $school = $this->name ?? 'SMA Al-Madinah';
        $defaultMsg = "Assalamu'alaikum Panitia PPDB {$school}, saya ingin meminta berkas Brosur Resmi PPDB. Mohon dikirimkan. Terima kasih.";
        $msg = !empty($this->whatsapp_message_brosur) ? $this->whatsapp_message_brosur : $defaultMsg;
        return $this->buildWhatsappUrl($this->whatsapp_ppdb_clean, $msg);
    }

    public function getWhatsappBiayaUrlAttribute(): string
    {
        $school = $this->name ?? 'SMA Al-Madinah';
        $defaultMsg = "Assalamu'alaikum Panitia PPDB {$school}, saya ingin menanyakan rincian Biaya PPDB & SPP. Mohon informasinya. Terima kasih.";
        $msg = !empty($this->whatsapp_message_biaya) ? $this->whatsapp_message_biaya : $defaultMsg;
        return $this->buildWhatsappUrl($this->whatsapp_ppdb_clean, $msg);
    }

    public function getWhatsappFloatingUrlAttribute(): string
    {
        $school = $this->name ?? 'SMA Al-Madinah';
        $defaultMsg = "Assalamu'alaikum Admin {$school}, saya ingin bertanya informasi pendaftaran dan kegiatan sekolah.";
        $msg = !empty($this->whatsapp_message_floating) ? $this->whatsapp_message_floating : $defaultMsg;
        return $this->buildWhatsappUrl($this->whatsapp_clean, $msg);
    }

    public function getWhyChooseUsImageSrcAttribute(): string
    {
        if (!empty($this->why_choose_us_image)) {
            return asset('storage/' . $this->why_choose_us_image);
        }
        return 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=700&q=80';
    }

    public function getCtaCollageImage(int $index): string
    {
        $field = "cta_collage_image_{$index}";
        if (!empty($this->{$field})) {
            return asset('storage/' . $this->{$field});
        }

        $fallbacks = [
            1 => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=400&q=80',
            2 => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=400&q=80',
            3 => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=400&q=80',
            4 => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=400&q=80',
        ];

        return $fallbacks[$index] ?? $fallbacks[1];
    }
}

