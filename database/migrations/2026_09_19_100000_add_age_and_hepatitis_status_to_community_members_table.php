<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('community_members', function (Blueprint $table) {
            $table->unsignedTinyInteger('age')->nullable()->after('email');
            $table->boolean('hepatitis_a')->default(false)->after('age');
            $table->boolean('hepatitis_b')->default(false)->after('hepatitis_a');
            $table->boolean('hepatitis_c')->default(false)->after('hepatitis_b');
        });
    }

    public function down(): void
    {
        Schema::table('community_members', function (Blueprint $table) {
            $table->dropColumn(['age', 'hepatitis_a', 'hepatitis_b', 'hepatitis_c']);
        });
    }
};
