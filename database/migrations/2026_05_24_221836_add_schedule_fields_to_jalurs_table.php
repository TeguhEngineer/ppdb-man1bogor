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
        Schema::table('jalurs', function (Blueprint $table) {
            $table->dateTime('tgl_buka')->nullable()->after('deskripsi');
            $table->dateTime('tgl_tutup')->nullable()->after('tgl_buka');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jalurs', function (Blueprint $table) {
            $table->dropColumn(['tgl_buka', 'tgl_tutup']);
        });
    }
};
