<?php

namespace Database\Seeders;

use App\Models\JadwalUjian;
use App\Models\Jalur;
use App\Models\Mapel;
use App\Models\Ruangan;
use Illuminate\Database\Seeder;

class SeleksiUjianSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRuangans();
        $this->seedMapelsPerJalur();
        $this->seedJadwalUjians();
    }

    private function seedRuangans(): void
    {
        $ruangans = [
            [
                'nama_ruangan' => 'RUANG 01',
                'lokasi' => 'Gedung Utama Lantai 1',
                'kapasitas' => 30,
                'deskripsi' => 'Ruang ujian seleksi reguler.',
            ],
            [
                'nama_ruangan' => 'RUANG 02',
                'lokasi' => 'Gedung Utama Lantai 1',
                'kapasitas' => 30,
                'deskripsi' => 'Ruang ujian seleksi reguler.',
            ],
            [
                'nama_ruangan' => 'RUANG 03',
                'lokasi' => 'Gedung Utama Lantai 2',
                'kapasitas' => 30,
                'deskripsi' => 'Ruang ujian seleksi reguler.',
            ],
            [
                'nama_ruangan' => 'RUANG 17',
                'lokasi' => 'Gedung Laboratorium',
                'kapasitas' => 25,
                'deskripsi' => 'Ruang ujian seleksi berbasis komputer.',
            ],
        ];

        foreach ($ruangans as $ruangan) {
            Ruangan::updateOrCreate(
                ['nama_ruangan' => $ruangan['nama_ruangan']],
                $ruangan
            );
        }
    }

    private function seedMapelsPerJalur(): void
    {
        $mapelsPerJalur = [
            'Reguler' => [
                'Tes Potensi Akademik',
                'Matematika Dasar',
                'Bahasa Indonesia',
            ],
            'Prestasi' => [
                'Tes Potensi Akademik',
                'Wawancara Prestasi',
                'Validasi Portofolio Prestasi',
            ],
            'Afirmasi' => [
                'Tes Potensi Akademik',
                'Wawancara Afirmasi',
                'BTQ',
            ],
        ];

        foreach ($mapelsPerJalur as $namaJalur => $namaMapels) {
            $jalur = Jalur::where('nama_jalur', $namaJalur)->first();

            if (!$jalur) {
                continue;
            }

            $syncData = [];

            foreach ($namaMapels as $index => $namaMapel) {
                $mapel = Mapel::firstOrCreate(
                    ['nama_mapel' => $namaMapel],
                    ['deskripsi' => "Mata pelajaran seleksi untuk jalur {$namaJalur}."]
                );

                $syncData[$mapel->id] = ['urutan' => $index + 1];
            }

            $jalur->mapels()->syncWithoutDetaching($syncData);
        }
    }

    private function seedJadwalUjians(): void
    {
        $jadwals = [
            'Reguler' => [
                'tanggal_ujian' => '2026-06-06',
                'waktu_mulai' => '07:30:00',
                'waktu_selesai' => '09:00:00',
                'tanggal_wawancara_btq' => '2026-06-10',
                'waktu_wawancara_btq' => '08:00:00',
                'tempat_wawancara_btq' => 'Aula MAN 1 Bogor',
                'catatan' => 'Peserta wajib membawa kartu peserta ujian dan alat tulis.',
            ],
            'Prestasi' => [
                'tanggal_ujian' => '2026-06-07',
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '09:30:00',
                'tanggal_wawancara_btq' => '2026-06-10',
                'waktu_wawancara_btq' => '09:30:00',
                'tempat_wawancara_btq' => 'Ruang Prestasi MAN 1 Bogor',
                'catatan' => 'Peserta wajib membawa dokumen pendukung prestasi asli.',
            ],
            'Afirmasi' => [
                'tanggal_ujian' => '2026-06-08',
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '09:30:00',
                'tanggal_wawancara_btq' => '2026-06-11',
                'waktu_wawancara_btq' => '08:00:00',
                'tempat_wawancara_btq' => 'Aula MAN 1 Bogor',
                'catatan' => 'Peserta wajib membawa dokumen afirmasi asli.',
            ],
        ];

        foreach ($jadwals as $namaJalur => $jadwal) {
            $jalur = Jalur::where('nama_jalur', $namaJalur)->first();

            if (!$jalur) {
                continue;
            }

            JadwalUjian::updateOrCreate(
                [
                    'jalur_id' => $jalur->id,
                    'tanggal_ujian' => $jadwal['tanggal_ujian'],
                    'waktu_mulai' => $jadwal['waktu_mulai'],
                ],
                array_merge($jadwal, ['jalur_id' => $jalur->id])
            );
        }
    }
}
