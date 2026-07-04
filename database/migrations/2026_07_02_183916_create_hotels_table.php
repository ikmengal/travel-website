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

            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('hotel_code',30)->unique();
            $table->string('star_rating',10)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('address');

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('check_in_time')->nullable();
            $table->string('check_out_time')->nullable();
            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();
            $table->decimal('starting_price',10,2)->default(0);

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

            $table->index('name');
            $table->index('rating');
            $table->index('starting_price');
            $table->index('featured');
            $table->index('popular');
            $table->index('status');

            $table->index(['destination_id','status']);
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
