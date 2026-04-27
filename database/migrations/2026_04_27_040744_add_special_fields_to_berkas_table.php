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
            $table->string('file_sertifikat')->nullable()->after('file_surat_keterangan_aktif');
            $table->string('file_sktm')->nullable()->after('file_sertifikat');
            $table->string('file_kip')->nullable()->after('file_sktm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->dropColumn(['file_sertifikat', 'file_sktm', 'file_kip']);
        });
    }
};
