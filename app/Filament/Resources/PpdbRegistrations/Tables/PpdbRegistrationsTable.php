<?php

namespace App\Filament\Resources\PpdbRegistrations\Tables;

use App\Models\PpdbRegistration;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PpdbRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration_number')
                    ->label('No. Registrasi')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('full_name')
                    ->label('Nama Calon Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->description(fn (PpdbRegistration $record): string => 'SMP: ' . ($record->origin_school ?? '-')),

                TextColumn::make('gender')
                    ->label('L/P')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan')
                    ->color(fn (string $state): string => $state === 'L' ? 'info' : 'danger'),

                TextColumn::make('parent_name')
                    ->label('Orang Tua / No. WA')
                    ->searchable()
                    ->description(fn (PpdbRegistration $record): string => $record->parent_phone),

                TextColumn::make('academic_year')
                    ->label('Tahun Ajaran')
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'verified' => 'Diverifikasi',
                        'accepted' => 'Lulus',
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

                TextColumn::make('created_at')
                    ->label('Tgl Daftar')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pendaftaran')
                    ->options([
                        'pending' => 'Pending (Menunggu Verifikasi)',
                        'verified' => 'Diverifikasi',
                        'accepted' => 'Lulus',
                        'rejected' => 'Tidak Lulus',
                    ]),

                SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),

                SelectFilter::make('academic_year')
                    ->label('Tahun Ajaran')
                    ->options(fn () => PpdbRegistration::distinct()->pluck('academic_year', 'academic_year')->toArray()),
            ])
            ->headerActions([
                Action::make('export_csv')
                    ->label('Export Rekap (CSV)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function (): StreamedResponse {
                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => 'attachment; filename="rekap-ppdb-' . date('Y-m-d_His') . '.csv"',
                        ];

                        return response()->stream(function () {
                            $output = fopen('php://output', 'w');
                            // BOM for UTF-8 Excel support
                            fputs($output, "\xEF\xBB\xBF");
                            fputcsv($output, ['No', 'No. Registrasi', 'Tahun Ajaran', 'Nama Calon Siswa', 'NIK', 'NISN', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Alamat', 'Asal SMP', 'No WA Siswa', 'Nama Orang Tua', 'No WA Ortu', 'Nama Wali', 'Status', 'Catatan Verifikasi', 'Tgl Daftar']);

                            $records = PpdbRegistration::latest()->get();
                            $no = 1;
                            foreach ($records as $row) {
                                fputcsv($output, [
                                    $no++,
                                    $row->registration_number,
                                    $row->academic_year,
                                    $row->full_name,
                                    $row->nik ?? '-',
                                    $row->nisn ?? '-',
                                    $row->gender === 'L' ? 'Laki-laki' : 'Perempuan',
                                    $row->birth_place,
                                    $row->birth_date ? $row->birth_date->format('Y-m-d') : '-',
                                    $row->religion,
                                    $row->address,
                                    $row->origin_school ?? '-',
                                    $row->student_phone ?? '-',
                                    $row->parent_name,
                                    $row->parent_phone,
                                    $row->guardian_name ?? '-',
                                    ucfirst($row->status),
                                    $row->verification_notes ?? '-',
                                    $row->created_at ? $row->created_at->format('Y-m-d H:i') : '-',
                                ]);
                            }
                            fclose($output);
                        }, 200, $headers);
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Pendaftar')
                    ->modalDescription('Apakah Anda yakin dokumen dan data pendaftar ini sudah valid?')
                    ->action(function (PpdbRegistration $record) {
                        $record->update([
                            'status' => 'verified',
                            'verified_at' => now(),
                            'verified_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Status Berhasil Diperbarui')
                            ->body("Pendaftar {$record->full_name} berhasil diverifikasi.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (PpdbRegistration $record): bool => $record->status === 'pending'),

                Action::make('accept')
                    ->label('Luluskan')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Luluskan Siswa')
                    ->modalDescription('Siswa ini akan dinyatakan DITERIMA / LULUS seleksi PPDB.')
                    ->action(function (PpdbRegistration $record) {
                        $record->update([
                            'status' => 'accepted',
                            'verified_at' => now(),
                            'verified_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Siswa Dinyatakan Lulus')
                            ->body("{$record->full_name} resmi diterima sebagai peserta didik baru.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (PpdbRegistration $record): bool => in_array($record->status, ['pending', 'verified'])),

                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Textarea::make('verification_notes')
                            ->label('Alasan Penolakan / Dokumen Kurang')
                            ->placeholder('Contoh: Ijazah tidak terbaca atau kuota telah penuh.')
                            ->required(),
                    ])
                    ->action(function (PpdbRegistration $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'verification_notes' => $data['verification_notes'],
                            'verified_at' => now(),
                            'verified_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Pendaftar Ditolak')
                            ->body("Status pendaftar diubah menjadi Tidak Lulus.")
                            ->danger()
                            ->send();
                    })
                    ->visible(fn (PpdbRegistration $record): bool => $record->status !== 'rejected'),

                Action::make('chat_wa')
                    ->label('Chat WA')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (PpdbRegistration $record): string => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->parent_phone), true),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
