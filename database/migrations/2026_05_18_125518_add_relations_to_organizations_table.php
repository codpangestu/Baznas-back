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
        Schema::table('organizations', function (Blueprint $table) {
            $table->foreignId('province_id')->nullable()->after('status')->constrained()->onDelete('set null');
            $table->foreignId('daerah_id')->nullable()->after('province_id')->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['daerah_id']);
            $table->dropColumn(['province_id', 'daerah_id']);
        });
    }
};
