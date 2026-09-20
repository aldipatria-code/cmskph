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
            $table->string('faq_cta_badge')->nullable()->after('faq_hero_description');
            $table->string('faq_cta_title')->nullable()->after('faq_cta_badge');
            $table->string('faq_cta_button_label')->nullable()->after('faq_cta_title');
        });

        DB::table('site_settings')->update([
            'faq_cta_badge' => 'Masih punya pertanyaan?',
            'faq_cta_title' => 'Bergabunglah bersama komunitas untuk mendapat jawaban yang lebih personal.',
            'faq_cta_button_label' => 'Gabung komunitas',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['faq_cta_badge', 'faq_cta_title', 'faq_cta_button_label']);
        });
    }
};
