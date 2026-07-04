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
        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hotel_room_type_id')->constrained()->cascadeOnDelete();

            $table->string('room_code',30)->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('room_number')->nullable();
            $table->string('bed_type')->nullable();
            $table->unsignedTinyInteger('beds')->default(1);
            $table->unsignedTinyInteger('bathrooms')->default(1);
            $table->unsignedTinyInteger('max_adults')->default(2);
            $table->unsignedTinyInteger('max_children')->default(0);
            $table->decimal('room_size',8,2)->nullable();
            $table->string('room_size_unit')->default('sqm');
            $table->string('view')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->decimal('base_price',10,2);
            $table->decimal('discount_price',10,2)->nullable();
            $table->unsignedInteger('total_rooms')->default(1);
            $table->unsignedInteger('available_rooms')->default(1);
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->softDeletes();
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('hotel_id');
            $table->index('hotel_room_type_id');
            $table->index('status');
            $table->index('featured');
            $table->index('base_price');
            $table->index('available_rooms');
            $table->index([
                'hotel_id',
                'status'
            ]);
            $table->index([
                'hotel_id',
                'featured'
            ]);
            $table->index([
                'hotel_room_type_id',
                'status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_rooms');
    }
};
