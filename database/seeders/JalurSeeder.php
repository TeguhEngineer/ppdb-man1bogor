<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jalur;

class JalurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jalurs = [
            [
                'nama_jalur' => 'Reguler',
                'total_kuota' => 150,
                'deskripsi' => 'Jalur penerimaan umum berdasarkan zonasi dan tes reguler.'
            ],
            [
                'nama_jalur' => 'Prestasi',
                'total_kuota' => 50,
                'deskripsi' => 'Jalur penerimaan khusus bagi siswa berprestasi akademik maupun non-akademik.'
            ],
            [
                'nama_jalur' => 'Afirmasi',
                'total_kuota' => 30,
                'deskripsi' => 'Jalur penerimaan khusus bagi siswa dari keluarga ekonomi tidak mampu.'
            ],
        ];

        foreach ($jalurs as $jalur) {
            Jalur::create($jalur);
        }
    }
}
