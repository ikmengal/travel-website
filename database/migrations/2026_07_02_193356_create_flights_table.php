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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();

            $table->foreignId('airline_id')->constrained()->cascadeOnDelete();
            $table->foreignId('flight_route_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('departure_airport_id')->constrained('airports')->cascadeOnDelete();
            $table->foreignId('arrival_airport_id')->constrained('airports')->cascadeOnDelete();
            // $table->foreignId('flight_class_id')->constrained()->cascadeOnDelete();

            $table->string('flight_number');
            $table->string('aircraft')->nullable();
            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('arrival_date');
            $table->time('arrival_time');
            $table->unsignedInteger('duration'); // minutes
            $table->decimal('base_price',10,2);
            $table->unsignedInteger('total_seats');
            $table->unsignedInteger('available_seats');
            $table->unsignedInteger('baggage')->default(20);
            $table->boolean('refundable')->default(false);
            $table->enum('flight_type',[
                'one_way',
                'round_trip'
            ])->default('one_way');

            $table->enum('status',[
                'scheduled',
                'boarding',
                'departed',
                'arrived',
                'cancelled',
                'delayed'
            ])->default('scheduled');

            $table->softDeletes();
            $table->timestamps();


            $table->index('airline_id');
            $table->index('flight_route_id');
            // $table->index('flight_class_id');
            $table->index([
                'departure_airport_id',
                'arrival_airport_id'
            ]);
            $table->index([
                'departure_date',
                'departure_time'
            ]);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
