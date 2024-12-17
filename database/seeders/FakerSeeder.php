<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\PropertyAddress;

class FakerSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(58)->create();

        //this will make both properties and property
        PropertyAddress::factory()->count(127)->create();
    }
}