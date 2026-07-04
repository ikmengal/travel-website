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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tour_code')->unique();
            $table->string('tagline')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('featured_image')->nullable();

            $table->decimal('price',10,2);
            $table->decimal('discount_price',10,2)->nullable();
            $table->unsignedTinyInteger('duration_days');
            $table->unsignedTinyInteger('duration_nights');
            $table->unsignedSmallInteger('max_people')->default(1);
            $table->unsignedSmallInteger('min_age')->nullable();

            $table->decimal('rating',3,2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('popular')->default(false);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('title');
            $table->index('price');
            $table->index('discount_price');
            $table->index('featured');
            $table->index('popular');
            $table->index('status');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
