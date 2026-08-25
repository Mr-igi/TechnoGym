<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Membership plans are inserted by their own migration, so they are not
     * repeated here. Every seeder below is idempotent — running `db:seed`
     * twice will not create duplicates.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            TrainerSeeder::class,
        ]);
    }
}
