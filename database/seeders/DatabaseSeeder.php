<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory(20)->create();
        $this->call(CategoriesSeeder::class);
        \App\Models\Produit::factory(50)->create();
        $this->call(InventaireSeeder::class);
        \App\Models\Vente::factory(30)->create(); // 30 ventes générées

    }
}
