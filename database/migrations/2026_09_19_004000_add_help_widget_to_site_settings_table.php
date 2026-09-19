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
            $table->boolean('help_widget_enabled')->default(true)->after('about_background_image');
            $table->string('help_widget_badge')->nullable()->after('help_widget_enabled');
            $table->string('help_widget_title')->nullable()->after('help_widget_badge');
            $table->text('help_widget_description')->nullable()->after('help_widget_title');
            $table->string('help_widget_whatsapp')->nullable()->after('help_widget_description');
            $table->string('help_widget_email')->nullable()->after('help_widget_whatsapp');
            $table->string('help_widget_faq_url')->nullable()->after('help_widget_email');
        });

        DB::table('site_settings')->update([
            'help_widget_badge' => 'Komunitas Peduli Hepatitis',
            'help_widget_title' => 'Konsultasi Komunitas',
            'help_widget_description' => 'Tim kami siap membantu pertanyaan Anda seputar hepatitis.',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'help_widget_enabled',
                'help_widget_badge',
                'help_widget_title',
                'help_widget_description',
                'help_widget_whatsapp',
                'help_widget_email',
                'help_widget_faq_url',
            ]);
        });
    }
};
