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
        Schema::create('tour_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);

            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('sort_order');
            $table->index(['status','sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_categories');
    }
};
