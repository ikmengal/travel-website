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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            // Hotel Owner
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            // Hotel Type
            $table->foreignId('hotel_type_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();

            // Location
            $table->foreignId('country_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('state_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->nullable();
            $table->string('phone',30)->nullable();
            $table->string('website')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Address
            |--------------------------------------------------------------------------
            */

            $table->string('address');
            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Hotel Details
            |--------------------------------------------------------------------------
            */

            $table->unsignedTinyInteger('star_rating')->default(1);
            $table->time('check_in_time')->default('14:00:00');
            $table->time('check_out_time')->default('12:00:00');
            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Business Information
            |--------------------------------------------------------------------------
            */

            $table->string('license_no', 100)->nullable()->unique();
            $table->string('tax_number', 100)->nullable()->unique();

            /*
            |--------------------------------------------------------------------------
            | Media
            |--------------------------------------------------------------------------
            */

            // Agar Spatie Media Library use NAHI karni
            $table->string('featured_image')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            // 0.0 - 5.0
            $table->decimal('average_rating', 3, 2)->default(0.00);

            // Total approved reviews
            $table->unsignedInteger('total_reviews')->default(0);

            // Total active rooms
            $table->unsignedInteger('total_rooms')->default(0);

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_featured')->default(false);
            $table->enum('status',[
                'Pending',
                'Approved',
                'Rejected',
                'Inactive'
            ])->default('Pending');

            $table->softDeletes();
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('slug');
            $table->index('status');
            $table->index('is_featured');
            $table->index('city_id');
            $table->index('country_id');
            $table->index('hotel_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
