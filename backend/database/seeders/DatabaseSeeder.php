<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ClinicsTableSeeder::class,
            UsersTableSeeder::class,
            ServicesTableSeeder::class,
            DoctorSchedulesTableSeeder::class,
            InventoryItemsTableSeeder::class,
            CmsAndThemeSeeder::class,
        ]);
    }
}
