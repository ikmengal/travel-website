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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */
            $table->foreignId('hotel_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('room_type_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();

             /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('room_number')->nullable();
            $table->string('room_code')->nullable()->unique();

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */
            $table->decimal('base_price',10,2);
            $table->decimal('discount_price',10,2)->nullable();
            $table->decimal('weekend_price',10,2)->nullable();
            $table->decimal('extra_guest_price',10,2)->default(0);

            /*
            |--------------------------------------------------------------------------
            | Capacity
            |--------------------------------------------------------------------------
            */
            $table->unsignedTinyInteger('max_adults')->default(2);
            $table->unsignedTinyInteger('max_children')->default(0);
            $table->unsignedTinyInteger('max_guests')->default(2);

            /*
            |--------------------------------------------------------------------------
            | Room Details
            |--------------------------------------------------------------------------
            */
            $table->unsignedTinyInteger('bedrooms')->default(1);
            $table->unsignedTinyInteger('beds')->default(1);
            $table->unsignedTinyInteger('bathrooms')->default(1);
            $table->decimal('room_size',8,2)->nullable();
            $table->string('room_size_unit')->default('sqft');
            $table->longText('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Policies
            |--------------------------------------------------------------------------
            */
            $table->boolean('breakfast_included')->default(false);
            $table->boolean('smoking_allowed')->default(false);
            $table->boolean('pets_allowed')->default(false);
            $table->boolean('instant_booking')->default(true);
            $table->boolean('refundable')->default(true);

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */
            $table->decimal('average_rating',3,2)->default(0);
            $table->unsignedInteger('total_reviews')->default(0);
            $table->unsignedInteger('total_bookings')->default(0);

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
                'Available',
                'Unavailable',
                'Maintenance'
            ])->default('Available');

            $table->softDeletes();
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */
            $table->index('hotel_id');
            $table->index('room_type_id');
            $table->index('status');
            $table->index('base_price');
            $table->index('max_guests');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
