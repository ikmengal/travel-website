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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('booking_no',30)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_departure_id')->nullable()->constrained()->nullOnDelete();

            $table->unsignedSmallInteger('adults')->default(1);
            $table->unsignedSmallInteger('children')->default(0);
            $table->unsignedSmallInteger('infants')->default(0);

            $table->decimal('tour_price',10,2);
            $table->decimal('subtotal',10,2);
            $table->decimal('discount',10,2)->default(0);
            $table->decimal('tax',10,2)->default(0);
            $table->decimal('grand_total',10,2);
            $table->char('currency',3)->default('USD');

            $table->enum('booking_status',[
                'pending',
                'confirmed',
                'cancelled',
                'completed',
                'refunded'
            ])->default('pending');
            $table->enum('payment_status',[
                'pending',
                'paid',
                'failed',
                'refunded'
            ])->default('pending');

            $table->text('special_request')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id','booking_status']);
            $table->index(['tour_id','booking_status']);
            $table->index(['booking_status','payment_status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
