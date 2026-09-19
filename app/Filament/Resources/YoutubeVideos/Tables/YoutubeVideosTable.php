<?php

namespace App\Filament\Resources\YoutubeVideos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class YoutubeVideosTable
{
    public static function configure(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            TextColumn::make('sort_order')->label('Urutan')->sortable(),
            TextColumn::make('title')->label('Judul')->searchable()->wrap(),
            TextColumn::make('category')->label('Kategori')->badge()->color('info'),
            TextColumn::make('youtube_url')->label('URL YouTube')->limit(50)->copyable(),
            IconColumn::make('is_published')->label('Tampil')->boolean(),
            TextColumn::make('updated_at')->label('Diperbarui')->dateTime('d M Y H:i')->sortable(),
        ])->recordActions([
            EditAction::make(),
        ])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
