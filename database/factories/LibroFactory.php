<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(), 
            'autor' => $this->faker->name(),
            'editorial' => $this->faker->randomElement(["Anaya", "Booket", "Ecobook", "Edebé", "Kairós", "Librooks", "Pálido Fuego", "Phoebe", "Raíces", "Reverté", "Umbriel", "Underwood", "VV Kids", "Wave Books"]),
            'portada' => $this->faker->image('public/uploads/libros', 300, 480, 'book'),
            'isbn' => $this->faker->unique()->bothify("###-##-####-###-#"),
            'fecha_publicacion' => $this->faker->dateTimeThisDecade(), //Fechas aleatorias de la última década
            'precio' => $this->faker->randomFloat(2, 2, 50), //2 decimales, número minimo 2 y número máximo 50
            'genero' => $this->faker->randomElement(["Infantil y juvenil", "Aventuras", "Comedia", "Misterio", "Terror", "Amor", "Artes", "Ficción", "Deporte", "Fantasía", "Gastronomía", "Historia", "Idiomas", "Clásicos", "Psicología-Autoayuda", "Informática", "Ciencia"]),
            'descripcion' => $this->faker->paragraph(),
            'valoracion' => $this->faker->numberBetween(1, 10),
            'paginas' => $this->faker->numberBetween(80, 400),
            'stock' => $this->faker->numberBetween(0, 100)
        ];
    }
}
