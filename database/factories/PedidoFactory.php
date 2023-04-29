<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha'=>$this->faker->date("Y-m-d H:m:s"),
            'total' => $this->faker->randomFloat(2, 2, 50), //2 decimales, número minimo 2 y número máximo 50
            'estado'=>$this->faker->randomElement(["Pre-admisión", "En camino", "En entrega", "Entregado"]),
            'tipo_pago'=>$this->faker->randomElement(["Tarjeta de crédito", "Bizum", "Paypal"]),
            'user_id'=>$this->faker->numberBetween(1, 30),
            'direccion_id'=>$this->faker->numberBetween(1, 30)
        ];
    }
}
