<?php

namespace Database\Factories;

use App\Models\Inventaire;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inventaire>
 */
class InventaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prix_total' => $this->faker->numberBetween(1000, 500000),
            'produit_id' => Produit::factory(), // crée un produit lié automatiquement
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
