<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('cities')->truncate();
        Schema::enableForeignKeyConstraints();

        $romanianCities = [
            252 => 
            array (
                'name' => 'Alba Iulia',
            ),
            253 => 
            array (
                'name' => 'Arad',
            ),
            254 => 
            array (
                'name' => 'Oradea',
            ),
            255 => 
            array (
                'name' => 'Bacau',
            ),
            256 => 
            array (
                'name' => 'Baia Mare',
            ),
            257 => 
            array (
                'name' => 'Bistrita',
            ),
            258 => 
            array (
                'name' => 'Botosani',
            ),
            259 => 
            array (
                'name' => 'Bucuresti',
            ),
            260 => 
            array (
                'name' => 'Brasov',
            ),
            261 => 
            array (
                'name' => 'Braila',
            ),
            262 => 
            array (
                'name' => 'Buzau',
            ),
            263 => 
            array (
                'name' => 'Drobeta-Turnu Severin',
            ),
            264 => 
            array (
                'name' => 'Deva',
            ),
            265 => 
            array (
                'name' => 'Timisoara',
            ),
            266 => 
            array (
                'name' => 'Focsani',
            ),
            267 => 
            array (
                'name' => 'Galati',
            ),
            268 => 
            array (
                'name' => 'Giurgiu',
            ),
            269 => 
            array (
                'name' => 'Constanta',
            ),
            270 => 
            array (
                'name' => 'Craiova',
            ),
            271 => 
            array (
                'name' => 'Calarasi',
            ),
            272 => 
            array (
                'name' => 'Cluj-Napoca',
            ),
            273 => 
            array (
                'name' => 'Rimnicu Vilcea',
            ),
            274 => 
            array (
                'name' => 'Resita',
            ),
            275 => 
            array (
                'name' => 'Miercurea-Ciuc',
            ),
            276 => 
            array (
                'name' => 'Pitesti',
            ),
            277 => 
            array (
                'name' => 'Piatra Neamt',
            ),
            278 => 
            array (
                'name' => 'Ploiesti',
            ),
            279 => 
            array (
                'name' => 'Satu Mare',
            ),
            280 => 
            array (
                'name' => 'Sfantu-Gheorghe',
            ),
            281 => 
            array (
                'name' => 'Slatina',
            ),
            282 => 
            array (
                'name' => 'Slobozia',
            ),
            283 => 
            array (
                'name' => 'Suceava',
            ),
            284 => 
            array (
                'name' => 'Targovişte',
            ),
            285 => 
            array (
                'name' => 'Tirgu Mures',
            ),
            286 => 
            array (
                'name' => 'Tirgu-Jiu',
            ),
            287 => 
            array (
                'name' => 'Tulcea',
            ),
            288 => 
            array (
                'name' => 'Vaslui',
            ),
            289 => 
            array (
                'name' => 'Sibiu',
            ),
            290 => 
            array (
                'name' => 'Iasi',
            ),
            291 => 
            array (
                'name' => 'Alexandria',
            ),
            292 => 
            array (
                'name' => 'Zalau',
            ),
        ];

        $romaniaId = DB::table('countries')
                        ->where('code', 'RO')
                        ->select('id')
                        ->firstOrFail()
                        ->id;

        array_walk($romanianCities, function (&$city) use ($romaniaId) {
            $city['country_id'] = $romaniaId;
            $city['created_at'] = date('Y-m-d H:i:s');
        });

        DB::table('cities')->insert($romanianCities);
    }
}