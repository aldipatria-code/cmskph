<?php

namespace App\Filament\Resources\GalleryCategories\Schemas;

use App\Models\GalleryCategory;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set as UtilitiesSet;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class GalleryCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi kategori')->schema([
                TextInput::make('name')
                    ->label('Nama kategori')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (UtilitiesSet $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->unique(GalleryCategory::class, 'name', ignoreRecord: true)
                    ->maxLength(100),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(GalleryCategory::class, 'slug', ignoreRecord: true)
                    ->maxLength(120),
                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->default(0)
                    ->required(),
                Toggle::make('is_active')
                    ->label('Aktif di galeri publik')
                    ->default(true),
            ])->columns(2),
        ]);
    }
}
