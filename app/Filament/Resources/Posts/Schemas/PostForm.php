<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Forms\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set as UtilitiesSet;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Post Details')
                    ->tabs([
                        // TAB 1: KONTEN UTAMA
                        Tabs\Tab::make('Main Content')
                            ->icon('heroicon-m-pencil-square')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (UtilitiesSet $set, ?string $state) => $set('slug', Str::slug($state)))
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->required()
                                    ->unique(Post::class, 'slug', ignoreRecord: true)
                                    ->maxLength(255),

                                FileUpload::make('cover_image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('posts-covers')
                                    ->visibility('public')
                                    ->columnSpanFull(),

                                RichEditor::make('content')
                                    ->required()
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'attachFiles', 'blockquote', 'bold', 'bulletList', 'codeBlock',
                                        'h2', 'h3', 'italic', 'link', 'orderedList', 'redo', 'undo',
                                    ]),
                            ])->columns(2),

                        // TAB 2: SEO & METADATA
                        Tabs\Tab::make('SEO Optimization')
                            ->icon('heroicon-m-globe-alt')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->placeholder('Kosongkan jika ingin menggunakan judul utama')
                                    ->maxLength(70),

                                Textarea::make('meta_description')
                                    ->helperText('Gunakan 150-160 karakter agar optimal di Google.')
                                    ->maxLength(160),

                                TextInput::make('meta_keywords')
                                    ->placeholder('kata, kunci, berita'),
                            ]),
                    ])->columnSpan(2),

                // SIDEBAR / KOLOM KANAN
                Section::make('Publishing Details')
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('tags')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->preload(),

                        Select::make('status')
                            ->options([
                                1 => 'Draft',
                                2 => 'Pending Review',
                                3 => 'Published',
                                4 => 'Rejected',
                            ])
                            ->required()
                            // Logika: Hanya Admin/Redaktur yang bisa ubah status dari Pending ke Published
                            ->disabled(fn () => !auth()->user()->hasRole(['admin', 'redaktur']))
                            ->default(1),

                        Textarea::make('editor_notes')
                            ->label('Catatan Redaktur')
                            ->visible(fn () => auth()->user()->hasRole(['admin', 'redaktur'])),

                        DateTimePicker::make('published_at')
                            ->label('Jadwal Tayang'),

                        Hidden::make('user_id')
                            ->default(auth()->id()),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
