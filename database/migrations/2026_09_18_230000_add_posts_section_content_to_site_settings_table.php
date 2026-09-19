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
            $table->string('posts_section_label')->nullable()->after('hero_description');
            $table->string('posts_section_title')->nullable()->after('posts_section_label');
            $table->text('posts_section_description')->nullable()->after('posts_section_title');
        });

        DB::table('site_settings')->update([
            'posts_section_label' => 'Informasi terbaru',
            'posts_section_title' => 'Edukasi dan cerita komunitas',
            'posts_section_description' => 'Ruang berbagi pengetahuan, pengalaman, dan dukungan seputar hepatitis.',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'posts_section_label',
                'posts_section_title',
                'posts_section_description',
            ]);
        });
    }
};
