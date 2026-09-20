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
            $table->text('about_vision')->nullable()->after('about_description');
            $table->text('about_mission')->nullable()->after('about_vision');
            $table->text('about_commitment')->nullable()->after('about_mission');
        });

        DB::table('site_settings')->update([
            'about_vision' => 'Mewujudkan masyarakat yang lebih sehat, sadar, dan peduli terhadap isu hepatitis.',
            'about_mission' => 'Memberikan edukasi, dukungan, dan ruang kolaborasi yang inklusif untuk semua.',
            'about_commitment' => 'Bergerak bersama komunitas untuk mencegah stigma, meningkatkan pemahaman, dan menyebarkan informasi yang benar.',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['about_vision', 'about_mission', 'about_commitment']);
        });
    }
};
