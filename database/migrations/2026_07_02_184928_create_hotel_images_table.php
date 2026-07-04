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
        Schema::create('hotel_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();

            $table->string('image');
            $table->string('title')->nullable();
            $table->text('alt_text')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();

            // Indexes
            $table->index('hotel_id');
            $table->index('status');
            $table->index('sort_order');
            $table->index('is_featured');

            $table->index(['hotel_id','status']);
            $table->index(['hotel_id','sort_order']);
            $table->index(['hotel_id','is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_images');
    }
};
