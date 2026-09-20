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
            $table->string('gallery_cta_button_label')->nullable()->after('gallery_section_title');
        });

        DB::table('site_settings')->update([
            'gallery_cta_button_label' => 'Gabung komunitas',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('gallery_cta_button_label');
        });
    }
};
