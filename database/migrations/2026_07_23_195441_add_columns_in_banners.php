<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('subtitle_1')->nullable()->after('subtitle');
            $table->string('subtitle_2')->nullable()->after('subtitle_1');
            $table->string('subtitle_3')->nullable()->after('subtitle_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('subtitle_1');
            $table->dropColumn('subtitle_2');
            $table->dropColumn('subtitle_3');
        });
    }
};
