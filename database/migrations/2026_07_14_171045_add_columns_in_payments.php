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
            $table->string('reference_no')->nullable()->after('currency');
            $table->string('receipt')->nullable()->after('reference_no');
            $table->text('notes')->nullable()->after('receipt');
            $table->timestamp('deleted_at')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('reference_no');
            $table->dropColumn('receipt');
            $table->dropColumn('notes');
            $table->dropColumn('deleted_at');
        });
    }
};
