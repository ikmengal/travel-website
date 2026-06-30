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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('password');
            $table->bigInteger('country_id')->nullable()->after('avatar');
            $table->bigInteger('city_id')->nullable()->after('country_id');
            $table->string('gender')->nullable()->after('city_id');
            $table->string('date_of_birth')->nullable()->after('gender');
            $table->longText('address')->nullable()->after('date_of_birth');
            $table->text('bio')->nullable()->after('address');
            $table->enum('status',['Active', 'Inactive'])->default('Active')->after('bio');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('phone');
            $table->dropColumn('avatar');
            $table->dropColumn('country_id');
            $table->dropColumn('city_id');
            $table->dropColumn('gender');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('address');
            $table->dropColumn('bio');
            $table->dropColumn('status');
        });
    }
};
