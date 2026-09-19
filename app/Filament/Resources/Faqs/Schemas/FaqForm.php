<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('question')
                ->label('Pertanyaan')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            Textarea::make('answer')
                ->label('Jawaban')
                ->required()
                ->rows(8)
                ->maxLength(5000)
                ->columnSpanFull(),
            TextInput::make('sort_order')
                ->label('Urutan tampil')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->helperText('Angka lebih kecil tampil lebih dahulu.'),
            Toggle::make('is_published')
                ->label('Tampilkan di halaman FAQ')
                ->default(true),
        ]);
    }
}
