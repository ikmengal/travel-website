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
        Schema::create('tour_departures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();

            $table->date('departure_date');
            $table->date('return_date');
            $table->unsignedSmallInteger('available_seats');
            $table->decimal('price',10,2);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index('departure_date');
            $table->index('status');
            $table->index(['tour_id','departure_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_departures');
    }
};
