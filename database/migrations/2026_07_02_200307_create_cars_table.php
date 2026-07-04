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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_category_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('car_code',30)->unique();
            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->string('color')->nullable();
            $table->enum('transmission',[
                'automatic',
                'manual'
            ])->default('automatic');

            $table->enum('fuel_type',[
                'petrol',
                'diesel',
                'hybrid',
                'electric',
                'cng'
            ])->default('petrol');

            $table->string('engine_capacity')->nullable();
            $table->unsignedTinyInteger('seats')->default(4);
            $table->unsignedTinyInteger('doors')->default(4);
            $table->unsignedTinyInteger('bags')->default(2);
            $table->boolean('air_conditioning')->default(true);
            $table->string('registration_no')->nullable()->unique();
            $table->string('license_plate')->nullable()->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('pickup_location');
            $table->string('dropoff_location')->nullable();
            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();
            $table->decimal('base_price_per_day',10,2);
            $table->decimal('security_deposit',10,2)->default(0);
            $table->boolean('insurance_included')->default(false);
            $table->boolean('free_cancellation')->default(false);
            $table->boolean('instant_booking')->default(false);
            $table->unsignedTinyInteger('minimum_driver_age')->default(21);

            $table->enum('fuel_policy',[
                'full_to_full',
                'full_to_empty',
                'same_to_same'
            ])->default('full_to_full');

            $table->unsignedInteger('mileage_limit')->nullable();
            $table->decimal('rating',3,2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('availability')->default(true);
            $table->boolean('status')->default(true);

            $table->unsignedInteger('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->softDeletes();
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('destination_id');
            $table->index('car_category_id');
            $table->index('brand');
            $table->index('model');
            $table->index('status');
            $table->index('featured');
            $table->index('availability');
            $table->index('base_price_per_day');
            $table->index('rating');
            $table->index([
                'destination_id',
                'status'
            ]);
            $table->index([
                'car_category_id',
                'status'
            ]);
            $table->index([
                'featured',
                'status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
