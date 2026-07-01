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
        Schema::create('hotel_types', function (Blueprint $table) {
            $table->id();
            // Basic Information
            $table->string('name', 100)->unique();
            $table->string('slug')->unique();

            // Optional
            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            // Description
            $table->text('description')->nullable();

            // Ordering
            $table->unsignedInteger('sort_order')->default(0);

            // Status
            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_types');
    }
};
