<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nombre"=>$this->faker->text("80"),
            "slug"=>$this->faker->slug(),
            "cuerpo"=>$this->faker->text(),
            "portada"=>$this->faker->image('public/uploads/libros'),
            "user_id"=>$this->faker->numberBetween(1,30),
            "categoria_id"=>$this->faker->numberBetween(1,4)
        ];
    }
}
