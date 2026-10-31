<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PpdbRegistrationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ==========================================
                // HEADER BANNER: RINGKASAN PROFIL PENDAFTAR
                // ==========================================
                Section::make('Ringkasan Calon Siswa')
                    ->schema([
                        Grid::make(12)->schema([
                            ImageEntry::make('student_photo_file')
                                ->label('Pas Foto')
                                ->placeholder('Tidak ada foto')
                                ->height(150)
                                ->columnSpan(['default' => 12, 'sm' => 3])
                                ->getStateUsing(fn ($record) => $record && $record->student_photo_file ? route('admin.ppdb.document', ['registration' => $record->id, 'field' => 'student_photo_file']) : null),

                            Grid::make(3)
                                ->columnSpan(['default' => 12, 'sm' => 9])
                                ->schema([
                                    TextEntry::make('full_name')
                                        ->label('Nama Lengkap Siswa')
                                        ->weight('bold')
                                        ->size('lg'),

                                    TextEntry::make('registration_number')
                                        ->label('No. Registrasi')
                                        ->badge()
                                        ->color('primary')
                                        ->copyable(),

                                    TextEntry::make('status')
                                        ->label('Status Seleksi')
                                        ->badge()
                                        ->formatStateUsing(fn (string $state): string => match ($state) {
                                            'pending' => 'Pending (Verifikasi)',
                                            'verified' => 'Diverifikasi',
                                            'accepted' => 'Lulus (Diterima)',
                                            'rejected' => 'Tidak Lulus',
                                            default => $state,
                                        })
                                        ->color(fn (string $state): string => match ($state) {
                                            'pending' => 'warning',
                                            'verified' => 'info',
                                            'accepted' => 'success',
                                            'rejected' => 'danger',
                                            default => 'gray',
                                        }),

                                    TextEntry::make('origin_school')
                                        ->label('Asal Sekolah (SMP/MTs)')
                                        ->icon('heroicon-o-academic-cap')
                                        ->placeholder('-'),

                                    TextEntry::make('academic_year')
                                        ->label('Tahun Ajaran')
                                        ->icon('heroicon-o-calendar'),

                                    TextEntry::make('created_at')
                                        ->label('Waktu Mendaftar')
                                        ->dateTime('d F Y, H:i')
                                        ->icon('heroicon-o-clock'),
                                ]),
                        ]),
                    ]),

                // ==========================================
                // TABS DETAIL LENGKAP
                // ==========================================
                Tabs::make('Detail Pendaftaran')
                    ->columnSpanFull()
                    ->tabs([
                        // TAB 1: IDENTITAS SISWA
                        Tab::make('Data Calon Siswa')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Data Kependudukan & Pribadi')
                                    ->schema([
                                        Grid::make(4)->schema([
                                            TextEntry::make('nisn')
                                                ->label('NISN')
                                                ->icon('heroicon-o-identification')
                                                ->copyable()
                                                ->placeholder('-'),

                                            TextEntry::make('nik')
                                                ->label('NIK Siswa')
                                                ->icon('heroicon-o-identification')
                                                ->copyable()
                                                ->placeholder('-'),

                                            TextEntry::make('gender')
                                                ->label('Jenis Kelamin')
                                                ->badge()
                                                ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan')
                                                ->color(fn (string $state): string => $state === 'L' ? 'info' : 'success'),

                                            TextEntry::make('religion')
                                                ->label('Agama')
                                                ->placeholder('-'),

                                            TextEntry::make('birth_place')
                                                ->label('Tempat Lahir'),

                                            TextEntry::make('birth_date')
                                                ->label('Tanggal Lahir')
                                                ->date('d F Y'),

                                            TextEntry::make('student_phone')
                                                ->label('WhatsApp Siswa')
                                                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                                ->url(fn ($state) => $state ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $state) : null, true)
                                                ->color('primary')
                                                ->placeholder('-'),

                                            TextEntry::make('student_email')
                                                ->label('Email Siswa')
                                                ->icon('heroicon-o-envelope')
                                                ->placeholder('-'),
                                        ]),
                                    ]),

                                Section::make('Alamat Domisili')
                                    ->schema([
                                        TextEntry::make('address')
                                            ->label('Alamat Lengkap Tempat Tinggal Siswa')
                                            ->icon('heroicon-o-map-pin'),
                                    ]),
                            ]),

                        // TAB 2: ORANG TUA & WALI
                        Tab::make('Orang Tua & Wali')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Section::make('Data Orang Tua (Ayah / Ibu)')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            TextEntry::make('parent_name')
                                                ->label('Nama Lengkap Orang Tua')
                                                ->weight('bold')
                                                ->icon('heroicon-o-user'),

                                            TextEntry::make('parent_phone')
                                                ->label('WhatsApp Orang Tua')
                                                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                                ->url(fn ($state) => $state ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $state) : null, true)
                                                ->color('success')
                                                ->copyable(),

                                            TextEntry::make('parent_job')
                                                ->label('Pekerjaan Orang Tua')
                                                ->icon('heroicon-o-briefcase')
                                                ->placeholder('-'),
                                        ]),

                                        TextEntry::make('parent_address')
                                            ->label('Alamat Orang Tua')
                                            ->placeholder('Sama dengan alamat domisili siswa'),
                                    ]),

                                Section::make('Data Wali Murid')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            TextEntry::make('guardian_name')
                                                ->label('Nama Wali')
                                                ->icon('heroicon-o-user')
                                                ->placeholder('Tinggal bersama orang tua'),

                                            TextEntry::make('guardian_phone')
                                                ->label('WhatsApp Wali')
                                                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                                ->url(fn ($state) => $state ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $state) : null, true)
                                                ->color('primary')
                                                ->placeholder('-'),

                                            TextEntry::make('guardian_relationship')
                                                ->label('Hubungan dengan Siswa')
                                                ->placeholder('-'),
                                        ]),

                                        TextEntry::make('guardian_address')
                                            ->label('Alamat Wali')
                                            ->placeholder('-'),
                                    ]),
                            ]),

                        // TAB 3: BERKAS & DOKUMEN
                        Tab::make('Berkas & Dokumen')
                            ->icon('heroicon-o-document-duplicate')
                            ->schema([
                                Section::make('Dokumen Persyaratan')
                                    ->description('Klik dokumen untuk membuka pratinjau file (PDF atau Gambar) di tab baru browser')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextEntry::make('family_card_file')
                                                ->label('Kartu Keluarga (KK)')
                                                ->formatStateUsing(fn ($state) => $state ? '📄 Buka Dokumen Kartu Keluarga (KK)' : '❌ Belum Diunggah')
                                                ->url(fn ($record) => $record && $record->family_card_file ? route('admin.ppdb.document', ['registration' => $record->id, 'field' => 'family_card_file']) : null, true)
                                                ->color(fn ($state) => $state ? 'primary' : 'danger')
                                                ->icon('heroicon-o-document-text'),

                                            TextEntry::make('birth_certificate_file')
                                                ->label('Akta Kelahiran')
                                                ->formatStateUsing(fn ($state) => $state ? '📄 Buka Dokumen Akta Kelahiran' : '❌ Belum Diunggah')
                                                ->url(fn ($record) => $record && $record->birth_certificate_file ? route('admin.ppdb.document', ['registration' => $record->id, 'field' => 'birth_certificate_file']) : null, true)
                                                ->color(fn ($state) => $state ? 'primary' : 'danger')
                                                ->icon('heroicon-o-document-text'),

                                            TextEntry::make('graduation_certificate_file')
                                                ->label('Ijazah / SKL SMP')
                                                ->formatStateUsing(fn ($state) => $state ? '📄 Buka Dokumen Ijazah / SKL' : '❌ Belum Diunggah')
                                                ->url(fn ($record) => $record && $record->graduation_certificate_file ? route('admin.ppdb.document', ['registration' => $record->id, 'field' => 'graduation_certificate_file']) : null, true)
                                                ->color(fn ($state) => $state ? 'primary' : 'danger')
                                                ->icon('heroicon-o-document-text'),

                                            TextEntry::make('achievement_certificate_file')
                                                ->label('Piagam Prestasi / Sertifikat')
                                                ->formatStateUsing(fn ($state) => $state ? '🏆 Buka Dokumen Piagam Prestasi' : 'Tidak ada sertifikat (Opsional)')
                                                ->url(fn ($record) => $record && $record->achievement_certificate_file ? route('admin.ppdb.document', ['registration' => $record->id, 'field' => 'achievement_certificate_file']) : null, true)
                                                ->color(fn ($state) => $state ? 'primary' : 'gray')
                                                ->icon('heroicon-o-trophy'),
                                        ]),
                                    ]),
                            ]),

                        // TAB 4: STATUS & CATATAN VERIFIKASI
                        Tab::make('Status & Catatan')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->schema([
                                Section::make('Riwayat & Catatan Panitia')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextEntry::make('status')
                                                ->label('Status Hasil Seleksi Saat Ini')
                                                ->badge()
                                                ->formatStateUsing(fn (string $state): string => match ($state) {
                                                    'pending' => 'Pending (Menunggu Verifikasi)',
                                                    'verified' => 'Diverifikasi (Berkas Lengkap)',
                                                    'accepted' => 'Lulus (Diterima)',
                                                    'rejected' => 'Tidak Lulus (Ditolak)',
                                                    default => $state,
                                                })
                                                ->color(fn (string $state): string => match ($state) {
                                                    'pending' => 'warning',
                                                    'verified' => 'info',
                                                    'accepted' => 'success',
                                                    'rejected' => 'danger',
                                                    default => 'gray',
                                                }),

                                            TextEntry::make('updated_at')
                                                ->label('Terakhir Diperbarui')
                                                ->dateTime('d F Y, H:i')
                                                ->icon('heroicon-o-clock'),
                                        ]),

                                        TextEntry::make('verification_notes')
                                            ->label('Catatan Panitia / Alasan Verifikasi')
                                            ->placeholder('Belum ada catatan dari panitia verifikator')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
