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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('company')->nullable();
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('review');
            $table->boolean('featured')->default(false);
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
            $table->index('name');
            $table->index('status');
            $table->index('featured');
            $table->index('sort_order');
            $table->index('rating');
            $table->index([
                'status',
                'featured'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
