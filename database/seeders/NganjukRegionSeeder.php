<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use Illuminate\Support\Str;

class NganjukRegionSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // 1. Buat provinsi Jawa Timur (jika belum ada)
        $provinsi = Region::firstOrCreate(
            ['slug' => 'jawa-timur', 'type' => 'provinsi'],
            ['name' => 'Jawa Timur', 'parent_id' => null]
        );

        // 2. Buat kota Nganjuk (jika belum ada)
        $kota = Region::firstOrCreate(
            ['slug' => 'kota-nganjuk', 'type' => 'kota'],
            ['name' => 'Kota Nganjuk', 'parent_id' => $provinsi->id]
        );

        // 3. Semua kecamatan di Kabupaten Nganjuk
        $kecamatanList = [
            'Bagor',
            'Baron',
            'Berbek',
            'Gondang',
            'Jatikalen',
            'Kertosono',
            'Lengkong',
            'Loceret',
            'Nganjuk',
            'Ngetos',
            'Ngluyu',
            'Ngronggot',
            'Pace',
            'Patianrowo',
            'Prambon',
            'Rejoso',
            'Sawahan',
            'Sukomoro',
            'Tanjunganom',
            'Wilangan'
        ];

        foreach ($kecamatanList as $nama) {
            Region::firstOrCreate(
                ['slug' => Str::slug($nama), 'type' => 'kecamatan'],
                ['name' => $nama, 'parent_id' => $kota->id]
            );
        }
    }
}
