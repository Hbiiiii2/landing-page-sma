<?php

namespace Tests\Feature;

use App\Models\SchoolProfile;
use Tests\TestCase;

class SocialMediaEmbedTest extends TestCase
{
    public function test_home_page_displays_video_profil_and_instagram_section(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="video-profil"', false);
        $response->assertSee('Video Profil SMA Al-Madinah');
        $response->assertSee('Instagram Resmi');
        $response->assertSee('Buka Channel YouTube');
        $response->assertSee('Lihat Instagram');
    }

    public function test_youtube_video_embed_url_parsing_and_rendering(): void
    {
        $profile = SchoolProfile::first();
        if (!$profile) {
            $profile = SchoolProfile::current();
        }

        // Test standard watch URL
        $profile->update([
            'youtube_embed' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $this->assertEquals('dQw4w9WgXcQ', $profile->getYoutubeVideoId());
        $this->assertStringContainsString('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', $profile->youtube_embed_url);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', false);

        // Test short URL (youtu.be)
        $profile->update([
            'youtube_embed' => 'https://youtu.be/abcdef12345',
        ]);
        $this->assertEquals('abcdef12345', $profile->getYoutubeVideoId());
        $this->assertStringContainsString('https://www.youtube-nocookie.com/embed/abcdef12345', $profile->youtube_embed_url);
    }

    public function test_instagram_post_embed_rendering(): void
    {
        $profile = SchoolProfile::first();
        if (!$profile) {
            $profile = SchoolProfile::current();
        }

        // Test Instagram post URL
        $profile->update([
            'instagram_embed' => 'https://www.instagram.com/p/DB123456789/',
        ]);

        $this->assertTrue($profile->hasInstagramEmbed());
        $this->assertStringContainsString('data-instgrm-permalink="https://www.instagram.com/p/DB123456789/"', $profile->getInstagramEmbedHtml());

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('data-instgrm-permalink="https://www.instagram.com/p/DB123456789/"', false);
        $response->assertSee('//www.instagram.com/embed.js', false);
    }

    public function test_instagram_raw_blockquote_embed(): void
    {
        $profile = SchoolProfile::first();
        if (!$profile) {
            $profile = SchoolProfile::current();
        }

        $rawBlockquote = '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/CUSTOMPOST/"></blockquote>';
        $profile->update([
            'instagram_embed' => $rawBlockquote,
        ]);

        $this->assertEquals($rawBlockquote, $profile->getInstagramEmbedHtml());

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('data-instgrm-permalink="https://www.instagram.com/p/CUSTOMPOST/"', false);
    }

    public function test_hero_video_button_links_to_video_profil_anchor(): void
    {
        $profile = SchoolProfile::first();
        if (!$profile) {
            $profile = SchoolProfile::current();
        }

        $profile->update([
            'youtube_embed' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('href="#video-profil"', false);
    }
}
