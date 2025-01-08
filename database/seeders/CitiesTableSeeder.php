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
            252 => [
                'name' => 'Alba Iulia',
            ],
            253 => [
                'name' => 'Arad',
            ],
            254 => [
                'name' => 'Oradea',
            ],
            255 => [
                'name' => 'Bacau',
            ],
            256 => [
                'name' => 'Baia Mare',
            ],
            257 => [
                'name' => 'Bistrita',
            ],
            258 => [
                'name' => 'Botosani',
            ],
            259 => [
                'name' => 'Bucuresti',
            ],
            260 => [
                'name' => 'Brasov',
            ],
            261 => [
                'name' => 'Braila',
            ],
            262 => [
                'name' => 'Buzau',
            ],
            263 => [
                'name' => 'Drobeta-Turnu Severin',
            ],
            264 => [
                'name' => 'Deva',
            ],
            265 => [
                'name' => 'Timisoara',
            ],
            266 => [
                'name' => 'Focsani',
            ],
            267 => [
                'name' => 'Galati',
            ],
            268 => [
                'name' => 'Giurgiu',
            ],
            269 => [
                'name' => 'Constanta',
            ],
            270 => [
                'name' => 'Craiova',
            ],
            271 => [
                'name' => 'Calarasi',
            ],
            272 => [
                'name' => 'Cluj-Napoca',
            ],
            273 => [
                'name' => 'Rimnicu Vilcea',
            ],
            274 => [
                'name' => 'Resita',
            ],
            275 => [
                'name' => 'Miercurea-Ciuc',
            ],
            276 => [
                'name' => 'Pitesti',
            ],
            277 => [
                'name' => 'Piatra Neamt',
            ],
            278 => [
                'name' => 'Ploiesti',
            ],
            279 => [
                'name' => 'Satu Mare',
            ],
            280 => [
                'name' => 'Sfantu-Gheorghe',
            ],
            281 => [
                'name' => 'Slatina',
            ],
            282 => [
                'name' => 'Slobozia',
            ],
            283 => [
                'name' => 'Suceava',
            ],
            284 => [
                'name' => 'Targovişte',
            ],
            285 => [
                'name' => 'Tirgu Mures',
            ],
            286 => [
                'name' => 'Tirgu-Jiu',
            ],
            287 => [
                'name' => 'Tulcea',
            ],
            288 => [
                'name' => 'Vaslui',
            ],
            289 => [
                'name' => 'Sibiu',
            ],
            290 => [
                'name' => 'Iasi',
            ],
            291 => [
                'name' => 'Alexandria',
            ],
            292 => [
                'name' => 'Zalau',
            ],
        ];

        $romaniaId = DB::table('countries')
            ->where('code', 'RO')
            ->select('id')
            ->firstOrFail()
            ->id;

        $i = 1;
        array_walk($romanianCities, function (&$city) use ($romaniaId, &$i) {
            $city['id'] = $i++;
            $city['country_id'] = $romaniaId;
            $city['created_at'] = date('Y-m-d H:i:s');
        });

        DB::table('cities')->insert($romanianCities);
    }
}
