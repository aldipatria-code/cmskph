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
            $table->text('footer_text')->nullable()->after('login_logo_path');
        });

        DB::table('site_settings')->update([
            'footer_text' => '© {year} {site_name}. Citizen Journalism by RCH Techno',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('footer_text');
        });
    }
};
