<?php

namespace App\Filament\Resources\PpdbRegistrations\Pages;

use App\Filament\Resources\PpdbRegistrations\PpdbRegistrationResource;
use App\Models\PpdbRegistration;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewPpdbRegistration extends ViewRecord
{
    protected static string $resource = PpdbRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('verify')
                ->label('Verifikasi Berkas')
                ->icon('heroicon-o-check-circle')
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Verifikasi Pendaftar')
                ->modalDescription('Apakah Anda yakin dokumen dan data pendaftar ini sudah lengkap dan valid?')
                ->action(function (PpdbRegistration $record) {
                    $record->update([
                        'status' => 'verified',
                        'verified_at' => now(),
                        'verified_by' => auth()->id(),
                    ]);

                    Notification::make()
                        ->title('Status Berhasil Diverifikasi')
                        ->body("Pendaftar {$record->full_name} berhasil diverifikasi.")
                        ->success()
                        ->send();
                })
                ->visible(fn (PpdbRegistration $record): bool => $record->status === 'pending'),

            Action::make('accept')
                ->label('Luluskan / Terima')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Luluskan Siswa Baru')
                ->modalDescription('Siswa ini akan dinyatakan DITERIMA / LULUS seleksi PPDB SMA Al-Madinah.')
                ->action(function (PpdbRegistration $record) {
                    $record->update([
                        'status' => 'accepted',
                        'verified_at' => now(),
                        'verified_by' => auth()->id(),
                    ]);

                    Notification::make()
                        ->title('Siswa Resmi Diterima')
                        ->body("{$record->full_name} dinyatakan Lulus seleksi.")
                        ->success()
                        ->send();
                })
                ->visible(fn (PpdbRegistration $record): bool => in_array($record->status, ['pending', 'verified'])),

            Action::make('reject')
                ->label('Tolak Pendaftar')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->form([
                    Textarea::make('verification_notes')
                        ->label('Alasan Penolakan / Dokumen Belum Sesuai')
                        ->placeholder('Contoh: Ijazah tidak terbaca atau persyaratan tidak sesuai.')
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
                ->label('Hubungi WhatsApp Ortu')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('success')
                ->url(function (PpdbRegistration $record): string {
                    $phone = preg_replace('/[^0-9]/', '', $record->parent_phone);
                    $text = urlencode("Assalamu'alaikum Wr. Wb. Bpk/Ibu wali dari ananda *{$record->full_name}* (No. Registrasi: *{$record->registration_number}*). Kami dari Panitia PPDB SMA Al-Madinah menginformasikan terkait pendaftaran...");
                    return "https://wa.me/{$phone}?text={$text}";
                }, true),

            EditAction::make()
                ->label('Edit Data'),
        ];
    }
}
