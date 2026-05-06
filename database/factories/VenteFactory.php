<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Produit;
use App\Models\Vente;

/**
 * @extends Factory<Vente>
 */
class VenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // On choisit un produit existant pour la vente
        $produit = Produit::inRandomOrder()->first();

        // Générer une quantité aléatoire
        $quantite = $this->faker->numberBetween(1, 50);

        return [
            'type_transaction' => $this->faker->randomElement(['entre', 'sortie']),
            'quantite' => $quantite,
            'produit_id' => $produit ? $produit->id : Produit::factory(),
            'prix_total' => $produit ? $produit->prix * $quantite : $this->faker->numberBetween(1000, 50000),
        ];
    }
}