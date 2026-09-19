<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use App\Models\Post;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class SiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string | UnitEnum | null $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Pengaturan Website';

    protected static ?string $title = 'Pengaturan Website';

    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public function mount(): void
    {
        $settings = SiteSetting::current();

        $this->form->fill([
            'site_name' => $settings->site_name,
            'logo_path' => $settings->logo_path,
            'login_logo_path' => $settings->login_logo_path,
            'footer_text' => $settings->footer_text,
            'social_links' => $settings->social_links,
            'hero_badge' => $settings->hero_badge ?: $settings->heroBadge(),
            'hero_title' => $settings->hero_title ?: $settings->heroTitle(),
            'hero_description' => $settings->hero_description ?: $settings->heroDescription(),
            'posts_section_label' => $settings->posts_section_label ?: $settings->postsSectionLabel(),
            'posts_section_title' => $settings->posts_section_title ?: $settings->postsSectionTitle(),
            'posts_section_description' => $settings->posts_section_description ?: $settings->postsSectionDescription(),
            'gallery_hero_badge' => $settings->galleryHeroBadge(),
            'gallery_hero_title' => $settings->galleryHeroTitle(),
            'gallery_hero_description' => $settings->galleryHeroDescription(),
            'gallery_hero_background_color' => $settings->galleryHeroBackgroundColor(),
            'faq_hero_badge' => $settings->faqHeroBadge(),
            'faq_hero_title' => $settings->faqHeroTitle(),
            'faq_hero_description' => $settings->faqHeroDescription(),
            'featured_post_id' => $settings->featuredPostId(),
            'hero_background_color' => $settings->heroBackgroundColor(),
            'hero_background_image' => $settings->hero_background_image,
            'hero_slides' => $settings->hero_slides ?? [],
            'about_title' => $settings->about_title ?: $settings->aboutTitle(),
            'about_description' => $settings->about_description ?: $settings->aboutDescription(),
            'about_background_color' => $settings->aboutBackgroundColor(),
            'about_background_image' => $settings->about_background_image,
            'help_widget_enabled' => $settings->helpWidgetEnabled(),
            'help_widget_badge' => $settings->help_widget_badge,
            'help_widget_title' => $settings->help_widget_title,
            'help_widget_description' => $settings->help_widget_description,
            'help_widget_whatsapp' => $settings->help_widget_whatsapp,
            'help_widget_email' => $settings->help_widget_email,
            'help_widget_faq_url' => $settings->help_widget_faq_url,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas website')
                    ->id('identitas-website')
                    ->description('Nama website dan logo yang digunakan pada area publik serta halaman login admin.')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nama website')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        FileUpload::make('logo_path')
                            ->label('Logo website')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Maksimal 2 MB. Tampil di navigasi website publik.')
                            ->columnSpan(1),
                        FileUpload::make('login_logo_path')
                            ->label('Logo halaman login')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Maksimal 2 MB. Tampil di halaman login admin.')
                            ->columnSpan(1),
                        Textarea::make('footer_text')
                            ->label('Teks footer')
                            ->required()
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->helperText('Placeholder yang tersedia: {year} untuk tahun saat ini dan {site_name} untuk nama website.'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
                Section::make('Media sosial')
                    ->id('media-sosial')
                    ->description('Tambahkan link media sosial yang ingin ditampilkan di bawah footer website.')
                    ->schema([
                        Repeater::make('social_links')
                            ->label('Link media sosial')
                            ->schema([
                                Select::make('label')
                                    ->label('Platform')
                                    ->options([
                                        'Facebook' => 'Facebook',
                                        'Instagram' => 'Instagram',
                                        'YouTube' => 'YouTube',
                                        'TikTok' => 'TikTok',
                                        'X' => 'X / Twitter',
                                        'LinkedIn' => 'LinkedIn',
                                        'WhatsApp' => 'WhatsApp',
                                        'Website' => 'Website lainnya',
                                    ])
                                    ->required()
                                    ->native(false),
                                TextInput::make('url')
                                    ->label('URL link')
                                    ->url()
                                    ->required()
                                    ->maxLength(2048)
                                    ->placeholder('https://...'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Tambah link media sosial')
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => filled($state['label'] ?? null) ? $state['label'] : 'Link media sosial baru')
                            ->helperText('Link yang diisi akan tampil sebagai tombol di bawah footer website.')
                            ->columnSpanFull(),
                    ]),
                Section::make('Tampilan beranda')
                    ->id('tampilan-beranda')
                    ->description('Atur pesan utama yang tampil pada banner beranda website.')
                    ->schema([
                        TextInput::make('hero_badge')
                            ->label('Label banner')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Komunitas kesehatan')
                            ->columnSpan(1),
                        TextInput::make('hero_title')
                            ->label('Judul banner')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Bersama peduli hepatitis.')
                            ->columnSpan(1),
                        Textarea::make('hero_description')
                            ->label('Deskripsi banner')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->placeholder('Tulis deskripsi singkat tentang komunitas Anda.'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
                Section::make('Tentang Kami')
                    ->id('tentang-kami')
                    ->description('Tulis informasi yang akan tampil pada halaman Tentang Kami di website publik.')
                    ->schema([
                        TextInput::make('about_title')
                            ->label('Judul Tentang Kami')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Tentang Komunitas Peduli Hepatitis')
                            ->columnSpanFull(),
                        Textarea::make('about_description')
                            ->label('Isi Tentang Kami')
                            ->required()
                            ->rows(7)
                            ->maxLength(5000)
                            ->placeholder('Tuliskan profil, tujuan, dan peran komunitas Anda.')
                            ->helperText('Gunakan paragraf sederhana untuk menjelaskan komunitas kepada pengunjung.')
                            ->columnSpanFull(),
                    ]),
                Section::make('Hero Galeri Kegiatan')
                    ->id('hero-galeri')
                    ->description('Atur teks, warna background, dan dua gambar yang tampil pada banner halaman Galeri Kegiatan.')
                    ->schema([
                        TextInput::make('gallery_hero_badge')
                            ->label('Label galeri')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(1),
                        TextInput::make('gallery_hero_title')
                            ->label('Judul galeri')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        Textarea::make('gallery_hero_description')
                            ->label('Deskripsi galeri')
                            ->required()
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        ColorPicker::make('gallery_hero_background_color')
                            ->label('Warna background galeri')
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
                Section::make('Hero FAQ')
                    ->id('hero-faq')
                    ->description('Atur teks yang tampil pada banner halaman FAQ di website publik.')
                    ->schema([
                        TextInput::make('faq_hero_badge')
                            ->label('Label FAQ')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(1),
                        TextInput::make('faq_hero_title')
                            ->label('Judul FAQ')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        Textarea::make('faq_hero_description')
                            ->label('Deskripsi FAQ')
                            ->required()
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
                Section::make('Background Tentang Kami')
                    ->id('background-tentang')
                    ->description('Atur warna atau upload gambar latar khusus untuk halaman Tentang Kami.')
                    ->schema([
                        ColorPicker::make('about_background_color')
                            ->label('Warna background')
                            ->required()
                            ->default('#f0fdfa')
                            ->helperText('Digunakan sebagai warna dasar dan fallback jika tidak ada gambar.'),
                        FileUpload::make('about_background_image')
                            ->label('Gambar background')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(4096)
                            ->helperText('Opsional. Maksimal 4 MB, disarankan gambar landscape.')
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
                Section::make('Background banner beranda')
                    ->id('background-beranda')
                    ->description('Atur warna atau gambar latar untuk banner utama di halaman beranda.')
                    ->schema([
                        ColorPicker::make('hero_background_color')
                            ->label('Warna background')
                            ->required()
                            ->default('#0f172a')
                            ->helperText('Digunakan sebagai warna dasar dan fallback jika tidak ada gambar.'),
                        FileUpload::make('hero_background_image')
                            ->label('Gambar background')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(4096)
                            ->helperText('Opsional. Maksimal 4 MB, disarankan gambar landscape.')
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
                Section::make('Slider gambar hero beranda')
                    ->id('slider-hero')
                    ->description('Tambahkan beberapa gambar untuk slider pada hero beranda. Urutkan slide dengan menyeret item.')
                    ->schema([
                        Repeater::make('hero_slides')
                            ->label('Slide gambar')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Gambar')
                                    ->image()
                                    ->disk('public')
                                    ->directory('branding/hero-slides')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->maxSize(4096)
                                    ->required(),
                                TextInput::make('badge')
                                    ->label('Label kecil')
                                    ->maxLength(100)
                                    ->placeholder('Komunitas kesehatan'),
                                TextInput::make('title')
                                    ->label('Judul gambar')
                                    ->maxLength(255)
                                    ->placeholder('Peduli bersama'),
                            ])
                            ->addActionLabel('Tambah slide')
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => filled($state['title'] ?? null) ? $state['title'] : 'Slide hero baru')
                            ->columnSpanFull()
                            ->helperText('Opsional. Gunakan gambar landscape agar tampilan slider optimal. Maksimal 4 MB per gambar.'),
                    ]),
                Section::make('Daftar informasi beranda')
                    ->id('daftar-informasi')
                    ->description('Atur teks pengantar yang tampil di atas daftar artikel dan informasi terbaru.')
                    ->schema([
                        TextInput::make('posts_section_label')
                        ->label('Label informasi')
                        ->required()
                        ->maxLength(100)
                        ->placeholder('Informasi terbaru')
                        ->columnSpan(1),
                        TextInput::make('posts_section_title')
                        ->label('Judul informasi')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Edukasi dan cerita komunitas')
                        ->columnSpan(1),
                        Textarea::make('posts_section_description')
                        ->label('Deskripsi informasi')
                        ->required()
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull()
                        ->placeholder('Ruang berbagi pengetahuan, pengalaman, dan dukungan seputar hepatitis.'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
                Section::make('Berita pilihan')
                    ->id('berita-pilihan')
                    ->description('Pilih artikel yang ingin ditampilkan sebagai berita utama. Kosongkan untuk menggunakan artikel terbaru.')
                    ->schema([
                        Select::make('featured_post_id')
                            ->label('Artikel berita pilihan')
                            ->options(fn (): array => Post::query()
                                ->where('status', Post::STATUS_PUBLISHED)
                                ->latest('published_at')
                                ->pluck('title', 'id')
                                ->all())
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->placeholder('Gunakan artikel terbaru secara otomatis')
                            ->helperText('Hanya artikel berstatus Published yang dapat dipilih.')
                            ->columnSpanFull(),
                    ]),
                Section::make('Widget bantuan dan konsultasi')
                    ->id('widget-bantuan')
                    ->description('Tampilkan tombol bantuan mengambang seperti konsultasi, WhatsApp, FAQ, dan email.')
                    ->schema([
                        Toggle::make('help_widget_enabled')
                            ->label('Aktifkan widget bantuan')
                            ->default(true)
                            ->columnSpanFull(),
                        TextInput::make('help_widget_badge')
                            ->label('Label widget')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Komunitas Peduli Hepatitis'),
                        TextInput::make('help_widget_title')
                            ->label('Judul konsultasi')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Konsultasi Komunitas'),
                        Textarea::make('help_widget_description')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('Tim kami siap membantu pertanyaan Anda.')
                            ->columnSpanFull(),
                        TextInput::make('help_widget_whatsapp')
                            ->label('Nomor HP admin / WhatsApp')
                            ->tel()
                            ->rules(['nullable', 'regex:/^[0-9]{8,15}$/'])
                            ->placeholder('628xxxxxxxxxx')
                            ->helperText('Masukkan angka 8-15 digit dalam format internasional, tanpa tanda +. Contoh: 628123456789.')
                            ->maxLength(20),
                        TextInput::make('help_widget_email')
                            ->label('Email admin')
                            ->email()
                            ->placeholder('kontak@komunitas.id')
                            ->helperText('Email ini akan tampil sebagai kontak admin pada panel Butuh Bantuan.')
                            ->maxLength(255),
                        TextInput::make('help_widget_faq_url')
                            ->label('Link FAQ')
                            ->url()
                            ->placeholder('https://...')
                            ->helperText('Kosongkan jika belum memiliki halaman FAQ.')
                            ->maxLength(2048),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $settings = SiteSetting::current();

        foreach (['logo_path', 'login_logo_path', 'hero_background_image', 'about_background_image'] as $field) {
            if (filled($settings->{$field}) && $settings->{$field} !== ($state[$field] ?? null)) {
                Storage::disk('public')->delete($settings->{$field});
            }

            $previousSlides = collect($settings->hero_slides ?? [])->pluck('image')->filter();
            $currentSlides = collect($state['hero_slides'] ?? [])->pluck('image')->filter();
            $previousSlides
                ->diff($currentSlides)
                ->each(fn (string $path) => Storage::disk('public')->delete($path));
        }

        SiteSetting::updateBranding($state);

        Notification::make()
            ->success()
            ->title('Pengaturan berhasil disimpan')
            ->send();
    }
}
