<?php

namespace App\Filament\Resources\SchoolProfiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SchoolProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Profil Sekolah')
                    ->columnSpanFull()
                    ->tabs([
                        // ==========================================
                        // TAB 1: IDENTITAS RESMI & LOGO
                        // ==========================================
                        Tab::make('Identitas Sekolah')
                            ->icon('heroicon-o-building-library')
                            ->schema([
                                Grid::make(12)->schema([
                                    Section::make('Identitas Utama Sekolah')
                                        ->description('Informasi legalitas dan identitas resmi lembaga')
                                        ->columnSpan(['default' => 12, 'lg' => 8])
                                        ->schema([
                                            Grid::make(2)->schema([
                                                TextInput::make('name')
                                                    ->label('Nama Resmi Sekolah')
                                                    ->required()
                                                    ->default('SMA Al-Madinah')
                                                    ->prefixIcon('heroicon-o-academic-cap'),

                                                TextInput::make('npsn')
                                                    ->label('NPSN')
                                                    ->placeholder('Contoh: 10812345')
                                                    ->prefixIcon('heroicon-o-identification'),
                                            ]),

                                            Grid::make(2)->schema([
                                                Select::make('accreditation')
                                                    ->label('Akreditasi')
                                                    ->required()
                                                    ->default('A')
                                                    ->options([
                                                        'A' => 'A (Unggul / Sangat Baik)',
                                                        'B' => 'B (Baik)',
                                                        'C' => 'C (Cukup)',
                                                        'Belum Terakreditasi' => 'Belum Terakreditasi',
                                                    ])
                                                    ->native(false),

                                                TextInput::make('statistic_year_founded')
                                                    ->label('Tahun Berdiri')
                                                    ->numeric()
                                                    ->default(2012)
                                                    ->prefixIcon('heroicon-o-calendar'),
                                            ]),

                                            TextInput::make('tagline')
                                                ->label('Motto / Slogan Sekolah')
                                                ->placeholder('Contoh: Cerdas, Berkarakter & Berakhlak Mulia')
                                                ->prefixIcon('heroicon-o-sparkles')
                                                ->columnSpanFull(),
                                        ]),

                                    Section::make('Logo Resmi Sekolah')
                                        ->description('Logo lembaga untuk header & favicon')
                                        ->columnSpan(['default' => 12, 'lg' => 4])
                                        ->schema([
                                            FileUpload::make('logo')
                                                ->label('Logo Sekolah')
                                                ->image()
                                                ->imageEditor()
                                                ->directory('school/branding')
                                                ->maxSize(2048)
                                                ->helperText('Format PNG transparan / JPG persegi, maks. 2MB'),
                                        ]),
                                ]),
                            ]),

                        // ==========================================
                        // TAB 2: FOTO & VISUAL BERANDA
                        // ==========================================
                        Tab::make('Foto & Visual Beranda')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Foto Utama Heading Beranda (Bingkai Kubah / Arch)')
                                    ->description('Foto santri, siswa, atau kegiatan unggulan yang tampil di bagian paling atas beranda (di dalam bingkai kubah sebelah kiri pengumuman SPMB/PPDB).')
                                    ->schema([
                                        FileUpload::make('hero_image')
                                            ->label('Foto Heading Beranda (Santri / Siswa)')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                null,
                                                '4:5',
                                                '3:4',
                                                '1:1',
                                                '16:9',
                                            ])
                                            ->directory('school/branding')
                                            ->maxSize(5120)
                                            ->downloadable()
                                            ->openable()
                                            ->helperText('Disarankan menggunakan foto portrait atau rasio 4:5 santri/siswa berprestasi atau kegiatan sekolah (maks. 5MB). Anda bisa memotong/mengatur posisi foto dengan tombol edit setelah memilih berkas.'),
                                    ]),

                                Section::make('Kartu Prestasi Siswa (Melayang di Bawah Foto)')
                                    ->description('Sesuaikan teks kartu prestasi santri yang menempel di bagian bawah foto kubah heading.')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            TextInput::make('hero_badge_title')
                                                ->label('Judul Prestasi')
                                                ->default('Santri Berprestasi')
                                                ->placeholder('Contoh: Santri Berprestasi')
                                                ->prefixIcon('heroicon-o-star')
                                                ->helperText('Teks tebal utama di atas kartu'),

                                            TextInput::make('hero_badge_subtitle')
                                                ->label('Keterangan Prestasi')
                                                ->default('Tahfidz 10 Juz & Juara Sains')
                                                ->placeholder('Contoh: Tahfidz 10 Juz & Juara Sains')
                                                ->prefixIcon('heroicon-o-academic-cap')
                                                ->helperText('Rincian capaian / prestasi siswa'),

                                            TextInput::make('hero_badge_tag')
                                                ->label('Label Status / Predikat')
                                                ->default('Mumtaz')
                                                ->placeholder('Contoh: Mumtaz / Juara 1')
                                                ->prefixIcon('heroicon-o-check-badge')
                                                ->helperText('Badge kecil di pojok kanan kartu'),
                                        ]),
                                    ]),

                                Section::make('Fitur Scan QR Code PPDB Cepat')
                                    ->description('Pengaturan kode QR untuk fitur "Scan untuk Daftar Cepat" yang berada di banner SPMB/PPDB.')
                                    ->schema([
                                        FileUpload::make('ppdb_qr_code')
                                            ->label('Unggah Gambar QR Code Khusus (Opsional)')
                                            ->image()
                                            ->directory('school/branding')
                                            ->maxSize(2048)
                                            ->downloadable()
                                            ->openable()
                                            ->helperText('Jika dibiarkan kosong, sistem akan secara otomatis membuat QR Code interaktif beresolusi tinggi yang langsung terhubung ke formulir pendaftaran PPDB Online.'),
                                    ]),

                                Section::make('Foto Bagian: Mengapa Memilih Kami (Section 05)')
                                    ->description('Foto portrait santri/siswa berprestasi yang tampil di sebelah kanan checklist "Mengapa Memilih SMA Islam Al-Madinah BSD?".')
                                    ->schema([
                                        FileUpload::make('why_choose_us_image')
                                            ->label('Foto Siswa / Santri (Mengapa Memilih Kami)')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                null,
                                                '3:4',
                                                '4:5',
                                                '1:1',
                                            ])
                                            ->directory('school/branding')
                                            ->maxSize(5120)
                                            ->downloadable()
                                            ->openable()
                                            ->helperText('Disarankan foto portrait siswa/santri beresolusi tajam (maks. 5MB). Jika dikosongkan, sistem akan menggunakan foto default.'),

                                        Grid::make(2)->schema([
                                            TextInput::make('why_choose_us_badge_title')
                                                ->label('Judul Badge Melayang')
                                                ->default('Akreditasi A Unggul')
                                                ->placeholder('Contoh: Akreditasi A Unggul')
                                                ->prefixIcon('heroicon-o-check-badge')
                                                ->helperText('Teks tebal pada kartu melayang di sudut bawah foto'),

                                            TextInput::make('why_choose_us_badge_subtitle')
                                                ->label('Keterangan Badge Melayang')
                                                ->default('BAN-S/M Kemendikbud')
                                                ->placeholder('Contoh: BAN-S/M Kemendikbud')
                                                ->prefixIcon('heroicon-o-academic-cap')
                                                ->helperText('Subteks di bawah judul badge'),
                                        ]),
                                    ]),

                                Section::make('4 Foto Kolase Bagian: Daftar Sekarang Juga (Section 07 PPDB)')
                                    ->description('4 foto kegiatan atau santri yang tampil dalam grid 2x2 di samping formulir/ajakan "Daftar SMA Islam Al-Madinah BSD Sekarang Juga!". Anda dapat mengganti masing-masing foto secara fleksibel.')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            FileUpload::make('cta_collage_image_1')
                                                ->label('Foto Kolase 1 (Kiri Atas)')
                                                ->image()
                                                ->imageEditor()
                                                ->directory('school/branding')
                                                ->maxSize(4096)
                                                ->downloadable()
                                                ->openable()
                                                ->helperText('Foto kegiatan atau lingkungan belajar (persegi/landscape)'),

                                            FileUpload::make('cta_collage_image_2')
                                                ->label('Foto Kolase 2 (Kanan Atas)')
                                                ->image()
                                                ->imageEditor()
                                                ->directory('school/branding')
                                                ->maxSize(4096)
                                                ->downloadable()
                                                ->openable()
                                                ->helperText('Foto suasana kelas / pembelajaran'),

                                            FileUpload::make('cta_collage_image_3')
                                                ->label('Foto Kolase 3 (Kiri Bawah)')
                                                ->image()
                                                ->imageEditor()
                                                ->directory('school/branding')
                                                ->maxSize(4096)
                                                ->downloadable()
                                                ->openable()
                                                ->helperText('Foto perpustakaan / santri berdiskusi'),

                                            FileUpload::make('cta_collage_image_4')
                                                ->label('Foto Kolase 4 (Kanan Bawah)')
                                                ->image()
                                                ->imageEditor()
                                                ->directory('school/branding')
                                                ->maxSize(4096)
                                                ->downloadable()
                                                ->openable()
                                                ->helperText('Foto santri berprestasi / potret ceria'),
                                        ]),
                                    ]),
                            ]),

                        // ==========================================
                        // TAB 3: BROSUR & BIAYA PPDB
                        // ==========================================
                        Tab::make('Brosur & Biaya PPDB')
                            ->icon('heroicon-o-document-arrow-down')
                            ->schema([
                                Grid::make(12)->schema([
                                    Section::make('Unggah Brosur Resmi PPDB')
                                        ->description('Unggah berkas brosur promosi / informasi sekolah untuk calon peserta didik baru. Berkas ini otomatis diaktifkan pada tombol "Unduh Brosur" di halaman depan.')
                                        ->columnSpan(['default' => 12, 'lg' => 6])
                                        ->schema([
                                            FileUpload::make('brochure_file')
                                                ->label('Berkas Brosur Sekolah')
                                                ->disk('public')
                                                ->directory('school/documents')
                                                ->acceptedFileTypes([
                                                    'application/pdf',
                                                    'image/jpeg',
                                                    'image/png',
                                                    'image/webp',
                                                ])
                                                ->maxSize(15360)
                                                ->downloadable()
                                                ->openable()
                                                ->helperText('Format didukung: PDF atau Gambar JPG/PNG/WEBP (Maks. 15MB). Tombol "Unduh Brosur" di beranda akan langsung mengunduh/membuka berkas ini.'),
                                        ]),

                                    Section::make('Unggah Dokumen Rincian Biaya PPDB')
                                        ->description('Unggah tabel atau berkas rincian biaya pendaftaran, uang pangkal, SPP, dan seragam. Berkas ini otomatis diaktifkan pada tombol "Biaya PPDB" di halaman depan.')
                                        ->columnSpan(['default' => 12, 'lg' => 6])
                                        ->schema([
                                            FileUpload::make('ppdb_fee_file')
                                                ->label('Berkas Rincian Biaya PPDB')
                                                ->disk('public')
                                                ->directory('school/documents')
                                                ->acceptedFileTypes([
                                                    'application/pdf',
                                                    'image/jpeg',
                                                    'image/png',
                                                    'image/webp',
                                                ])
                                                ->maxSize(15360)
                                                ->downloadable()
                                                ->openable()
                                                ->helperText('Format didukung: PDF atau Gambar JPG/PNG/WEBP (Maks. 15MB). Pengunjung dapat melihat pratinjau tabel biaya atau mengunduh berkas ini.'),
                                        ]),
                                ]),
                            ]),

                        // ==========================================
                        // TAB 4: KEPALA SEKOLAH & SAMBUTAN
                        // ==========================================
                        Tab::make('Kepala Sekolah')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                Grid::make(12)->schema([
                                    Section::make('Foto Kepala Sekolah')
                                        ->columnSpan(['default' => 12, 'md' => 4])
                                        ->schema([
                                            FileUpload::make('headmaster_photo')
                                                ->label('Foto Formal Kepala Sekolah')
                                                ->image()
                                                ->imageEditor()
                                                ->imageEditorAspectRatios([
                                                    null,
                                                    '1:1',
                                                    '3:4',
                                                    '4:5',
                                                ])
                                                ->disk('public')
                                                ->directory('school/staff')
                                                ->visibility('public')
                                                ->openable()
                                                ->downloadable()
                                                ->maxSize(5120)
                                                ->helperText('Foto portrait/setengah badan formal berlatar rapi (maks. 5MB). Klik ikon pensil untuk crop / edit foto.'),
                                        ]),

                                    Section::make('Profil & Kata Sambutan')
                                        ->columnSpan(['default' => 12, 'md' => 8])
                                        ->schema([
                                            TextInput::make('headmaster_name')
                                                ->label('Nama Lengkap & Gelar')
                                                ->placeholder('Contoh: H. M. Syaifullah, M.Pd.')
                                                ->prefixIcon('heroicon-o-user')
                                                ->required(),

                                            Textarea::make('headmaster_welcome')
                                                ->label('Sambutan Resmi Kepala Sekolah')
                                                ->rows(7)
                                                ->placeholder('Tuliskan kata sambutan hangat dari kepala sekolah kepada calon peserta didik, wali murid, dan seluruh pengunjung website...')
                                                ->helperText('Akan ditampilkan di bagian Sambutan Kepala Sekolah pada beranda'),
                                        ]),
                                ]),
                            ]),

                        // ==========================================
                        // TAB 5: VISI, MISI & TENTANG SEKOLAH
                        // ==========================================
                        Tab::make('Visi, Misi & Profil')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make('Tentang Sekolah')
                                    ->description('Profil ringkas dan sejarah singkat yang tampil di beranda')
                                    ->schema([
                                        Textarea::make('about')
                                            ->label('Profil Singkat & Sejarah Lembaga')
                                            ->rows(4)
                                            ->placeholder('Jelaskan secara ringkas sejarah pendirian, visi pembinaan karakter, dan identitas keunggulan SMA Al-Madinah...')
                                            ->helperText('Tampil di section Tentang Kami di landing page'),
                                    ]),

                                Grid::make(2)->schema([
                                    Section::make('Visi Sekolah')
                                        ->schema([
                                            Textarea::make('vision')
                                                ->label('Pernyataan Visi')
                                                ->rows(5)
                                                ->placeholder('Contoh: Terwujudnya generasi Qurani yang cerdas, berakhlak mulia, unggul dalam prestasi, dan berwawasan global.'),
                                        ]),

                                    Section::make('Misi Sekolah')
                                        ->schema([
                                            Textarea::make('mission')
                                                ->label('Poin-Poin Misi')
                                                ->rows(5)
                                                ->placeholder("1. Menyelenggarakan pendidikan Islam terpadu yang berorientasi pada mutu akademik dan akhlak.\n2. Mengintegrasikan kurikulum nasional dengan program tahfidz dan pembiasaan adab Islami.\n3. Membimbing dan mengembangkan minat, bakat, serta potensi siswa secara berkesinambungan."),
                                        ]),
                                ]),
                            ]),

                        // ==========================================
                        // TAB 6: STATISTIK CAPAIAN
                        // ==========================================
                        Tab::make('Statistik Capaian')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Section::make('Counter Angka Landing Page')
                                    ->description('Statistik prestasi dan kapasitas sekolah yang tampil sebagai angka beranimasi pada halaman depan')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            TextInput::make('statistic_students')
                                                ->label('Jumlah Siswa Aktif')
                                                ->numeric()
                                                ->default(350)
                                                ->suffix('Siswa')
                                                ->prefixIcon('heroicon-o-user-group'),

                                            TextInput::make('statistic_teachers')
                                                ->label('Tenaga Pendidik & Staf')
                                                ->numeric()
                                                ->default(25)
                                                ->suffix('Orang')
                                                ->prefixIcon('heroicon-o-academic-cap'),

                                            TextInput::make('statistic_achievements')
                                                ->label('Total Prestasi Diraih')
                                                ->numeric()
                                                ->default(48)
                                                ->suffix('Prestasi')
                                                ->prefixIcon('heroicon-o-trophy'),
                                        ]),
                                    ]),
                            ]),

                        // ==========================================
                        // TAB 5: KONTAK & LOKASI
                        // ==========================================
                        Tab::make('Kontak & Lokasi')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Section::make('Saluran Komunikasi Resmi')
                                    ->description('Nomor telepon kantor, nomor WhatsApp sekolah, WhatsApp khusus panitia PPDB, dan alamat email')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            TextInput::make('phone')
                                                ->label('Telepon Kantor')
                                                ->tel()
                                                ->prefixIcon('heroicon-o-phone')
                                                ->placeholder('(021) 555-1234'),

                                            TextInput::make('whatsapp')
                                                ->label('WhatsApp Resmi Sekolah (Utama)')
                                                ->tel()
                                                ->prefixIcon('heroicon-o-chat-bubble-left-ellipsis')
                                                ->placeholder('Contoh: 6281234567890')
                                                ->helperText('Nomor WhatsApp utama sekolah / CS (format 62...)'),

                                            TextInput::make('whatsapp_ppdb')
                                                ->label('WhatsApp Panitia PPDB (Opsional)')
                                                ->tel()
                                                ->prefixIcon('heroicon-o-user-group')
                                                ->placeholder('Contoh: 6281299887766')
                                                ->helperText('Khusus pendaftaran PPDB, brosur & biaya. Jika kosong, otomatis memakai WhatsApp Utama.'),
                                        ]),

                                        Grid::make(2)->schema([
                                            TextInput::make('email')
                                                ->label('Email Resmi')
                                                ->email()
                                                ->prefixIcon('heroicon-o-envelope')
                                                ->placeholder('info@almadinah.sch.id'),

                                            TextInput::make('whatsapp_custom_url')
                                                ->label('Tautan Kustom WhatsApp / Direct Link (Opsional)')
                                                ->url()
                                                ->prefixIcon('heroicon-o-link')
                                                ->placeholder('Contoh: https://wa.link/smaalmadinah atau https://bit.ly/wa-ppdb')
                                                ->helperText('Jika diisi, semua tombol WhatsApp di website akan langsung mengarah ke tautan khusus ini.'),
                                        ]),
                                    ]),

                                Section::make('Kustomisasi Pesan Otomatis WhatsApp (Template Chat)')
                                    ->description('Atur pesan pembuka otomatis saat calon wali santri / pengunjung mengklik masing-masing tombol WhatsApp di website.')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            Textarea::make('whatsapp_message_panitia')
                                                ->label('Template Pesan: "Chat WA Panitia" / "Konsultasi PPDB"')
                                                ->rows(2)
                                                ->placeholder('Assalamu\'alaikum Panitia PPDB SMA Al-Madinah, saya ingin konsultasi mengenai Penerimaan Santri Baru...')
                                                ->helperText('Tampil saat pengunjung klik tombol Chat WA Panitia atau Konsultasi PPDB.'),

                                            Textarea::make('whatsapp_message_brosur')
                                                ->label('Template Pesan: "Minta Brosur via WA"')
                                                ->rows(2)
                                                ->placeholder('Assalamu\'alaikum Panitia PPDB SMA Al-Madinah, saya ingin meminta berkas Brosur Resmi PPDB...')
                                                ->helperText('Tampil pada modal brosur saat pengunjung memilih opsi hubungi panitia.'),

                                            Textarea::make('whatsapp_message_biaya')
                                                ->label('Template Pesan: "Tanya Biaya via WA"')
                                                ->rows(2)
                                                ->placeholder('Assalamu\'alaikum Panitia PPDB SMA Al-Madinah, saya ingin menanyakan rincian Biaya PPDB & SPP...')
                                                ->helperText('Tampil pada modal rincian biaya saat pengunjung memilih opsi hubungi panitia.'),

                                            Textarea::make('whatsapp_message_floating')
                                                ->label('Template Pesan: Tombol Melayang (Floating WA Button)')
                                                ->rows(2)
                                                ->placeholder('Assalamu\'alaikum Admin SMA Al-Madinah, saya ingin bertanya informasi pendaftaran dan kegiatan sekolah.')
                                                ->helperText('Tampil saat pengunjung mengklik widget tombol WhatsApp hijau yang melayang di pojok kanan bawah.'),
                                        ]),
                                    ]),

                                Section::make('Alamat Fisik & Peta Google Maps')
                                    ->schema([
                                        Textarea::make('address')
                                            ->label('Alamat Lengkap Sekolah')
                                            ->rows(2)
                                            ->placeholder('Jl. Al-Madinah No. 12, Kelurahan Harapan Baru, Kecamatan Cipondoh, Kota Tangerang, Banten 15148')
                                            ->helperText('Alamat fisik yang ditampilkan di footer dan halaman kontak sekolah'),

                                        Textarea::make('google_maps_embed')
                                            ->label('Kode Sematan Peta Google Maps (Iframe Embed)')
                                            ->rows(3)
                                            ->placeholder('<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>')
                                            ->helperText('Buka Google Maps -> Cari lokasi sekolah -> Klik Bagikan (Share) -> Sematkan peta (Embed a map) -> Salin kode HTML'),
                                    ]),
                            ]),

                        // ==========================================
                        // TAB 6: MEDIA SOSIAL & VIDEO PROFIL
                        // ==========================================
                        Tab::make('Media Sosial & Video')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Section::make('Tautan Media Sosial')
                                    ->description('Tautan ke channel resmi media sosial sekolah')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('instagram_url')
                                                ->label('Instagram URL')
                                                ->url()
                                                ->prefixIcon('heroicon-o-camera')
                                                ->placeholder('https://instagram.com/smaalmadinah'),

                                            TextInput::make('youtube_url')
                                                ->label('YouTube Channel URL')
                                                ->url()
                                                ->prefixIcon('heroicon-o-video-camera')
                                                ->placeholder('https://youtube.com/@smaalmadinah'),

                                            TextInput::make('facebook_url')
                                                ->label('Facebook URL')
                                                ->url()
                                                ->prefixIcon('heroicon-o-globe-alt')
                                                ->placeholder('https://facebook.com/smaalmadinah'),

                                            TextInput::make('tiktok_url')
                                                ->label('TikTok URL')
                                                ->url()
                                                ->prefixIcon('heroicon-o-musical-note')
                                                ->placeholder('https://tiktok.com/@smaalmadinah'),
                                        ]),
                                    ]),

                                Section::make('Sematkan Video Profil Sekolah (YouTube Player)')
                                    ->description('Tampilkan video profil sekolah resmi yang dapat diputar langsung oleh pengunjung di Beranda')
                                    ->schema([
                                        Textarea::make('youtube_embed')
                                            ->label('Video YouTube (Tautan / Kode Semat Iframe)')
                                            ->rows(3)
                                            ->placeholder('Contoh URL: https://www.youtube.com/watch?v=dQw4w9WgXcQ atau https://youtu.be/... atau kode <iframe src="..."></iframe>')
                                            ->helperText('Bisa berupa tautan YouTube biasa (watch/share/shorts) atau kode embed iframe. Sistem akan secara otomatis memformat pemutar video agar proporsional dan responsif di Beranda.'),

                                        TextInput::make('hero_video_url')
                                            ->label('Tautan Tambahan Video Heading (Opsional)')
                                            ->url()
                                            ->prefixIcon('heroicon-o-play')
                                            ->placeholder('https://www.youtube.com/watch?v=...')
                                            ->helperText('Tautan video profil cepat untuk tombol di banner utama jika berbeda dengan sematan di atas.'),
                                    ]),

                                Section::make('Sematkan Postingan Instagram (Instagram Embed)')
                                    ->description('Tampilkan postingan atau Reels Instagram sekolah terbaru secara interaktif di Beranda')
                                    ->schema([
                                        Textarea::make('instagram_embed')
                                            ->label('Postingan / Reels Instagram (Tautan URL atau Kode Semat HTML)')
                                            ->rows(4)
                                            ->placeholder('Contoh URL: https://www.instagram.com/p/DB123456/ atau kode <blockquote class="instagram-media" ...>...</blockquote>')
                                            ->helperText('Buka postingan atau Reels di Instagram -> Klik ikon titik tiga (...) -> Pilih "Salin tautan" atau "Sematkan (Embed)" -> Tempel di sini. Pengunjung dapat melihat foto, caption, dan berinteraksi langsung.'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
