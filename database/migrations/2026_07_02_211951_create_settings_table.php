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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('group')->default('general');
            // general, smtp, payment, seo, social

            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->enum('type',[
                'text',
                'textarea',
                'number',
                'email',
                'url',
                'image',
                'boolean',
                'json',
                'password'
            ])->default('text');

            $table->boolean('autoload')->default(true);
            $table->boolean('status')->default(true);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('group');
            $table->index('autoload');
            $table->index('status');
            $table->index([
                'group',
                'status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
