<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mapels', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mapel', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('jalur_mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalur_id')->constrained('jalurs')->cascadeOnDelete();
            $table->foreignId('mapel_id')->constrained('mapels')->cascadeOnDelete();
            $table->unsignedInteger('urutan')->default(1);
            $table->timestamps();

            $table->unique(['jalur_id', 'mapel_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jalur_mapel');
        Schema::dropIfExists('mapels');
    }
};
