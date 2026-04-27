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
        Schema::table('berkas', function (Blueprint $table) {
            $table->dropColumn('file_sertifikat_hafalan');
        });

        Schema::table('pengumumans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->enum('status', ['lulus', 'tidak_lulus', 'pending'])->default('pending');
        });

        Schema::table('berkas', function (Blueprint $table) {
            $table->string('file_sertifikat_hafalan')->nullable();
        });
    }
};
