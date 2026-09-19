<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('faq_hero_badge')->nullable()->after('gallery_hero_background_color');
            $table->string('faq_hero_title')->nullable()->after('faq_hero_badge');
            $table->text('faq_hero_description')->nullable()->after('faq_hero_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn([
                'faq_hero_badge',
                'faq_hero_title',
                'faq_hero_description',
            ]);
        });
    }
};
