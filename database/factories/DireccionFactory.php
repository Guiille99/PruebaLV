<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Direccion>
 */
class DireccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "cp"=>$this->faker->numberBetween(10000, 99999),
            "calle"=>$this->faker->streetName(),
            "numero"=>$this->faker->numberBetween(1, 100),
            "provincia_id"=>$this->faker->numberBetween(1, 30)
        ];
    }
}
