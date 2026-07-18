<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    protected $guarded = ['id'];

    public static function defaults(): array
    {
        return [
            'skl_agenda_tanggal' => 'Menunggu pengumuman panitia',
            'skl_agenda_waktu' => 'Menunggu pengumuman panitia',
            'skl_agenda_tempat' => 'MAN 1 BOGOR',
            'skl_agenda_keperluan' => 'Rapat Sosialisasi Program MAN 1 Bogor',
            'skl_ttd_tempat_tanggal' => 'Bogor, 19 Juni 2026',
            'skl_ketua_panitia' => 'WAHYU MULYADIN, SP, MM',
            'skl_nip_ketua_panitia' => '196806221999031003',
            'skl_tanda_tangan_ketua_panitia' => null,
        ];
    }

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $settings = static::first();
        return $settings ? $settings->$key : ($default ?? self::defaults()[$key] ?? null);
    }

    public static function getMany(array $keys): array
    {
        $defaults = static::defaults();
        $settings = static::first();

        return collect($keys)
            ->mapWithKeys(function ($key) use ($settings, $defaults) {
                return [$key => $settings ? $settings->$key : ($defaults[$key] ?? null)];
            })
            ->toArray();
    }

    public static function setMany(array $settings): void
    {
        $record = static::first();
        
        if ($record) {
            $record->update($settings);
        } else {
            static::create(array_merge(static::defaults(), $settings));
        }
    }
}
