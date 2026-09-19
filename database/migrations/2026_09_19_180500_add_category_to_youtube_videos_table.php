<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('youtube_videos', function (Blueprint $table): void {
            $table->string('category')->nullable()->after('description')->index();
        });
    }

    public function down(): void
    {
        Schema::table('youtube_videos', function (Blueprint $table): void {
            $table->dropColumn('category');
        });
    }
};
