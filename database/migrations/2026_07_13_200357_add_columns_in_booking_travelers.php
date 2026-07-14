<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('booking_travelers', function (Blueprint $table) {
            $table->string('cnic')->nullable()->after('is_primary');
            $table->string('emergency_contact_name')->nullable()->after('cnic');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->text('address')->nullable()->after('emergency_contact_phone');
            $table->longText('notes')->nullable()->after('address');
            $table->boolean('status')->default(1)->after('notes');
            $table->timestamp('softDeletes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_travelers', function (Blueprint $table) {
            $table->dropColumn('cnic');
            $table->dropColumn('emergency_contact_name');
            $table->dropColumn('emergency_contact_phone');
            $table->dropColumn('address');
            $table->dropColumn('notes');
            $table->dropColumn('status');
            $table->dropColumn('softDeletes');
        });
    }
};
