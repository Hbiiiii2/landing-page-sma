<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PpdbRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Data Pendaftaran PPDB')
                    ->columnSpanFull()
                    ->tabs([
                        // ==========================================
                        // TAB 1: DATA CALON SISWA
                        // ==========================================
                        Tab::make('Data Calon Siswa')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Grid::make(12)->schema([
                                    Section::make('Pas Foto Siswa')
                                        ->columnSpan(['default' => 12, 'md' => 4])
                                        ->schema([
                                            FileUpload::make('student_photo_file')
                                                ->label('Pas Foto Formal')
                                                ->image()
                                                ->disk('local')
                                                ->visibility('private')
                                                ->directory('ppdb/photos')
                                                ->maxSize(2048)
                                                ->helperText('Format JPG/PNG, rasio 3x4 atau 4x6, maks. 2MB'),
                                        ]),

                                    Section::make('Identitas Utama')
                                        ->columnSpan(['default' => 12, 'md' => 8])
                                        ->schema([
                                            TextInput::make('full_name')
                                                ->label('Nama Lengkap Siswa')
                                                ->required()
                                                ->maxLength(255)
                                                ->prefixIcon('heroicon-o-user'),

                                            Grid::make(2)->schema([
                                                TextInput::make('origin_school')
                                                    ->label('Asal Sekolah (SMP/MTs)')
                                                    ->placeholder('Contoh: SMPIT Al-Ihsan')
                                                    ->prefixIcon('heroicon-o-academic-cap'),

                                                Select::make('gender')
                                                    ->label('Jenis Kelamin')
                                                    ->options([
                                                        'L' => 'Laki-laki',
                                                        'P' => 'Perempuan',
                                                    ])
                                                    ->required()
                                                    ->native(false),
                                            ]),
                                        ]),
                                ]),

                                Section::make('Data Kependudukan & Kelahiran')
                                    ->schema([
                                        Grid::make(4)->schema([
                                            TextInput::make('nisn')
                                                ->label('NISN (10 Digit)')
                                                ->numeric()
                                                ->length(10)
                                                ->placeholder('Nomor Induk Siswa Nasional')
                                                ->prefixIcon('heroicon-o-identification'),

                                            TextInput::make('nik')
                                                ->label('NIK Siswa (16 Digit)')
                                                ->numeric()
                                                ->length(16)
                                                ->placeholder('Nomor Induk Kependudukan')
                                                ->prefixIcon('heroicon-o-identification'),

                                            TextInput::make('birth_place')
                                                ->label('Tempat Lahir')
                                                ->required()
                                                ->placeholder('Kota/Kabupaten Lahir'),

                                            DatePicker::make('birth_date')
                                                ->label('Tanggal Lahir')
                                                ->required()
                                                ->native(false)
                                                ->displayFormat('d/m/Y'),
                                        ]),
                                    ]),

                                Section::make('Kontak & Alamat Domisili')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            Select::make('religion')
                                                ->label('Agama')
                                                ->options([
                                                    'Islam' => 'Islam',
                                                    'Kristen' => 'Kristen',
                                                    'Katolik' => 'Katolik',
                                                    'Hindu' => 'Hindu',
                                                    'Buddha' => 'Buddha',
                                                    'Konghucu' => 'Konghucu',
                                                ])
                                                ->default('Islam')
                                                ->required()
                                                ->native(false),

                                            TextInput::make('student_phone')
                                                ->label('No. WhatsApp Siswa')
                                                ->tel()
                                                ->prefixIcon('heroicon-o-chat-bubble-left-ellipsis')
                                                ->placeholder('Contoh: 6281234567890'),

                                            TextInput::make('student_email')
                                                ->label('Alamat Email Siswa')
                                                ->email()
                                                ->prefixIcon('heroicon-o-envelope')
                                                ->placeholder('siswa@gmail.com'),
                                        ]),

                                        Textarea::make('address')
                                            ->label('Alamat Lengkap Domisili Siswa')
                                            ->rows(3)
                                            ->required()
                                            ->placeholder('Nama Jalan, RT/RW, No. Rumah, Kelurahan, Kecamatan, Kota/Kabupaten, Kode Pos')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // ==========================================
                        // TAB 2: DATA ORANG TUA & WALI
                        // ==========================================
                        Tab::make('Orang Tua & Wali')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Section::make('Data Orang Tua (Ayah / Ibu)')
                                    ->description('Kontak utama penanggung jawab calon siswa')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            TextInput::make('parent_name')
                                                ->label('Nama Lengkap Orang Tua')
                                                ->required()
                                                ->prefixIcon('heroicon-o-user')
                                                ->placeholder('Nama Ayah atau Ibu'),

                                            TextInput::make('parent_phone')
                                                ->label('Nomor WhatsApp Orang Tua')
                                                ->tel()
                                                ->required()
                                                ->prefixIcon('heroicon-o-phone')
                                                ->placeholder('Contoh: 6281234567890')
                                                ->helperText('Nomor aktif untuk verifikasi dan konfirmasi berkas'),

                                            TextInput::make('parent_job')
                                                ->label('Pekerjaan Orang Tua')
                                                ->prefixIcon('heroicon-o-briefcase')
                                                ->placeholder('PNS / Swasta / Wiraswasta / dll.'),
                                        ]),

                                        Textarea::make('parent_address')
                                            ->label('Alamat Orang Tua (jika berbeda dari siswa)')
                                            ->rows(2)
                                            ->placeholder('Kosongkan jika alamat sama dengan tempat tinggal siswa')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Data Wali Murid (Opsional)')
                                    ->description('Hanya diisi jika calon siswa tinggal bersama wali selain orang tua kandung')
                                    ->collapsible()
                                    ->schema([
                                        Grid::make(3)->schema([
                                            TextInput::make('guardian_name')
                                                ->label('Nama Lengkap Wali')
                                                ->prefixIcon('heroicon-o-user')
                                                ->placeholder('Kosongkan jika tinggal bersama orang tua'),

                                            TextInput::make('guardian_phone')
                                                ->label('Nomor WhatsApp Wali')
                                                ->tel()
                                                ->prefixIcon('heroicon-o-phone')
                                                ->placeholder('Contoh: 6281234567890'),

                                            TextInput::make('guardian_relationship')
                                                ->label('Hubungan dengan Siswa')
                                                ->placeholder('Contoh: Paman, Kakek, Kakak Kandung'),
                                        ]),

                                        Textarea::make('guardian_address')
                                            ->label('Alamat Lengkap Wali')
                                            ->rows(2)
                                            ->placeholder('Alamat domisili tempat tinggal wali')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // ==========================================
                        // TAB 3: BERKAS & DOKUMEN PERSYARATAN
                        // ==========================================
                        Tab::make('Berkas & Dokumen')
                            ->icon('heroicon-o-document-duplicate')
                            ->schema([
                                Section::make('Dokumen Persyaratan Calon Siswa')
                                    ->description('Unggah dokumen dalam format PDF atau Gambar (JPG/PNG). Maksimal 3MB - 5MB per dokumen.')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            FileUpload::make('family_card_file')
                                                ->label('Kartu Keluarga (KK)')
                                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                                                ->disk('local')
                                                ->visibility('private')
                                                ->directory('ppdb/kk')
                                                ->maxSize(3072)
                                                ->helperText('Format PDF atau JPG/PNG, maks. 3MB'),

                                            FileUpload::make('birth_certificate_file')
                                                ->label('Akta Kelahiran')
                                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                                                ->disk('local')
                                                ->visibility('private')
                                                ->directory('ppdb/akta')
                                                ->maxSize(3072)
                                                ->helperText('Format PDF atau JPG/PNG, maks. 3MB'),

                                            FileUpload::make('graduation_certificate_file')
                                                ->label('Ijazah / SKL SMP')
                                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                                                ->disk('local')
                                                ->visibility('private')
                                                ->directory('ppdb/ijazah')
                                                ->maxSize(3072)
                                                ->helperText('Format PDF atau JPG/PNG, maks. 3MB'),

                                            FileUpload::make('achievement_certificate_file')
                                                ->label('Piagam Prestasi / Sertifikat Kejuaraan (Opsional)')
                                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                                                ->disk('local')
                                                ->visibility('private')
                                                ->directory('ppdb/prestasi')
                                                ->maxSize(5120)
                                                ->helperText('Piagam kejuaraan akademik, tahfidz, atau non-akademik (maks. 5MB)'),
                                        ]),
                                    ]),
                            ]),

                        // ==========================================
                        // TAB 4: STATUS & HASIL VERIFIKASI
                        // ==========================================
                        Tab::make('Status & Verifikasi')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->schema([
                                Section::make('Informasi Status Pendaftaran')
                                    ->description('Pengaturan kelulusan dan catatan verifikasi panitia')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            TextInput::make('registration_number')
                                                ->label('Nomor Registrasi')
                                                ->disabled()
                                                ->dehydrated(false)
                                                ->placeholder('Dibuat otomatis oleh sistem')
                                                ->prefixIcon('heroicon-o-hashtag'),

                                            TextInput::make('academic_year')
                                                ->label('Tahun Ajaran')
                                                ->default('2026/2027')
                                                ->required()
                                                ->prefixIcon('heroicon-o-calendar'),

                                            Select::make('status')
                                                ->label('Status Hasil Seleksi')
                                                ->options([
                                                    'pending' => 'Pending (Menunggu Verifikasi)',
                                                    'verified' => 'Diverifikasi (Berkas Valid)',
                                                    'accepted' => 'Lulus (Diterima)',
                                                    'rejected' => 'Tidak Lulus / Ditolak',
                                                ])
                                                ->default('pending')
                                                ->required()
                                                ->native(false),
                                        ]),

                                        Textarea::make('verification_notes')
                                            ->label('Catatan Panitia / Alasan Verifikasi')
                                            ->rows(4)
                                            ->placeholder('Tuliskan catatan berkas, informasi kelulusan, atau catatan revisi jika berkas belum lengkap...')
                                            ->helperText('Catatan ini dapat dibaca oleh staf dan dijadikan rujukan saat konfirmasi WhatsApp ke wali murid')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
