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
            $table->string('hero_badge')->nullable()->after('social_links');
            $table->string('hero_title')->nullable()->after('hero_badge');
            $table->text('hero_description')->nullable()->after('hero_title');
        });

        DB::table('site_settings')->update([
            'hero_badge' => 'Komunitas kesehatan',
            'hero_title' => 'Bersama peduli hepatitis.',
            'hero_description' => 'Temukan edukasi terpercaya, cerita penyintas, dan kegiatan komunitas untuk meningkatkan kesadaran serta dukungan bagi orang yang terdampak hepatitis.',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_badge', 'hero_title', 'hero_description']);
        });
    }
};
