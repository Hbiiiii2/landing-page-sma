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
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique()->index();
            $table->string('academic_year')->default('2026/2027');

            // Data Calon Siswa
            $table->string('full_name');
            $table->string('nik')->nullable();
            $table->string('nisn')->nullable();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P'])->comment('L: Laki-laki, P: Perempuan');
            $table->string('religion')->default('Islam');
            $table->text('address');
            $table->string('student_phone')->nullable();
            $table->string('student_email')->nullable();
            $table->string('origin_school')->nullable(); // Asal SMP/MTs

            // Data Orang Tua
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_job')->nullable();
            $table->text('parent_address')->nullable();

            // Data Wali (Opsional)
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->text('guardian_address')->nullable();

            // Berkas Pelengkap (Dukungan PDF & Gambar)
            $table->string('family_card_file')->nullable()->comment('Kartu Keluarga (PDF/Gambar)');
            $table->string('birth_certificate_file')->nullable()->comment('Akta Kelahiran (PDF/Gambar)');
            $table->string('graduation_certificate_file')->nullable()->comment('Ijazah/SKL SMP (PDF/Gambar)');
            $table->string('student_photo_file')->nullable()->comment('Pas Foto Siswa (Gambar)');
            $table->string('achievement_certificate_file')->nullable()->comment('Piagam Prestasi (Opsional)');
            $table->json('additional_documents')->nullable()->comment('Berkas tambahan lainnya');

            // Status Verifikasi & Seleksi
            $table->enum('status', ['pending', 'verified', 'accepted', 'rejected'])->default('pending')->index();
            $table->text('verification_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
