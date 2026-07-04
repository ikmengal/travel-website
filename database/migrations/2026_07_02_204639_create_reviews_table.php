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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('reviewable');
            // reviewable_id
            // reviewable_type

            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();

            $table->unsignedTinyInteger('rating');
            $table->string('title')->nullable();
            $table->text('review');
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();

            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamp('approved_at')->nullable();

            $table->softDeletes();
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('user_id');
            $table->index('booking_id');
            $table->index('rating');
            $table->index('status');
            $table->index('is_verified');
            $table->index('is_featured');
            // $table->index([
            //     'reviewable_type',
            //     'reviewable_id'
            // ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
