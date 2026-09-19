<?php

namespace App\Filament\Resources\YoutubeVideos;

use App\Filament\Resources\YoutubeVideos\Pages\CreateYoutubeVideo;
use App\Filament\Resources\YoutubeVideos\Pages\EditYoutubeVideo;
use App\Filament\Resources\YoutubeVideos\Pages\ListYoutubeVideos;
use App\Filament\Resources\YoutubeVideos\Schemas\YoutubeVideoForm;
use App\Filament\Resources\YoutubeVideos\Tables\YoutubeVideosTable;
use App\Models\YoutubeVideo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class YoutubeVideoResource extends Resource
{
    protected static ?string $model = YoutubeVideo::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;
    protected static ?string $navigationLabel = 'Dokumentasi Video YouTube';
    protected static ?string $modelLabel = 'Video YouTube';
    protected static ?string $pluralModelLabel = 'Video YouTube';
    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return YoutubeVideoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return YoutubeVideosTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListYoutubeVideos::route('/'),
            'create' => CreateYoutubeVideo::route('/create'),
            'edit' => EditYoutubeVideo::route('/{record}/edit'),
        ];
    }
}
