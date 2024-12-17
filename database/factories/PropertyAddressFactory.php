<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\City;
use App\Models\Property;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyAddress>
 */
class PropertyAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id'       =>  City::inRandomOrder()->firstOrFail()->id,
            'property_id'   =>  Property::factory(),
            'address_line'  =>  fake()->streetAddress()
        ];
    }
}
