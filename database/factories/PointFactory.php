<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Point>
 */
class PointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('ru_RU');
        $titlePrefixes = ['Городская', 'Районная', 'Детская', 'Военная'];
        $titleSuffixes = ['Поликлиника', 'Больница'];
        return [
            'title' => $this->faker->randomElement($titlePrefixes) . ' ' . $this->faker->randomElement($titleSuffixes) . ' ' . $this->faker->numberBetween(1, 100),
            'city' => $this->faker->city,
            'address' => $this->faker->streetAddress(),
            'geolocation' => $this->faker->latitude . ', ' . $this->faker->longitude, // Случайная широта
            'first_blood_group_count' => $this->faker->numberBetween(0, 200),
            'second_blood_group_count' => $this->faker->numberBetween(0, 200),
            'third_blood_group_count' => $this->faker->numberBetween(0, 200),
            'fourth_blood_group_count' => $this->faker->numberBetween(0, 200),
            'enough_count' => $this->faker->numberBetween(80, 120),
        ];
    }
}
