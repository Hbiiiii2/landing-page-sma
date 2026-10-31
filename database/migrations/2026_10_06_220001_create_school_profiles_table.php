<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('SMA Al-Madinah');
            $table->string('npsn')->nullable();
            $table->string('accreditation')->default('A');
            $table->string('tagline')->nullable();
            $table->string('headmaster_name')->nullable();
            $table->string('headmaster_photo')->nullable();
            $table->text('headmaster_welcome')->nullable();
            $table->text('about')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->text('google_maps_embed')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_video_url')->nullable();
            $table->unsignedInteger('statistic_students')->default(350);
            $table->unsignedInteger('statistic_teachers')->default(25);
            $table->unsignedInteger('statistic_achievements')->default(48);
            $table->unsignedInteger('statistic_year_founded')->default(2012);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
