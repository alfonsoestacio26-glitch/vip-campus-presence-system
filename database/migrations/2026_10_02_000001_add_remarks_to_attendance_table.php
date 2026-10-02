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
        Schema::table('attendance', function (Blueprint $table) {
            if (!Schema::hasColumn('attendance', 'remarks')) {
                $table->text('remarks')->nullable()->after('status');
            }
            $table->unsignedBigInteger('guard_id')->nullable()->change();
            $table->string('status', 50)->default('Present')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            if (Schema::hasColumn('attendance', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });
    }
};
