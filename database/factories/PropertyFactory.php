<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Enums\PropertyStatus;
use App\Models\PropertyAddress;
use App\Models\Property;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  =>  fake()->randomElement([ucfirst(implode(' ', fake()->words(fake()->numberBetween(1, 7)))), fake()->streetName()]).' '.fake()->randomElement(['Grove', 'Manor', 'Villa', 'House']),
            'owner_id'   =>  User::inRandomOrder()->firstOrFail()->id,
            'status_id'  =>  fake()->randomElement(PropertyStatus::values()),
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Property $property) {
            PropertyAddress::factory()->make(['property_id' => $property->id]);
        })->afterCreating(function (Property $property) {
            PropertyAddress::factory()->create(['property_id' => $property->id]);
        });
    }
}
