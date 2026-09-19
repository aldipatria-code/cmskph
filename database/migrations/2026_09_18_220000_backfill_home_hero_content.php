<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')
            ->whereNull('hero_badge')
            ->update(['hero_badge' => 'Komunitas kesehatan']);

        DB::table('site_settings')
            ->whereNull('hero_title')
            ->update(['hero_title' => 'Bersama peduli hepatitis.']);

        DB::table('site_settings')
            ->whereNull('hero_description')
            ->update(['hero_description' => 'Temukan edukasi terpercaya, cerita penyintas, dan kegiatan komunitas untuk meningkatkan kesadaran serta dukungan bagi orang yang terdampak hepatitis.']);
    }

    public function down(): void
    {
        DB::table('site_settings')->update([
            'hero_badge' => null,
            'hero_title' => null,
            'hero_description' => null,
        ]);
    }
};
