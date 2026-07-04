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
        Schema::create('flight_routes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('departure_airport_id')->constrained('airports')->cascadeOnDelete();
            $table->foreignId('arrival_airport_id')->constrained('airports')->cascadeOnDelete();

            $table->string('route_code',30)->unique();
            $table->decimal('distance',8,2)->nullable();
            $table->unsignedInteger('estimated_duration')->nullable(); // minutes
            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->unique([
                'departure_airport_id',
                'arrival_airport_id'
            ]);
            $table->index([
                'departure_airport_id',
                'arrival_airport_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_routes');
    }
};
