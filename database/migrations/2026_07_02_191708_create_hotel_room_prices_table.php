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
        Schema::create('hotel_room_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hotel_room_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('price',10,2);
            $table->decimal('discount_price',10,2)
                ->nullable();
            $table->boolean('status')
                ->default(true);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */
            $table->index('hotel_room_id');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
            $table->index([
                'hotel_room_id',
                'status'
            ]);
            $table->index([
                'start_date',
                'end_date'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_room_prices');
    }
};
