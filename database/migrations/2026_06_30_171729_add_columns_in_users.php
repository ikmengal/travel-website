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
            $table->foreignId('country_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('state_id')->nullable()->after('country_id')->constrained()->nullOnDelete();
            $table->foreignId('city_id')->nullable()->after('state_id')->constrained()->nullOnDelete();

            $table->string('username')->unique()->nullable()->after('name');
            $table->string('phone')->nullable()->unique()->after('email');
            $table->string('avatar')->nullable()->after('password');


            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('remember_token');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->longText('address')->nullable()->after('date_of_birth');
            $table->text('bio')->nullable()->after('address');
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->after('bio');

            $table->softDeletes()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Drop Foreign Keys
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);

            // Drop Columns
            $table->dropColumn([
                'username',
                'phone',
                'avatar',
                'country_id',
                'state_id',
                'city_id',
                'gender',
                'date_of_birth',
                'address',
                'bio',
                'status',
            ]);

            // Drop deleted_at
            $table->dropSoftDeletes();
        });
    }
};
