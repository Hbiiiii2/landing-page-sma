<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\PpdbRegistration;
use App\Models\PpdbSetting;
use App\Models\SchoolEvent;
use App\Models\SchoolProfile;
use App\Models\SchoolProgram;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use TallCms\Cms\Models\CmsCategory;
use TallCms\Cms\Models\CmsPost;

class SchoolDataSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Pastikan Admin User Tersedia
        $admin = User::firstOrCreate([
            'email' => 'admin@smpalmadinah.sch.id',
        ], [
            'name' => 'Administrator SMA Al-Madinah',
            'slug' => 'administrator-sma-al-madinah',
            'job_title' => 'Tim Humas & IT',
            'company' => 'SMA Islam Al-Madinah BSD',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 1. Profil Sekolah (Akurat SMA Islam Al-Madinah BSD)
        SchoolProfile::updateOrCreate(['id' => 1], [
            'name' => 'SMA Islam Al-Madinah BSD',
            'npsn' => '20613809',
            'accreditation' => 'A (Unggul)',
            'tagline' => 'Mendidik dengan Adab, Membina dengan Ilmu, Menuju Generasi Rabbani Berwawasan Global',
            'headmaster_name' => 'H. Syaiful Bahri, M.Pd.I',
            'headmaster_welcome' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi SMA Islam Al-Madinah BSD. Di bawah naungan Yayasan Kerukunan Keluarga Muslim BSD (YKKM BSD), kami mendedikasikan diri untuk melahirkan generasi santri yang kokoh dalam akidah, mulia dalam akhlak, mutqin dalam hafalan Al-Qur\'an, serta unggul dalam literasi sains dan teknologi masa depan.',
            'about' => 'SMA Islam Al-Madinah BSD merupakan institusi pendidikan menengah atas unggulan di kawasan BSD City Tangerang Selatan. Memadukan kurikulum nasional merdeka dan kurikulum khas pesantren perkotaan dengan fokus pada adab Islami, tahfidz Al-Qur\'an 3 juz mutqin, program bilingual Arab-Inggris, dan riset sains teknologi modern.',
            'vision' => 'Terwujudnya Generasi Rabbani yang Berakhlakul Karimah, Unggul dalam Prestasi, Menguasai IPTEK, dan Berwawasan Global Berlandaskan Nilai-Nilai Al-Qur\'an.',
            'mission' => "1. Menumbuhkan penghayatan aqidah yang lurus dan pembiasaan ibadah berlandaskan adab Islami.\n2. Mengoptimalkan program tahfidz Al-Qur'an minimal 3 juz mutqin dengan bimbingan bersanad.\n3. Menyelenggarakan pembelajaran saintifik dan teknologi komputasi berbasis kurikulum modern.\n4. Membiasakan komunikasi aktif dwibahasa (Arab & Inggris) dalam pergaulan harian.\n5. Mengembangkan minat, bakat, kepemimpinan, dan kepedulian sosial santri.",
            'address' => 'Komplek BSD City Sektor XIV, Serpong, Kota Tangerang Selatan, Banten 15310',
            'phone' => '(021) 538-8888',
            'whatsapp' => '0812-9988-7766',
            'email' => 'info@smpalmadinah.sch.id',
            'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8016482813137!2d106.6806782!3d-6.3028731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fb7a2c56d787%3A0xe543596706903737!2sSMP%20Al%20Madinah%20Islamic%20Center%20KKMB!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'instagram_url' => 'https://www.instagram.com/amickkmb.perguruan',
            'youtube_url' => 'https://www.youtube.com/@SMP-SMAAl-MadinahIslamicCenter',
            'facebook_url' => 'https://facebook.com/smpalmadinah',
            'statistic_students' => 380,
            'statistic_teachers' => 28,
            'statistic_achievements' => 65,
            'statistic_year_founded' => 2004,
            'hero_badge_title' => 'Santri Berprestasi',
            'hero_badge_subtitle' => 'Tahfidz Al-Qur\'an & Sains Modern',
            'hero_badge_tag' => 'Mumtaz',
        ]);

        // 2. Setting PPDB Kuota Realtime 2027/2028
        PpdbSetting::updateOrCreate(['id' => 1], [
            'academic_year' => '2027/2028',
            'total_quota' => 120,
            'is_active' => true,
            'registration_start_date' => now()->subDays(15)->toDateString(),
            'registration_end_date' => now()->addMonths(4)->toDateString(),
            'announcement_date' => now()->addMonths(5)->toDateString(),
            'registration_fee' => 350000,
            'contact_person' => 'Panitia PPDB Al-Madinah BSD',
            'contact_whatsapp' => '081299887766',
            'terms_and_conditions' => "1. Mengisi formulir pendaftaran online secara lengkap dan benar.\n2. Mengunggah dokumen: Kartu Keluarga (KK), Akta Kelahiran, dan Pas Foto terbaru calon santri.\n3. Mengunggah piagam/sertifikat prestasi atau tahfidz (opsional bagi jalur prestasi).\n4. Mengikuti tes pemetaan potensi santri dan wawancara komitmen orang tua.",
        ]);

        // 3. Contoh Pendaftar PPDB (Realistis)
        $registrations = [
            [
                'registration_number' => 'REG-2027-0001',
                'academic_year' => '2027/2028',
                'full_name' => 'Muhammad Fatih Rayhan',
                'nik' => '3674011205120001',
                'nisn' => '0098765432',
                'birth_place' => 'Tangerang Selatan',
                'birth_date' => '2014-05-12',
                'gender' => 'L',
                'religion' => 'Islam',
                'address' => 'BSD City Sektor 1.2 Blok B No. 15, Serpong, Tangerang Selatan',
                'student_phone' => '081299112233',
                'student_email' => 'fatih.rayhan@gmail.com',
                'origin_school' => 'SMP Islam Al-Azhar BSD',
                'parent_name' => 'H. Agus Pratama, S.T.',
                'parent_phone' => '081299887766',
                'parent_job' => 'Wiraswasta',
                'status' => 'verified',
                'verification_notes' => 'Berkas lengkap dan terverifikasi. Jadwal observasi: Sabtu, 15 November 2026.',
                'verified_at' => now()->subDays(5),
            ],
            [
                'registration_number' => 'REG-2027-0002',
                'academic_year' => '2027/2028',
                'full_name' => 'Aisyah Putri Azzahra',
                'nik' => '3674022408120002',
                'nisn' => '0098765433',
                'birth_place' => 'Jakarta Selatan',
                'birth_date' => '2014-08-24',
                'gender' => 'P',
                'religion' => 'Islam',
                'address' => 'Cluster Nusa Loka Sektor 14 BSD City, Tangerang Selatan',
                'student_phone' => '081388223344',
                'student_email' => 'aisyah.zahra@gmail.com',
                'origin_school' => 'SMPIT Al-Fath BSD',
                'parent_name' => 'Dr. H. Hendra Wijaya, Sp.A.',
                'parent_phone' => '081388776655',
                'parent_job' => 'Dokter Spesialis',
                'status' => 'accepted',
                'verification_notes' => 'LULUS Seleksi Observasi & Tahfidz. Selamat bergabung di keluarga besar SMA Al-Madinah BSD.',
                'verified_at' => now()->subDays(2),
            ],
            [
                'registration_number' => 'REG-2027-0003',
                'academic_year' => '2027/2028',
                'full_name' => 'Ahmad Dzaki Al-Ghifari',
                'nik' => '3674031003120003',
                'nisn' => '0098765434',
                'birth_place' => 'Tangerang',
                'birth_date' => '2014-03-10',
                'gender' => 'L',
                'religion' => 'Islam',
                'address' => 'Griya Loka Sektor 1.1 Blok E No. 8, Serpong',
                'student_phone' => '081577334455',
                'student_email' => 'dzaki.ghifari@gmail.com',
                'origin_school' => 'SMP Islam Cikal Harapan',
                'parent_name' => 'Ir. Muhammad Firdaus',
                'parent_phone' => '081577889900',
                'parent_job' => 'Pegawai Swasta',
                'status' => 'pending',
                'verification_notes' => null,
                'verified_at' => null,
            ],
            [
                'registration_number' => 'REG-2027-0004',
                'academic_year' => '2027/2028',
                'full_name' => 'Khansa Nabila Zahra',
                'nik' => '3674041709120004',
                'nisn' => '0098765435',
                'birth_place' => 'Tangerang Selatan',
                'birth_date' => '2014-09-17',
                'gender' => 'P',
                'religion' => 'Islam',
                'address' => 'De Latinos Cluster Carribean BSD City, Tangerang Selatan',
                'student_phone' => '081699445566',
                'student_email' => 'khansa.zahra@gmail.com',
                'origin_school' => 'SMPIT Insan Mandiri',
                'parent_name' => 'Dedi Gunawan, S.E.',
                'parent_phone' => '081699001122',
                'parent_job' => 'Manajer Keuangan',
                'status' => 'verified',
                'verification_notes' => 'Berkas terverifikasi. Jalur Prestasi Tahfidz 2 Juz.',
                'verified_at' => now()->subDay(),
            ],
        ];
        foreach ($registrations as $reg) {
            PpdbRegistration::updateOrCreate(['registration_number' => $reg['registration_number']], $reg);
        }

        // 4. Program Sekolah
        $programs = [
            [
                'name' => 'Program Tahfidz & Tartil Qur\'an',
                'slug' => 'program-tahfidz-quran',
                'category' => 'keagamaan',
                'summary' => 'Target hafalan minimal 3 Juz mutqin dengan sanad keilmuan dan tahsin terstandarisasi.',
                'description' => 'Program unggulan hafalan Al-Qur\'an intensif setiap pagi dibimbing asatidz bersanad, dilengkapi munaqasyah, tasmi\' akbar sekali duduk, dan pemahaman tafsir amali.',
                'order' => 1,
            ],
            [
                'name' => 'Kelas Bilingual & English Immersion',
                'slug' => 'kelas-bilingual-english',
                'category' => 'unggulan',
                'summary' => 'Pembiasaan komunikasi aktif bahasa Arab dan Inggris dalam aktivitas belajar serta interaksi harian.',
                'description' => 'Mempersiapkan santri bersaing di kancah global dengan kurikulum dual language, native speaker visit, public speaking practice, dan TOEFL Junior preparation.',
                'order' => 2,
            ],
            [
                'name' => 'Sains, Robotik & STEM Computing',
                'slug' => 'sains-robotik-coding',
                'category' => 'akademik',
                'summary' => 'Pengembangan logika komputasi, perakitan robot mikrokontroler, dan riset sains aplikatif.',
                'description' => 'Fasilitas smart science lab untuk memfasilitasi penelitian santri, eksperimen IoT, coding pemula, dan bimbingan Olimpiade Sains Nasional (OSN).',
                'order' => 3,
            ],
            [
                'name' => 'Pendidikan Adab & Karakter Rabbani',
                'slug' => 'karakter-mandiri-leadership',
                'category' => 'pengembangan_diri',
                'summary' => 'Pembinaan akhlak mulia, kemandirian santri, kepanduan Islam, dan kepemimpinan berintegritas.',
                'description' => 'Program pembiasaan adab keseharian (7 Sunnah Harian), leadership camp, field trip edukatif, dan kepedulian sosial untuk menumbuhkan empati umat.',
                'order' => 4,
            ],
        ];
        foreach ($programs as $prog) {
            SchoolProgram::updateOrCreate(['slug' => $prog['slug']], $prog);
        }

        // 5. Fasilitas Sekolah (Sesuai Sarana Aktual: Ruang Kelas, Mushola, Lab Komputer, Aula)
        $facilities = [
            [
                'name' => 'Ruang Kelas',
                'slug' => 'ruang-kelas',
                'category' => 'Akademik',
                'description' => 'Ruang kelas ber-AC yang nyaman, bersih, dan representatif dengan rasio ideal maksimal 24 siswa per rombel, dilengkapi proyektor multimedia, pencahayaan ergonomis, dan sarana belajar interaktif untuk mendukung proses pembelajaran efektif.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Mushola',
                'slug' => 'mushola',
                'category' => 'Ibadah',
                'description' => 'Sarana ibadah yang bersih, nyaman, dan sejuk untuk pembiasaan shalat fardhu berjamaah, shalat dhuha, halaqah tahfidz Al-Qur\'an, dzikir pagi-petang, serta pembinaan adab santri.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Lab Komputer',
                'slug' => 'lab-komputer',
                'category' => 'Teknologi & Sains',
                'description' => 'Laboratorium komputer ber-AC dengan unit PC modern dan akses internet fiber optic berkecepatan tinggi untuk pembelajaran TIK, literasi digital, Computer Based Test (CBT), serta pelatihan coding dan robotik.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Aula',
                'slug' => 'aula',
                'category' => 'Serbaguna & Pertemuan',
                'description' => 'Aula serbaguna dengan tata suara dan pendingin udara yang memadai untuk kegiatan wisuda tahfidz, seminar parenting, pertemuan komite wali murid, unjuk kreasi seni santri, dan kajian keislaman.',
                'order' => 4,
                'is_active' => true,
            ],
        ];
        // Hapus fasilitas lama agar data bersih sesuai sarana aktual
        Facility::truncate();
        foreach ($facilities as $fac) {
            Facility::updateOrCreate(['slug' => $fac['slug']], $fac);
        }

        // 6. Ekstrakurikuler
        $extracurriculars = [
            [
                'name' => 'Pramuka Al-Madinah Scouts',
                'slug' => 'pramuka-scouts',
                'category' => 'wajib',
                'coach_name' => 'Kak Dimas Pratama, S.Pd.',
                'schedule' => 'Jumat, 14.00 - 16.00 WIB',
                'description' => 'Pembinaan kedisiplinan, survival, ketangkasan, dan kepemimpinan berlandaskan Dasa Darma dan nilai-nilai Islam.',
                'order' => 1,
            ],
            [
                'name' => 'Klub Tahfidz & Munaqasyah Qur\'an',
                'slug' => 'klub-tahfidz-quran',
                'category' => 'keagamaan',
                'coach_name' => 'Ust. Ahmad Fauzan, Lc.',
                'schedule' => 'Senin & Rabu, 15.30 - 17.00 WIB',
                'description' => 'Bimbingan intensif akselerasi hafalan 3-5 juz mutqin, perbaikan makharijul huruf, dan persiapan lomba MHQ.',
                'order' => 2,
            ],
            [
                'name' => 'Robotics, Coding & STEM Club',
                'slug' => 'robotics-stem',
                'category' => 'sains',
                'coach_name' => 'Budi Santoso, S.Si., M.Kom.',
                'schedule' => 'Sabtu, 09.00 - 11.30 WIB',
                'description' => 'Eksperimen merakit robot micro-controller Arduino, sensor otomasi, coding logika, dan persiapan kontes robotik nasional.',
                'order' => 3,
            ],
            [
                'name' => 'Futsal & Football Academy',
                'slug' => 'futsal-academy',
                'category' => 'olahraga',
                'coach_name' => 'Coach Danang Setiawan',
                'schedule' => 'Sabtu, 07.30 - 09.30 WIB',
                'description' => 'Pelatihan teknik dasar, fisik prima, kerjasama tim, dan sportivitas bertanding di kejuaraan tingkat pelajar.',
                'order' => 4,
            ],
            [
                'name' => 'Panahan Tradisional (Archery Sunnah)',
                'slug' => 'panahan-archery',
                'category' => 'olahraga',
                'coach_name' => 'Ust. Hamzah Al-Bantani',
                'schedule' => 'Ahad, 08.00 - 10.00 WIB',
                'description' => 'Olahraga sunnah yang melatih fokus tingkat tinggi, ketenangan emosi, dan kekuatan fisik santri.',
                'order' => 5,
            ],
            [
                'name' => 'Palang Merah Remaja (PMR & UKS)',
                'slug' => 'pmr-uks-madinah',
                'category' => 'pengembangan_diri',
                'coach_name' => 'dr. Nabila Rahmawati',
                'schedule' => 'Kamis, 15.30 - 17.00 WIB',
                'description' => 'Pelatihan pertolongan pertama pada kecelakaan (P3K), kesiapsiagaan bencana, dan kepedulian kemanusiaan.',
                'order' => 6,
            ],
            [
                'name' => 'English & Arabic Public Speaking',
                'slug' => 'speech-club',
                'category' => 'bahasa',
                'coach_name' => 'Sarah Amalia, S.Pd., M.Ed.',
                'schedule' => 'Selasa, 15.30 - 17.00 WIB',
                'description' => 'Latihan pidato dwibahasa, debat santri, dan storytelling untuk membangun rasa percaya diri di podium.',
                'order' => 7,
            ],
            [
                'name' => 'Desain Grafis & Multimedia Kreatif',
                'slug' => 'multimedia-kreatif',
                'category' => 'seni',
                'coach_name' => 'Rian Hidayat, S.Ds.',
                'schedule' => 'Sabtu, 13.00 - 15.00 WIB',
                'description' => 'Pemanfaatan software grafis dan fotografi untuk pembuatan karya media dakwah kreatif santri.',
                'order' => 8,
            ],
        ];
        foreach ($extracurriculars as $ekskul) {
            Extracurricular::updateOrCreate(['slug' => $ekskul['slug']], $ekskul);
        }

        // 7. Prestasi Santri (Achievements)
        $achievements = [
            [
                'title' => 'Juara 1 Musabaqah Hifdzil Qur\'an (MHQ) 5 Juz Tingkat Nasional',
                'student_name' => 'Aisyah Nailah Az-Zahra',
                'category' => 'keagamaan',
                'level' => 'nasional',
                'rank' => 'Juara 1 (Medali Emas)',
                'year' => 2026,
                'organizer' => 'Kementerian Agama Republik Indonesia',
                'description' => 'Meraih nilai sempurna tajwid, fasohah, dan kelancaran hafalan 5 juz pada ajang festival santri nasional.',
                'is_featured' => true,
            ],
            [
                'title' => 'Medali Emas Olimpiade Sains Nasional (OSN) Matematika',
                'student_name' => 'Muhammad Rayyan Zhafir',
                'category' => 'akademik',
                'level' => 'provinsi',
                'rank' => 'Juara 1 (Medali Emas)',
                'year' => 2026,
                'organizer' => 'Pusat Prestasi Nasional (Puspresnas) Kemendikbudristek',
                'description' => 'Meraih medali emas tingkat provinsi Banten dan melaju mewakili provinsi pada kompetisi OSN tingkat nasional.',
                'is_featured' => true,
            ],
            [
                'title' => 'Juara 1 National Youth Robotics Competition (Kategori Maze Solving)',
                'student_name' => 'Tim Robotic Al-Madinah (Faris & Daffa)',
                'category' => 'sains',
                'level' => 'nasional',
                'rank' => 'Gold Medal',
                'year' => 2025,
                'organizer' => 'Indonesian Robotic Association',
                'description' => 'Mencatat waktu tercepat dan algoritma navigasi sensor paling presisi dalam ajang kompetisi robot pelajar.',
                'is_featured' => true,
            ],
            [
                'title' => 'Juara Umum Kejuaraan Futsal Pelajar SMA Se-Tangerang Selatan',
                'student_name' => 'Tim Futsal SMA Islam Al-Madinah BSD',
                'category' => 'olahraga',
                'level' => 'kabupaten',
                'rank' => 'Juara 1 Umum',
                'year' => 2025,
                'organizer' => 'Dispora Kota Tangerang Selatan',
                'description' => 'Menjuarai turnamen tahunan antar-SMA se-Tangerang Selatan dengan rekor tak terkalahkan di babak penyisihan.',
                'is_featured' => false,
            ],
            [
                'title' => 'Juara 1 English Speech Contest Islamic School Forum Banten',
                'student_name' => 'Nabila Salsabila Putri',
                'category' => 'bahasa',
                'level' => 'provinsi',
                'rank' => 'Juara 1',
                'year' => 2025,
                'organizer' => 'Badan Koordinasi Sekolah Islam Banten',
                'description' => 'Membawakan orasi bertema "The Role of Muslim Youth in Global Era" dengan penguasaan panggung yang mengagumkan.',
                'is_featured' => false,
            ],
            [
                'title' => 'Juara 2 Kejuaraan Panahan Tradisional Junior Horsebow Banten',
                'student_name' => 'Faris Al-Ghifari',
                'category' => 'olahraga',
                'level' => 'provinsi',
                'rank' => 'Juara 2 (Medali Perak)',
                'year' => 2025,
                'organizer' => 'Persatuan Panahan Tradisional Indonesia (Perpatri)',
                'description' => 'Meraih akumulasi poin tertinggi pada nomor target dinamis jarak 25 meter kategori junior.',
                'is_featured' => false,
            ],
        ];
        foreach ($achievements as $ach) {
            Achievement::updateOrCreate(['title' => $ach['title']], $ach);
        }

        // 8. Dewan Guru & Tenaga Pendidik
        $teachers = [
            [
                'name' => 'H. Syaiful Bahri, M.Pd.I',
                'nip' => '197805122005011002',
                'role' => 'Kepala Sekolah',
                'subject' => 'Manajemen Pendidikan & Adab',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=500&q=80',
                'education' => 'S2 Manajemen Pendidikan Islam (UIN Syarif Hidayatullah)',
                'order' => 1,
            ],
            [
                'name' => 'Dra. Hj. Siti Maryam, M.Pd.',
                'nip' => '198203152008022001',
                'role' => 'Wakil Kepala Bid. Kurikulum',
                'subject' => 'Matematika Terapan',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80',
                'education' => 'S2 Pendidikan Matematika (Universitas Negeri Jakarta)',
                'order' => 2,
            ],
            [
                'name' => 'Ust. Ahmad Fauzan, Lc., M.Ag.',
                'nip' => '198609202010011003',
                'role' => 'Koordinator Tahfidz & Keislaman',
                'subject' => 'Pendidikan Agama Islam & Tahsin',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=500&q=80',
                'education' => 'S1 Al-Azhar Kairo, S2 Ilmu Al-Qur\'an dan Tafsir',
                'order' => 3,
            ],
            [
                'name' => 'Budi Santoso, S.Si., M.Kom.',
                'nip' => '199011042015031004',
                'role' => 'Guru IPA & Pembina Robotik',
                'subject' => 'IPA Terpadu & Informatika',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=500&q=80',
                'education' => 'S2 Ilmu Komputer (Institut Pertanian Bogor)',
                'order' => 4,
            ],
            [
                'name' => 'Sarah Amalia, S.Pd., M.Ed.',
                'nip' => '199207182018022005',
                'role' => 'Koordinator Program Bilingual',
                'subject' => 'Bahasa Inggris & Public Speaking',
                'photo' => 'https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=500&q=80',
                'education' => 'Master of Education (Monash University)',
                'order' => 5,
            ],
            [
                'name' => 'Muhammad Ridwan, S.Psi., M.A.',
                'nip' => '199104082019011006',
                'role' => 'Guru Bimbingan Konseling & Karakter',
                'subject' => 'Psikologi Perkembangan Santri',
                'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=500&q=80',
                'education' => 'S2 Psikologi Pendidikan (Universitas Indonesia)',
                'order' => 6,
            ],
        ];
        foreach ($teachers as $teacher) {
            Teacher::updateOrCreate(['name' => $teacher['name']], $teacher);
        }

        // 9. TallCMS Categories (Kategori Berita Lengkap)
        $categoriesData = [
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'color' => '#EC4899', 'order' => 1],
            ['name' => 'Warta Sekolah', 'slug' => 'warta-sekolah', 'color' => '#2A923F', 'order' => 2],
            ['name' => 'Akademik', 'slug' => 'akademik', 'color' => '#4779B5', 'order' => 3],
            ['name' => 'Keislaman & Tahfidz', 'slug' => 'keislaman-tahfidz', 'color' => '#9377AD', 'order' => 4],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'color' => '#EAA824', 'order' => 5],
            ['name' => 'Ekstrakurikuler', 'slug' => 'ekstrakurikuler', 'color' => '#10B981', 'order' => 6],
            ['name' => 'Dana BOSP', 'slug' => 'dana-bosp', 'color' => '#6366F1', 'order' => 7],
        ];

        $categoryModels = [];
        foreach ($categoriesData as $c) {
            $cat = CmsCategory::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.en')) = ?", [$c['slug']])->first();
            if (! $cat) {
                $cat = new CmsCategory();
            }
            $cat->setTranslation('name', 'en', $c['name']);
            $cat->setTranslation('slug', 'en', $c['slug']);
            $cat->color = $c['color'];
            $cat->sort_order = $c['order'];
            $cat->save();
            $categoryModels[$c['slug']] = $cat;
        }

        // 10. TallCMS Posts (Artikel Berita Kaya & Realistis)
        $postsData = [
            [
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2027/2028 Resmi Dibuka',
                'slug' => 'penerimaan-peserta-didik-baru-ppdb-tahun-ajaran-2027-2028-resmi-dibuka',
                'category_slug' => 'pengumuman',
                'is_featured' => 1,
                'published_at' => now()->subDays(1),
                'excerpt' => 'SMA Islam Al-Madinah BSD secara resmi membuka pendaftaran peserta didik baru tahun ajaran 2027/2028 dengan kuota terbatas 120 kursi.',
                'content' => '<p>SMA Islam Al-Madinah BSD di bawah naungan Yayasan Kerukunan Keluarga Muslim BSD (YKKM BSD) resmi membuka Penerimaan Peserta Didik Baru (PPDB) untuk Tahun Ajaran 2027/2028.</p><p>Demi menjaga efektivitas pembinaan tahfidz Al-Qur\'an dan pendekatan personal guru terhadap santri, kuota penerimaan tahun ini dibatasi hanya untuk 120 siswa (5 rombel, maksimal 24 santri per kelas).</p><h3>Jalur Penerimaan:</h3><ul><li><strong>Jalur Reguler:</strong> Melalui tes pemetaan akademik dasar dan observasi potensi karakter.</li><li><strong>Jalur Prestasi Tahfidz:</strong> Khusus santri yang memiliki hafalan minimal 2 Juz Al-Qur\'an mutqin.</li><li><strong>Jalur Prestasi Akademik & Sains:</strong> Untuk peraih juara 1-3 OSN atau kompetisi setingkat.</li></ul><p>Pendaftaran dapat dilakukan secara online melalui portal resmi PPDB atau langsung berkunjung ke kantor sekretariat PPDB Komplek BSD City Sektor XIV.</p>',
            ],
            [
                'title' => 'Santri SMA Islam Al-Madinah BSD Raih Juara 1 Olimpiade Sains & Riset Tingkat Provinsi',
                'slug' => 'santri-sma-al-madinah-raih-juara-1-olimpiade-sains-provinsi',
                'category_slug' => 'prestasi',
                'is_featured' => 1,
                'published_at' => now()->subDays(3),
                'excerpt' => 'Kabar membanggakan datang dari santri SMA Al-Madinah BSD yang berhasil meraih medali emas pada ajang bergengsi Olimpiade Sains Pelajar.',
                'content' => '<p>Alhamdulillah, puji syukur ke hadirat Allah SWT. Santri SMA Islam Al-Madinah BSD atas nama Muhammad Rayyan Zhafir berhasil menorehkan prestasi gemilang dengan meraih Medali Emas (Juara 1) pada ajang Olimpiade Sains Pelajar tingkat Provinsi Banten.</p><p>Prestasi ini merupakan buah dari ketekunan santri dalam mengikuti bimbingan intensif Smart Science Club serta doa dan dukungan penuh dari dewan asatidz dan para wali santri.</p><p>Kepala Sekolah menyampaikan rasa syukur dan apresiasi yang mendalam atas pencapaian ini, yang membuktikan bahwa pendidikan berbasis adab dan Al-Qur\'an mampu berjalan beriringan dengan keunggulan sains modern.</p>',
            ],
            [
                'title' => 'Tasmi\' Akbar 3 Juz Sekali Duduk dan Munaqasyah Tahfidz Al-Qur\'an Angkatan X',
                'slug' => 'tasmi-akbar-3-juz-sekali-duduk-munaqasyah-tahfidz-angkatan-x',
                'category_slug' => 'keislaman-tahfidz',
                'is_featured' => 0,
                'published_at' => now()->subDays(6),
                'excerpt' => 'Sebanyak 35 santri mengikuti Tasmi\' Akbar hafalan 3 Juz Al-Qur\'an sekali duduk di Masjid Jami\' Islamic Center KKMB BSD.',
                'content' => '<p>Suasana haru dan khidmat menyelimuti Masjid Jami\' Islamic Center KKMB BSD saat diselenggarakannya agenda Tasmi\' Akbar dan Munaqasyah Tahfidz Al-Qur\'an Angkatan X SMA Islam Al-Madinah BSD.</p><p>Sebanyak 35 santri berhasil memperdengarkan hafalan Al-Qur\'an secara mutqin sekali duduk di hadapan dewan penguji bersanad dan disaksikan langsung oleh para orang tua santri.</p><p>Koordinator Program Tahfidz menuturkan bahwa target 3 Juz mutqin selama menempuh jenjang SMA bukan sekadar mengejar kuantitas hafalan, melainkan menanamkan kecintaan mendalam terhadap Al-Qur\'an dan akhlak yang mulia.</p>',
            ],
            [
                'title' => 'Laporan Rekapitulasi Realisasi Penggunaan Dana BOSP SMA Islam Al-Madinah BSD',
                'slug' => 'laporan-rekapitulasi-realisasi-penggunaan-dana-bosp',
                'category_slug' => 'dana-bosp',
                'is_featured' => 0,
                'published_at' => now()->subDays(8),
                'excerpt' => 'Sebagai wujud akuntabilitas dan transparansi tata kelola sekolah, SMA Islam Al-Madinah mempublikasikan laporan pemanfaatan Dana BOSP.',
                'content' => '<p>Sebagai wujud komitmen terhadap prinsip Good School Governance, keterbukaan informasi publik, dan akuntabilitas pengelolaan anggaran pendidikan, manajemen SMA Islam Al-Madinah BSD mempublikasikan rekapitulasi realisasi penggunaan Dana BOSP (Bantuan Operasional Satuan Pendidikan) Tahun Anggaran Berjalan.</p><p>Alokasi dana difokuskan pada:</p><ol><li>Penyediaan buku teks dan referensi e-library bagi santri.</li><li>Peningkatan kapasitas sarana laboratorium komputer CBT.</li><li>Pemeliharaan sanitasi dan kebersihan lingkungan sekolah sehat.</li><li>Pengembangan kompetensi profesional guru dan tenaga kependidikan.</li></ol><p>Dokumen rekapitulasi lengkap dapat diakses secara transparan oleh wali santri dan masyarakat di papan pengumuman resmi sekolah.</p>',
            ],
            [
                'title' => 'Peringatan Hari Guru Nasional: Apresiasi Pendidik Berdedikasi Yayasan KKMB BSD',
                'slug' => 'peringatan-hari-guru-nasional-apresiasi-pendidik-berdedikasi',
                'category_slug' => 'warta-sekolah',
                'is_featured' => 0,
                'published_at' => now()->subDays(12),
                'excerpt' => 'Rangkaian upacara dan pemberian penghargaan bagi guru berprestasi serta berdedikasi tinggi di lingkungan SMA Al-Madinah BSD.',
                'content' => '<p>Dalam rangka memperingati Hari Guru Nasional, keluarga besar SMA Islam Al-Madinah BSD menyelenggarakan upacara bendera khusus yang seluruh petugas upacaranya adalah dewan guru dan tenaga kependidikan.</p><p>Acara dilanjutkan dengan ramah tamah, persembahan puisi dari OSIS santri, serta penyerahan piagam Guru Teladan dan Anugerah Pendidik Inspiratif Yayasan KKMB BSD.</p>',
            ],
            [
                'title' => 'Workshop Robotika dan Coding: Melatih Pemikiran Komputasional Santri di Era AI',
                'slug' => 'workshop-robotika-dan-coding-melatih-komputasional-santri',
                'category_slug' => 'akademik',
                'is_featured' => 0,
                'published_at' => now()->subDays(15),
                'excerpt' => 'Santri kelas 10 dan 11 antusias mengikuti workshop pengenalan sensor robotik dan logika algoritma dasar di lab multimedia.',
                'content' => '<p>Laboratorium Komputer SMA Islam Al-Madinah BSD dipenuhi antusiasme santri yang mengikuti Workshop Robotika & Coding. Kegiatan ini bertujuan memperkenalkan computational thinking, logika pemrograman dasar, dan teknologi mikrokontroler.</p><p>Para santri dipandu merakit robot sederhana yang dapat bergerak mendeteksi garis (line follower) dan menghindari halangan secara mandiri.</p>',
            ],
            [
                'title' => 'Field Trip Edukatif Sains Lingkungan dan Teknologi Hijau ke Puspiptek Serpong',
                'slug' => 'field-trip-edukatif-sains-lingkungan-ke-puspiptek-serpong',
                'category_slug' => 'akademik',
                'is_featured' => 0,
                'published_at' => now()->subDays(20),
                'excerpt' => 'Santri mendalami aplikasi energi terbarukan dan riset bioteknologi langsung bersama para peneliti ahli di kawasan Puspiptek.',
                'content' => '<p>Menghubungkan teori buku dengan aplikasi riil di lapangan, santri SMA Islam Al-Madinah BSD mengadakan kunjungan edukatif (field trip) ke kawasan riset Puspiptek Serpong.</p><p>Santri berkesempatan mengunjungi reaktor riset, laboratorium teknologi bahan, dan instalasi energi surya terbarukan.</p>',
            ],
            [
                'title' => 'Latihan Gabungan Kepramukaan Gugus Depan Al-Madinah dan Pembiasaan Disiplin',
                'slug' => 'latihan-gabungan-kepramukaan-gugus-depan-al-madinah',
                'category_slug' => 'ekstrakurikuler',
                'is_featured' => 0,
                'published_at' => now()->subDays(25),
                'excerpt' => 'Gugus Depan SMA Al-Madinah menggelar latihan gabungan teknik kepramukaan, pionering, dan penjelajahan alam.',
                'content' => '<p>Kegiatan ekstrakurikuler wajib Pramuka Penegak Gugus Depan SMA Islam Al-Madinah BSD berlangsung penuh semangat di halaman SMA Al-Madinah Islamic Center KKMB.</p><p>Latihan gabungan ini melatih ketangkasan sandi morse, semaphore, tali-temali pionering, serta penanaman karakter disiplin dan gotong royong.</p>',
            ],
            [
                'title' => 'Kajian Parenting Bersama Psikolog: Sinergi Mendidik Adab Anak di Era Digital',
                'slug' => 'kajian-parenting-sinergi-mendidik-adab-anak-di-era-digital',
                'category_slug' => 'warta-sekolah',
                'is_featured' => 0,
                'published_at' => now()->subDays(30),
                'excerpt' => 'Pertemuan rutin komite sekolah dan wali santri membahas kiat pendampingan gawai dan penguatan adab Islami di rumah.',
                'content' => '<p>Sebagai bentuk kemitraan strategis antara sekolah dan keluarga, SMA Islam Al-Madinah BSD menyelenggarakan seminar parenting berkala bertema "Membangun Ketahanan Mental dan Adab Anak Menghadapi Arus Digital".</p><p>Acara dihadiri lebih dari 200 wali santri dengan narasumber psikolog pendidikan anak.</p>',
            ],
        ];

        foreach ($postsData as $pData) {
            $post = CmsPost::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.en')) = ?", [$pData['slug']])->first();
            if (! $post) {
                $post = new CmsPost();
            }
            $post->setTranslation('title', 'en', $pData['title']);
            $post->setTranslation('slug', 'en', $pData['slug']);
            $post->setTranslation('excerpt', 'en', $pData['excerpt']);
            $post->setTranslation('content', 'en', $pData['content']);
            $post->setTranslation('meta_title', 'en', $pData['title'] . ' | SMA Al-Madinah BSD');
            $post->setTranslation('meta_description', 'en', $pData['excerpt']);
            $post->search_content = strip_tags($pData['title'] . ' ' . $pData['excerpt'] . ' ' . $pData['content']);
            $post->status = 'published';
            $post->published_at = $pData['published_at'];
            $post->author_id = $admin->id;
            $post->is_featured = $pData['is_featured'];
            $post->views = rand(45, 320);
            $post->save();

            // Sync Category
            if (isset($categoryModels[$pData['category_slug']])) {
                $post->categories()->sync([$categoryModels[$pData['category_slug']]->id]);
            }
        }

        // 11. Galeri Kegiatan (8 Dokumentasi Nyata)
        $sampleGalleryImages = [
            'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=800&q=80',
        ];

        $galleries = [
            [
                'title' => 'Pembiasaan Shalat Dhuha & Tadarus Al-Qur\'an Pagi Berjamaah',
                'category' => 'Keislaman',
                'description' => 'Aktivitas rutin santri setiap pagi di Masjid Jami\' Islamic Center KKMB sebelum memulai kegiatan belajar mengajar.',
                'image' => $sampleGalleryImages[0],
                'event_date' => now()->subDays(4),
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Ujian Munaqasyah Tahfidz Al-Qur\'an Juz 28, 29, dan 30',
                'category' => 'Tahfidz',
                'description' => 'Munaqasyah dan tasmi\' santri dalam menguji kelancaran hafalan bersama dewan asatidz bersanad.',
                'image' => $sampleGalleryImages[1],
                'event_date' => now()->subDays(8),
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Praktikum Eksperimen Sains di Smart Laboratory IPA',
                'category' => 'Akademik',
                'description' => 'Santri melakukan uji laboratorium biologi dan fisika untuk memperdalam pemahaman sains kurikulum merdeka.',
                'image' => $sampleGalleryImages[2],
                'event_date' => now()->subDays(12),
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Gelar Karya Proyek P5: Inovasi Olahan Pangan Berkelanjutan',
                'category' => 'Karya Santri',
                'description' => 'Pameran kreativitas dan kewirausahaan santri dalam menghasilkan produk ramah lingkungan.',
                'image' => $sampleGalleryImages[3],
                'event_date' => now()->subDays(16),
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Latihan Kepemimpinan & Ketangkasan Pramuka Al-Madinah',
                'category' => 'Pramuka',
                'description' => 'Pionering, navigasi kompas, dan latihan baris berbaris pembentukan jiwa disiplin santri.',
                'image' => $sampleGalleryImages[4],
                'event_date' => now()->subDays(20),
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Turnamen Futsal Antar-Kelas dan Pembinaan Atlet Pelajar',
                'category' => 'Olahraga',
                'description' => 'Kompetisi persahabatan antar-kelas untuk menjunjung sportivitas dan kebugaran jasmani santri.',
                'image' => $sampleGalleryImages[5],
                'event_date' => now()->subDays(24),
                'order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Kunjungan Edukasi (Field Trip) ke Kawasan Riset Puspiptek Serpong',
                'category' => 'Field Trip',
                'description' => 'Santri diajak melihat langsung teknologi reaktor dan pembangkit energi terbarukan ramah lingkungan.',
                'image' => $sampleGalleryImages[6],
                'event_date' => now()->subDays(28),
                'order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Literasi Digital Perpustakaan dan Halaqah Bedah Buku Santri',
                'category' => 'Literasi',
                'description' => 'Aktivitas gemar membaca dan bedah buku sains serta keislaman di ruang baca e-library sekolah.',
                'image' => $sampleGalleryImages[7],
                'event_date' => now()->subDays(32),
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($galleries as $g) {
            Gallery::updateOrCreate(['title' => $g['title']], $g);
        }

        // 12. Agenda Sekolah (School Events)
        $events = [
            [
                'title' => 'Open House & Sosialisasi PPDB T.A. 2027/2028',
                'slug' => 'open-house-sosialisasi-ppdb-2027-2028',
                'start_date' => now()->addDays(7)->setTime(8, 0),
                'end_date' => now()->addDays(7)->setTime(12, 0),
                'location' => 'Auditorium Utama Islamic Center KKMB BSD',
                'organizer' => 'Panitia PPDB Al-Madinah BSD',
                'description' => 'Paparan kurikulum terpadu, demo robotik santri, tes pemetaan minat bakat gratis, dan konsultasi pendaftaran langsung.',
                'is_active' => true,
            ],
            [
                'title' => 'Tasmi\' Akbar & Khotmil Qur\'an 3 Juz Sekali Duduk',
                'slug' => 'tasmi-akbar-khotmil-quran-3-juz',
                'start_date' => now()->addDays(18)->setTime(7, 30),
                'end_date' => now()->addDays(18)->setTime(14, 0),
                'location' => 'Masjid Jami\' Islamic Center KKMB BSD',
                'organizer' => 'Koordinator Tahfidz Al-Madinah',
                'description' => 'Penyampaian hafalan santri kelas 12 di hadapan para penguji bersanad dan para wali santri.',
                'is_active' => true,
            ],
            [
                'title' => 'Penilaian Sumatif Tengah Semester (PTS) Berbasis CBT',
                'slug' => 'penilaian-sumatif-tengah-semester-cbt',
                'start_date' => now()->addDays(30)->setTime(7, 0),
                'end_date' => now()->addDays(36)->setTime(13, 0),
                'location' => 'SMA Al-Madinah Islamic Center KKMB',
                'organizer' => 'Tim Kurikulum Al-Madinah',
                'description' => 'Evaluasi capaian pembelajaran berbasis perangkat komputer dan tablet edukasi terintegrasi.',
                'is_active' => true,
            ],
            [
                'title' => 'Rihlah Ilmiah & Kemah Karakter Santri Mandiri',
                'slug' => 'rihlah-ilmiah-kemah-karakter-santri',
                'start_date' => now()->addDays(45)->setTime(6, 0),
                'end_date' => now()->addDays(47)->setTime(16, 0),
                'location' => 'Bumi Perkemahan Mandiri Cibubur',
                'organizer' => 'Kesiswaan & Pembina Pramuka',
                'description' => 'Kegiatan kepemimpinan alam terbuka untuk menumbuhkan adab, kemandirian, dan kerjasama tim santri.',
                'is_active' => true,
            ],
        ];

        foreach ($events as $ev) {
            SchoolEvent::updateOrCreate(['slug' => $ev['slug']], $ev);
        }

        // 13. Pengumuman Resmi (Announcements)
        $announcements = [
            [
                'title' => 'Pendaftaran PPDB Online Tahun Ajaran 2027/2028 Resmi Dibuka!',
                'message' => 'Penerimaan Peserta Didik Baru (PPDB) SMA Islam Al-Madinah BSD telah dibuka dengan kuota terbatas 120 siswa. Segera daftarkan ananda sekarang.',
                'url' => route('ppdb.index'),
                'type' => 'success',
                'is_active' => true,
            ],
            [
                'title' => 'Jadwal Tes Pemetaan Potensi dan Wawancara Gelombang 1',
                'message' => 'Tes pemetaan potensi akademik dan observasi tahfidz Gelombang 1 dijadwalkan pada hari Sabtu pukul 08.00 WIB di SMA Al-Madinah Islamic Center KKMB.',
                'url' => route('ppdb.check-status'),
                'type' => 'info',
                'is_active' => true,
            ],
        ];

        foreach ($announcements as $ann) {
            Announcement::updateOrCreate(['title' => $ann['title']], $ann);
        }
    }
}
