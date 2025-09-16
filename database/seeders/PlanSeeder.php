<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Bronze: lifetime, max 3 kecamatan, gratis
        Plan::updateOrCreate(
            ['name' => 'Bronze'],
            [
                'quota_region' => 3,
                'duration_days' => null, // null = lifetime (tidak kedaluwarsa)
                'price' => 0,
            ]
        );

        // Silver: 30 hari, max 8 kecamatan (3 default + 5 tambahan)
        Plan::updateOrCreate(
            ['name' => 'Silver'],
            [
                'quota_region' => 8,
                'duration_days' => 30,
                'price' => 50000, // ganti sesuai kebutuhan
            ]
        );

        // Gold: 30 hari, unlimited kecamatan dalam satu kota
        Plan::updateOrCreate(
            ['name' => 'Gold'],
            [
                'quota_region' => null, // null = unlimited
                'duration_days' => 30,
                'price' => 150000, // ganti sesuai kebutuhan
            ]
        );
    }
}
