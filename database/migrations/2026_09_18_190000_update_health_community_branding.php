<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')
            ->where('site_name', 'WartaWarga')
            ->update(['site_name' => 'Komunitas Peduli Hepatitis (KPH)']);

        DB::table('site_settings')
            ->where('footer_text', '© {year} {site_name}. Citizen Journalism by RCH Techno')
            ->update([
                'footer_text' => '© {year} {site_name}. Bersama meningkatkan kesadaran dan kepedulian terhadap hepatitis.',
            ]);
    }

    public function down(): void
    {
        DB::table('site_settings')
            ->where('site_name', 'Komunitas Peduli Hepatitis (KPH)')
            ->update(['site_name' => 'WartaWarga']);

        DB::table('site_settings')
            ->where('footer_text', '© {year} {site_name}. Bersama meningkatkan kesadaran dan kepedulian terhadap hepatitis.')
            ->update([
                'footer_text' => '© {year} {site_name}. Citizen Journalism by RCH Techno',
            ]);
    }
};
