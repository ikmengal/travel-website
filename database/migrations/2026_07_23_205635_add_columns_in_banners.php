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
            $table->string('avatars_data')->nullable()->after('description');
            $table->string('card_location')->nullable()->after('avatars_data');
            $table->string('card_para')->nullable()->after('card_location');
            $table->string('card_reviews')->nullable()->after('card_para');
            $table->string('tag_icon')->nullable()->after('card_reviews');
            $table->string('tag_heading')->nullable()->after('tag_icon');
            $table->string('tag_para')->nullable()->after('tag_heading');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('avatars_data')->nullable();
            $table->dropColumn('card_location')->nullable();
            $table->dropColumn('card_para')->nullable();
            $table->dropColumn('card_reviews')->nullable();
            $table->dropColumn('tag_icon')->nullable();
            $table->dropColumn('tag_heading')->nullable();
            $table->dropColumn('tag_para')->nullable();
        });
    }
};
