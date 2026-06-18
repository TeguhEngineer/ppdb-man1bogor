<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('pengumumans', 'pendaftaran_id')) {
            Schema::table('pengumumans', function (Blueprint $table) {
                $table->dropForeign(['pendaftaran_id']);
            });

            Schema::table('pengumumans', function (Blueprint $table) {
                $table->dropColumn('pendaftaran_id');
            });
        }

        Schema::table('pengumumans', function (Blueprint $table) {
            if (!Schema::hasColumn('pengumumans', 'is_published')) {
                $table->boolean('is_published')->default(true)->after('keterangan');
            }

            if (!Schema::hasColumn('pengumumans', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            }
        });

        if (Schema::hasColumn('pengumumans', 'sudah_dibaca') || Schema::hasColumn('pengumumans', 'dibaca_pada')) {
            Schema::table('pengumumans', function (Blueprint $table) {
                if (Schema::hasColumn('pengumumans', 'sudah_dibaca')) {
                    $table->dropColumn('sudah_dibaca');
                }

                if (Schema::hasColumn('pengumumans', 'dibaca_pada')) {
                    $table->dropColumn('dibaca_pada');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            if (!Schema::hasColumn('pengumumans', 'pendaftaran_id')) {
                $table->foreignId('pendaftaran_id')->nullable()->after('id')->constrained('pendaftarans')->nullOnDelete();
            }

            if (!Schema::hasColumn('pengumumans', 'sudah_dibaca')) {
                $table->boolean('sudah_dibaca')->default(false)->after('keterangan');
            }

            if (!Schema::hasColumn('pengumumans', 'dibaca_pada')) {
                $table->timestamp('dibaca_pada')->nullable()->after('sudah_dibaca');
            }
        });

        Schema::table('pengumumans', function (Blueprint $table) {
            if (Schema::hasColumn('pengumumans', 'published_at')) {
                $table->dropColumn('published_at');
            }

            if (Schema::hasColumn('pengumumans', 'is_published')) {
                $table->dropColumn('is_published');
            }
        });
    }
};
