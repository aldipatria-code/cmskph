<?php

namespace App\Filament\Resources\CommunityMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class CommunityMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('age')->label('Umur')->suffix(' tahun')->sortable(),
                TextColumn::make('hepatitis_types')
                    ->label('Hepatitis')
                    ->state(function ($record): string {
                        $types = collect(['a', 'b', 'c'])
                            ->filter(fn (string $type): bool => (bool) $record->{'hepatitis_'.$type})
                            ->map(fn (string $type): string => 'Hepatitis '.strtoupper($type))
                            ->values();

                        return $types->isEmpty() ? 'Tidak ada' : $types->join(', ');
                    })
                    ->wrap(),
                TextColumn::make('phone')->label('WhatsApp'),
                TextColumn::make('city')->label('Kota')->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => 'Menunggu ditinjau',
                    }),
                TextColumn::make('created_at')->label('Mendaftar')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'pending' => 'Menunggu ditinjau',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ]),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
