<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les produits existants
        $produits = Produit::all();

        foreach ($produits as $produit) {
            DB::table('inventaires')->insert([
                'produit_id' => $produit->id,
                'prix_total' => $produit->prix * $produit->quantite,
            ]);
        }
    }
}
