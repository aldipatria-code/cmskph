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
            $table->string('about_title')->nullable()->after('hero_background_image');
            $table->text('about_description')->nullable()->after('about_title');
        });

        DB::table('site_settings')->update([
            'about_title' => 'Tentang Komunitas Peduli Hepatitis',
            'about_description' => 'Komunitas Peduli Hepatitis (KPH) adalah ruang edukasi, dukungan, dan berbagi pengalaman untuk meningkatkan kesadaran tentang hepatitis.',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['about_title', 'about_description']);
        });
    }
};
