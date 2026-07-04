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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();

            $table->string('email')->unique();
            $table->string('token',100)->unique();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('unsubscribe_reason')->nullable();
            $table->string('ip_address',45)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('status')->default(true);

            $table->softDeletes();
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */
            $table->index('email');
            $table->index('status');
            $table->index('subscribed_at');
            $table->index('verified_at');
            $table->index('unsubscribed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
