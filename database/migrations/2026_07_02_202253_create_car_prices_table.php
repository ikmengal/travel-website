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
        Schema::create('car_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('car_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->enum('price_type',[
                'regular',
                'weekend',
                'seasonal',
                'holiday',
                'festival'
            ])->default('regular');

            $table->date('start_date');
            $table->date('end_date');

            $table->decimal('price_per_day',10,2);
            $table->decimal('discount_price',10,2)->nullable();
            $table->unsignedTinyInteger('minimum_days')->default(1);
            $table->unsignedTinyInteger('priority')->default(1);

            $table->boolean('status')->default(true);
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('car_id');
            $table->index('status');
            $table->index('price_type');
            $table->index('start_date');
            $table->index('end_date');
            $table->index([
                'car_id',
                'status'
            ]);
            $table->index([
                'start_date',
                'end_date'
            ]);
            $table->index([
                'price_type',
                'priority'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_prices');
    }
};
