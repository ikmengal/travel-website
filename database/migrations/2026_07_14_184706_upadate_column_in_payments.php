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
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('status')->default(true)->change();
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded',
                'cancelled',
            ])
            ->default('pending')
            ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_status');
            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'refunded',
            ])
            ->default('pending')
            ->change();
        });
    }
};
