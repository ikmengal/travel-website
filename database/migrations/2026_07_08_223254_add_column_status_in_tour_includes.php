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
        Schema::table('tour_includes', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('title');
            $table->boolean('sort_order')->default(1)->after('icon');
            $table->boolean('status')->default(1)->after('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_includes', function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->dropColumn('sort_order');
            $table->dropColumn('status');
        });
    }
};
