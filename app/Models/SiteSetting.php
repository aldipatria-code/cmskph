<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo_path',
        'login_logo_path',
        'footer_text',
        'social_links',
        'hero_badge',
        'hero_title',
        'hero_description',
        'posts_section_label',
        'posts_section_title',
        'posts_section_description',
        'gallery_hero_badge',
        'gallery_hero_title',
        'gallery_hero_description',
        'gallery_section_badge',
        'gallery_section_title',
        'gallery_cta_button_label',
        'gallery_hero_background_color',
        'faq_hero_badge',
        'faq_hero_title',
        'faq_hero_description',
        'faq_cta_badge',
        'faq_cta_title',
        'faq_cta_button_label',
        'gallery_hero_image_one',
        'gallery_hero_image_two',
        'featured_post_id',
        'hero_background_color',
        'hero_background_image',
        'hero_slides',
        'about_title',
        'about_description',
        'about_vision',
        'about_mission',
        'about_commitment',
        'about_cta_badge',
        'about_cta_title',
        'about_background_color',
        'about_background_image',
        'help_widget_enabled',
        'help_widget_badge',
        'help_widget_title',
        'help_widget_description',
        'help_widget_whatsapp',
        'help_widget_email',
        'help_widget_faq_url',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'hero_slides' => 'array',
            'help_widget_enabled' => 'boolean',
        ];
    }

    public function heroBadge(): string
    {
        return $this->hero_badge ?: 'Komunitas kesehatan';
    }

    public function heroTitle(): string
    {
        return $this->hero_title ?: 'Bersama peduli hepatitis.';
    }

    public function heroDescription(): string
    {
        return $this->hero_description ?: 'Temukan edukasi terpercaya, cerita penyintas, dan kegiatan komunitas untuk meningkatkan kesadaran serta dukungan bagi orang yang terdampak hepatitis.';
    }

    public function postsSectionLabel(): string
    {
        return $this->posts_section_label ?: 'Informasi terbaru';
    }

    public function postsSectionTitle(): string
    {
        return $this->posts_section_title ?: 'Edukasi dan cerita komunitas';
    }

    public function postsSectionDescription(): string
    {
        return $this->posts_section_description ?: 'Ruang berbagi pengetahuan, pengalaman, dan dukungan seputar hepatitis.';
    }

    public function galleryHeroBadge(): string
    {
        return $this->gallery_hero_badge ?: 'Galeri Kegiatan';
    }

    public function galleryHeroTitle(): string
    {
        return $this->gallery_hero_title ?: 'Cerita kegiatan komunitas.';
    }

    public function galleryHeroDescription(): string
    {
        return $this->gallery_hero_description ?: 'Lihat dokumentasi edukasi, kampanye, dan kegiatan Komunitas Peduli Hepatitis.';
    }

    public function gallerySectionBadge(): string
    {
        return $this->gallery_section_badge ?: 'Jelajahi lebih banyak';
    }

    public function gallerySectionTitle(): string
    {
        return $this->gallery_section_title ?: 'Lihat kegiatan komunitas dan momen yang sudah kami dokumentasikan.';
    }

    public function galleryCtaButtonLabel(): string
    {
        return $this->gallery_cta_button_label ?: 'Gabung komunitas';
    }

    public function galleryHeroBackgroundColor(): string
    {
        return $this->gallery_hero_background_color ?: '#0f9aa3';
    }

    public function faqHeroBadge(): string
    {
        return $this->faq_hero_badge ?: 'FAQ';
    }

    public function faqHeroTitle(): string
    {
        return $this->faq_hero_title ?: 'Pertanyaan yang sering diajukan';
    }

    public function faqHeroDescription(): string
    {
        return $this->faq_hero_description ?: 'Temukan jawaban atas pertanyaan umum seputar Komunitas Peduli Hepatitis, edukasi, dan kegiatan komunitas.';
    }

    public function faqCtaBadge(): string
    {
        return $this->faq_cta_badge ?: 'Masih punya pertanyaan?';
    }

    public function faqCtaTitle(): string
    {
        return $this->faq_cta_title ?: 'Bergabunglah bersama komunitas untuk mendapat jawaban yang lebih personal.';
    }

    public function faqCtaButtonLabel(): string
    {
        return $this->faq_cta_button_label ?: 'Gabung komunitas';
    }

    public function galleryHeroImageOneUrl(): ?string
    {
        return $this->logoUrl($this->gallery_hero_image_one);
    }

    public function galleryHeroImageTwoUrl(): ?string
    {
        return $this->logoUrl($this->gallery_hero_image_two);
    }

    public function featuredPostId(): ?int
    {
        return $this->featured_post_id ? (int) $this->featured_post_id : null;
    }

    public function heroBackgroundColor(): string
    {
        return $this->hero_background_color ?: '#0f172a';
    }

    public function heroBackgroundImageUrl(): ?string
    {
        return $this->logoUrl($this->hero_background_image);
    }

    public function heroSlides(): array
    {
        return collect($this->hero_slides ?? [])
            ->filter(fn (array $slide): bool => filled($slide['image'] ?? null))
            ->map(fn (array $slide): array => [
                'image' => $this->logoUrl($slide['image']),
                'badge' => $slide['badge'] ?? null,
                'title' => $slide['title'] ?? null,
            ])
            ->values()
            ->all();
    }

    public function aboutTitle(): string
    {
        return $this->about_title ?: 'Tentang Komunitas Peduli Hepatitis';
    }

    public function aboutDescription(): string
    {
        return $this->about_description ?: 'Komunitas Peduli Hepatitis (KPH) adalah ruang edukasi, dukungan, dan berbagi pengalaman untuk meningkatkan kesadaran tentang hepatitis.';
    }

    public function aboutVision(): string
    {
        return $this->about_vision ?: 'Mewujudkan masyarakat yang lebih sehat, sadar, dan peduli terhadap isu hepatitis.';
    }

    public function aboutMission(): string
    {
        return $this->about_mission ?: 'Memberikan edukasi, dukungan, dan ruang kolaborasi yang inklusif untuk semua.';
    }

    public function aboutCommitment(): string
    {
        return $this->about_commitment ?: 'Bergerak bersama komunitas untuk mencegah stigma, meningkatkan pemahaman, dan menyebarkan informasi yang benar.';
    }

    public function aboutCtaBadge(): string
    {
        return $this->about_cta_badge ?: 'Mulai dari sini';
    }

    public function aboutCtaTitle(): string
    {
        return $this->about_cta_title ?: 'Mari bersama menjaga kesehatan dan edukasi masyarakat.';
    }

    public function aboutBackgroundColor(): string
    {
        return $this->about_background_color ?: '#f0fdfa';
    }

    public function aboutBackgroundImageUrl(): ?string
    {
        return $this->logoUrl($this->about_background_image);
    }

    public function helpWidgetEnabled(): bool
    {
        return (bool) $this->help_widget_enabled;
    }

    public static function current(): self
    {
        $settings = self::query()
            ->orderByDesc('id')
            ->first();

        if ($settings) {
            return $settings;
        }

        return self::create([
            'site_name' => 'Komunitas Peduli Hepatitis (KPH)',
            'footer_text' => '© {year} {site_name}. Bersama meningkatkan kesadaran dan kepedulian terhadap hepatitis.',
            'hero_badge' => 'Komunitas kesehatan',
            'hero_title' => 'Bersama peduli hepatitis.',
            'hero_description' => 'Temukan edukasi terpercaya, cerita penyintas, dan kegiatan komunitas untuk meningkatkan kesadaran serta dukungan bagi orang yang terdampak hepatitis.',
            'posts_section_label' => 'Informasi terbaru',
            'posts_section_title' => 'Edukasi dan cerita komunitas',
            'posts_section_description' => 'Ruang berbagi pengetahuan, pengalaman, dan dukungan seputar hepatitis.',
            'gallery_hero_badge' => 'Galeri Kegiatan',
            'gallery_hero_title' => 'Cerita kegiatan komunitas.',
            'gallery_hero_description' => 'Lihat dokumentasi edukasi, kampanye, dan kegiatan Komunitas Peduli Hepatitis.',
            'gallery_section_badge' => 'Jelajahi lebih banyak',
            'gallery_section_title' => 'Lihat kegiatan komunitas dan momen yang sudah kami dokumentasikan.',
            'gallery_cta_button_label' => 'Gabung komunitas',
            'faq_hero_badge' => 'FAQ',
            'faq_hero_title' => 'Pertanyaan yang sering diajukan',
            'faq_hero_description' => 'Temukan jawaban atas pertanyaan umum seputar Komunitas Peduli Hepatitis, edukasi, dan kegiatan komunitas.',
            'faq_cta_badge' => 'Masih punya pertanyaan?',
            'faq_cta_title' => 'Bergabunglah bersama komunitas untuk mendapat jawaban yang lebih personal.',
            'faq_cta_button_label' => 'Gabung komunitas',
            'about_title' => 'Tentang Komunitas Peduli Hepatitis',
            'about_description' => 'Komunitas Peduli Hepatitis (KPH) adalah ruang edukasi, dukungan, dan berbagi pengalaman untuk meningkatkan kesadaran tentang hepatitis.',
            'about_vision' => 'Mewujudkan masyarakat yang lebih sehat, sadar, dan peduli terhadap isu hepatitis.',
            'about_mission' => 'Memberikan edukasi, dukungan, dan ruang kolaborasi yang inklusif untuk semua.',
            'about_commitment' => 'Bergerak bersama komunitas untuk mencegah stigma, meningkatkan pemahaman, dan menyebarkan informasi yang benar.',
            'about_cta_badge' => 'Mulai dari sini',
            'about_cta_title' => 'Mari bersama menjaga kesehatan dan edukasi masyarakat.',
            'help_widget_enabled' => true,
            'help_widget_badge' => 'Komunitas Peduli Hepatitis',
            'help_widget_title' => 'Konsultasi Komunitas',
            'help_widget_description' => 'Tim kami siap membantu pertanyaan Anda seputar hepatitis.',
            'help_widget_whatsapp' => '',
            'help_widget_email' => '',
            'help_widget_faq_url' => '',
        ]);
    }

    public static function updateBranding(array $attributes): self
    {
        $settings = self::query()->latest('id')->firstOrFail();
        $settings->update($attributes);
        Cache::forget('site-settings');

        return $settings->fresh();
    }

    public function logoUrl(?string $path): ?string
    {
        return filled($path) ? Storage::disk('public')->url($path) : null;
    }

    public function footerText(): string
    {
        return str_replace(
            ['{year}', '{site_name}'],
            [date('Y'), $this->site_name],
            $this->footer_text ?: '© {year} {site_name}. Bersama meningkatkan kesadaran dan kepedulian terhadap hepatitis.',
        );
    }

    public function socialLinks(): array
    {
        return collect($this->social_links ?? [])
            ->filter(fn (array $link): bool => filled($link['label'] ?? null) && filled($link['url'] ?? null))
            ->values()
            ->all();
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site-settings'));
        static::deleted(fn () => Cache::forget('site-settings'));
    }
}
