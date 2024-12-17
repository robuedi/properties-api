<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PropertyStatusesTableSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('property_statuses')->truncate();
        Schema::enableForeignKeyConstraints();

        $propertyStatuses = [
          ['id' => 1, 'name' => 'active', 'created_at' => date('Y-m-d H:i:s')],
          ['id' => 2, 'name'=>'inactive', 'created_at' => date('Y-m-d H:i:s')]
        ];

        DB::table('property_statuses')->insert($propertyStatuses);
    }
}