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
        Schema::create('flight_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('flight_id')->constrained()->cascadeOnDelete();

            $table->date('departure_date');
            $table->date('arrival_date');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->unsignedInteger('duration'); // Minutes
            $table->decimal('price',10,2);
            $table->decimal('discount_price',10,2)->nullable();
            $table->unsignedInteger('total_seats');
            $table->unsignedInteger('available_seats');

            $table->enum('status',[
                'scheduled',
                'boarding',
                'departed',
                'arrived',
                'cancelled',
                'delayed'
            ])->default('scheduled');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('flight_id');
            $table->index('departure_date');
            $table->index('arrival_date');
            $table->index('status');
            $table->index([
                'flight_id',
                'departure_date'
            ]);
            $table->index([
                'departure_date',
                'status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_schedules');
    }
};
