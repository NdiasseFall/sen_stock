<?php

namespace Database\Factories;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->word(), // Exemple : "Ordinateur"
            'description' => $this->faker->sentence(10), // Phrase descriptive
            'prix' => $this->faker->numberBetween(1000, 500000), // Prix aléatoire
            'quantite' => $this->faker->numberBetween(1, 100), // Quantité aléatoire
            'categorie_id' => $this->faker->numberBetween(1, 5), // Id de catégorie (à adapter selon tes catégories réelles)
        ];
    }
}
