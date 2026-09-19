<?php

namespace App\Filament\Resources\CommunityMembers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CommunityMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nama lengkap')->required(),
            TextInput::make('email')
                ->email()
                ->required()
                ->placeholder('nama@email.com'),
            TextInput::make('age')
                ->label('Umur')
                ->numeric()
                ->required()
                ->minValue(1)
                ->maxValue(120),
            Select::make('hepatitis_status')
                ->label('Riwayat hepatitis')
                ->options([
                    'none' => 'Tidak ada',
                    'hepatitis_a' => 'Hepatitis A',
                    'hepatitis_b' => 'Hepatitis B',
                    'hepatitis_c' => 'Hepatitis C',
                    'multiple' => 'Lebih dari satu jenis',
                ])
                ->formatStateUsing(function ($record): ?string {
                    if (! $record) {
                        return 'none';
                    }

                    $types = collect(['a', 'b', 'c'])
                        ->filter(fn (string $type): bool => (bool) $record->{'hepatitis_'.$type})
                        ->values();

                    return match ($types->count()) {
                        0 => 'none',
                        1 => 'hepatitis_'.$types->first(),
                        default => 'multiple',
                    };
                })
                ->dehydrated(false)
                ->disabled(),
            Toggle::make('hepatitis_a')->label('Terjangkit Hepatitis A'),
            Toggle::make('hepatitis_b')->label('Terjangkit Hepatitis B'),
            Toggle::make('hepatitis_c')->label('Terjangkit Hepatitis C'),
            TextInput::make('phone')
                ->label('Nomor WhatsApp')
                ->rules(['digits_between:8,15'])
                ->placeholder('08xxxxxxxxxx')
                ->helperText('Masukkan angka saja, 8-15 digit.'),
            TextInput::make('city')->label('Kota domisili'),
            TextInput::make('occupation')->label('Pekerjaan'),
            Select::make('status')
                ->options([
                    'pending' => 'Menunggu ditinjau',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ])
                ->required()
                ->native(false),
            Textarea::make('reason')->label('Alasan bergabung')->columnSpanFull(),
            Textarea::make('admin_notes')->label('Catatan admin')->columnSpanFull(),
            Toggle::make('consent')->label('Menyetujui pemrosesan data')->disabled(),
        ]);
    }
}
