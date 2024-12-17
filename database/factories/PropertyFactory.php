<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\PropertyStatus;
use App\Services\TextUniqueSlugService;

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
        $slugGenerator = app(TextUniqueSlugService::class);
        
        return [
            'name'  =>  fake()->randomElement([ucfirst(implode(' ', fake()->words(fake()->numberBetween(1, 7)))), fake()->streetName()]).' '.fake()->randomElement(['Grove', 'Manor', 'Villa', 'House']),
            'slug'  =>  function (array $attributes) use (&$slugGenerator) {
                return $slugGenerator->getSlug($attributes['name']);
            },
            'owner_id'   =>  User::inRandomOrder()->firstOrFail()->id,
            'status_id'  =>  PropertyStatus::inRandomOrder()->firstOrFail()->id,
        ];
    }
}
