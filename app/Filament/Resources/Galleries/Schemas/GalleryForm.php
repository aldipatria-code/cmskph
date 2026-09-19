<?php

namespace App\Filament\Resources\Galleries\Schemas;

use App\Models\Gallery;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set as UtilitiesSet;
use Illuminate\Support\Str;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi kegiatan')
                ->schema([
                    TextInput::make('title')
                        ->label('Judul kegiatan')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (UtilitiesSet $set, ?string $state) => $set('slug', Str::slug($state)))
                        ->maxLength(255),
                    TextInput::make('slug')
                        ->required()
                        ->unique(Gallery::class, 'slug', ignoreRecord: true)
                        ->maxLength(255),
                    Select::make('category')
                        ->label('Kategori kegiatan')
                        ->options(array_combine(Gallery::categories(), Gallery::categories()))
                        ->searchable()
                        ->required(),
                    DatePicker::make('event_date')
                        ->label('Tanggal kegiatan')
                        ->native(false),
                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),
            Section::make('Media dan publikasi')
                ->description('Kelola foto utama dan koleksi foto tambahan untuk slider halaman detail kegiatan.')
                ->schema([
                    FileUpload::make('image_path')
                        ->label('Foto kegiatan')
                        ->image()
                        ->disk('public')
                        ->directory('gallery')
                        ->visibility('public')
                        ->imageEditor()
                        ->required()
                        ->maxSize(4096)
                        ->imagePreviewHeight('180')
                        ->helperText('Foto utama yang tampil sebagai sampul kegiatan. Maksimal 4 MB.')
                        ->columnSpan(1),
                    FileUpload::make('additional_images')
                        ->label('Foto tambahan kegiatan (slider)')
                        ->multiple()
                        ->reorderable()
                        ->image()
                        ->disk('public')
                        ->directory('gallery')
                        ->visibility('public')
                        ->imageEditor()
                        ->panelLayout('grid')
                        ->imagePreviewHeight('120')
                        ->maxFiles(50)
                        ->maxSize(4096)
                        ->helperText('Opsional. Maksimal 50 foto, masing-masing 4 MB. Seret thumbnail untuk mengatur urutan.')
                        ->columnSpan(1),
                    Toggle::make('is_published')
                        ->label('Tampilkan di galeri publik')
                        ->default(true),
                ])
                ->columns([
                    'default' => 1,
                    'lg' => 2,
                ]),
        ]);
    }
}
