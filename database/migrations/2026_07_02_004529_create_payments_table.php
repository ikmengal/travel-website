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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();

            $table->string('payment_no')->unique();
            $table->string('gateway');
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->decimal('amount',10,2);
            $table->char('currency',3);

            $table->enum('status',[
                'pending',
                'paid',
                'failed',
                'refunded'
            ]);

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
