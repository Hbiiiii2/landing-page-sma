<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PpdbRegistrations\PpdbRegistrationResource;
use App\Models\PpdbRegistration;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestApplicantsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PpdbRegistration::query()->latest()->limit(5)
            )
            ->heading('Pendaftar PPDB Terbaru')
            ->columns([
                TextColumn::make('registration_number')
                    ->label('No. Registrasi')
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('full_name')
                    ->label('Nama Calon Siswa')
                    ->weight('semibold')
                    ->description(fn (PpdbRegistration $record): string => 'SMP: ' . ($record->origin_school ?? '-')),

                TextColumn::make('gender')
                    ->label('L/P')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan')
                    ->color(fn (string $state): string => $state === 'L' ? 'info' : 'danger'),

                TextColumn::make('parent_name')
                    ->label('Orang Tua')
                    ->description(fn (PpdbRegistration $record): string => $record->parent_phone),

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
                    ->label('Waktu Daftar')
                    ->dateTime('d M Y, H:i'),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn (PpdbRegistration $record): string => PpdbRegistrationResource::getUrl('view', ['record' => $record])),

                Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(function (PpdbRegistration $record) {
                        $record->update([
                            'status' => 'verified',
                            'verified_at' => now(),
                            'verified_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Pendaftar Diverifikasi')
                            ->body("{$record->full_name} berhasil diverifikasi.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (PpdbRegistration $record): bool => $record->status === 'pending'),
            ]);
    }
}
