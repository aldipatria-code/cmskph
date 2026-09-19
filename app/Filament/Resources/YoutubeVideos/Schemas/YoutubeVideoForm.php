<?php

namespace App\Filament\Resources\YoutubeVideos\Schemas;

use App\Models\Gallery;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class YoutubeVideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi video')->schema([
                TextInput::make('title')
                    ->label('Judul video')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('youtube_url')
                    ->label('URL YouTube')
                    ->url()
                    ->required()
                    ->maxLength(2048)
                    ->rules(['regex:~^https?://(www\.)?(youtube\.com|youtu\.be)/~i'])
                    ->helperText('Gunakan URL video YouTube, contoh https://www.youtube.com/watch?v=xxxxxxxxxxx.')
                    ->columnSpanFull(),
                Select::make('category')
                    ->label('Kategori video')
                    ->options(array_combine(Gallery::categories(), Gallery::categories()))
                    ->searchable()
                    ->native(false)
                    ->placeholder('Pilih kategori')
                    ->columnSpan(1),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->maxLength(1000)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->label('Urutan tampil')
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->default(0)
                    ->required(),
                Toggle::make('is_published')
                    ->label('Tampilkan di beranda')
                    ->default(true),
            ])->columns(2),
        ]);
    }
}
