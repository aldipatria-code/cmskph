<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('gallery_hero_badge')->nullable()->after('posts_section_description');
            $table->string('gallery_hero_title')->nullable()->after('gallery_hero_badge');
            $table->text('gallery_hero_description')->nullable()->after('gallery_hero_title');
            $table->string('gallery_hero_background_color')->nullable()->after('gallery_hero_description');
            $table->string('gallery_hero_image_one')->nullable()->after('gallery_hero_background_color');
            $table->string('gallery_hero_image_two')->nullable()->after('gallery_hero_image_one');
        });

        DB::table('site_settings')->whereNull('gallery_hero_badge')->update([
            'gallery_hero_badge' => 'Galeri Kegiatan',
            'gallery_hero_title' => 'Cerita kegiatan komunitas.',
            'gallery_hero_description' => 'Lihat dokumentasi edukasi, kampanye, dan kegiatan Komunitas Peduli Hepatitis.',
            'gallery_hero_background_color' => '#0f9aa3',
            'gallery_hero_image_one' => 'gallery/01M2TTJACDCEB333GCAK5YHEE3.jpeg',
            'gallery_hero_image_two' => 'gallery/01M2TV29PM7SARMKDCBXY6TC71.png',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'gallery_hero_badge',
                'gallery_hero_title',
                'gallery_hero_description',
                'gallery_hero_background_color',
                'gallery_hero_image_one',
                'gallery_hero_image_two',
            ]);
        });
    }
};
