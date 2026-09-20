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
            $table->string('gallery_section_badge')->nullable()->after('gallery_hero_description');
            $table->string('gallery_section_title')->nullable()->after('gallery_section_badge');
        });

        DB::table('site_settings')->update([
            'gallery_section_badge' => 'Jelajahi lebih banyak',
            'gallery_section_title' => 'Lihat kegiatan komunitas dan momen yang sudah kami dokumentasikan.',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['gallery_section_badge', 'gallery_section_title']);
        });
    }
};
