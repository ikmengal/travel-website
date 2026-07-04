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
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            // ti ti-brand-facebook
            // fab fa-facebook

            $table->string('url');
            $table->string('color')->nullable();
            $table->boolean('open_in_new_tab')->default(true);
            $table->boolean('is_footer')->default(true);
            $table->boolean('is_header')->default(false);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('name');
            $table->index('slug');
            $table->index('status');
            $table->index('sort_order');
            $table->index('is_footer');
            $table->index('is_header');

            $table->index([
                'status',
                'sort_order'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
