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
            $table->string('about_cta_badge')->nullable()->after('about_commitment');
            $table->string('about_cta_title')->nullable()->after('about_cta_badge');
        });

        DB::table('site_settings')->update([
            'about_cta_badge' => 'Mulai dari sini',
            'about_cta_title' => 'Mari bersama menjaga kesehatan dan edukasi masyarakat.',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['about_cta_badge', 'about_cta_title']);
        });
    }
};
