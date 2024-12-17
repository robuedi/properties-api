<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\CitiesTableSeeder;
use Database\Seeders\PropertyStatusesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CountriesTableSeeder::class,
            CitiesTableSeeder::class,
            PropertyStatusesTableSeeder::class
        ]);
    }
}
