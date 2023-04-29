<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "cuerpo"=>$this->faker->text(),
            "post_id"=>$this->faker->numberBetween(1,30),
            "user_id"=>$this->faker->numberBetween(1,30)
        ];
    }
}
