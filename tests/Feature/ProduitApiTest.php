<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProduitApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_produits()
    {
        $user = User::factory()->create();
        $categorie = Categorie::factory()->create();
        Produit::factory()->create(['nom' => 'Clavier', 'categorie_id' => $categorie->id]);
        Produit::factory()->create(['nom' => 'Souris', 'categorie_id' => $categorie->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/produits');

        $response->assertStatus(200)
            ->assertJsonFragment(['nom' => 'Clavier'])
            ->assertJsonFragment(['nom' => 'Souris']);
    }

    /** @test */
    public function it_can_show_a_produit()
    {
        $user = User::factory()->create();
        $categorie = Categorie::factory()->create();
        $produit = Produit::factory()->create(['nom' => 'Ordinateur', 'categorie_id' => $categorie->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/produits/{$produit->id}");

        $response->assertStatus(200)->assertJsonFragment(['nom' => 'Ordinateur']);
    }

    /** @test */
    public function it_can_create_a_produit()
    {
        $user = User::factory()->create();
        $categorie = Categorie::factory()->create();

        $data = [
            'nom'          => 'Imprimante',
            'description'   => 'Imprimante multifonction rapide et fiable',
            'prix'         => 150000,
            'quantite'     => 5,
            'categorie_id' => $categorie->id,
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/produits', $data);

        $response->assertStatus(201)->assertJsonFragment(['nom' => 'Imprimante']);
        $this->assertDatabaseHas('produits', ['nom' => 'Imprimante']);
    }

    /** @test */
    public function it_can_update_a_produit()
    {
        $user = User::factory()->create();
        $categorie = Categorie::factory()->create();
        $produit = Produit::factory()->create(['nom' => 'Scanner', 'categorie_id' => $categorie->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/produits/{$produit->id}", ['nom' => 'Scanner Pro']);

        $response->assertStatus(200)->assertJsonFragment(['nom' => 'Scanner Pro']);
        $this->assertDatabaseHas('produits', ['id' => $produit->id, 'nom' => 'Scanner Pro']);
    }

    /** @test */
    public function it_can_delete_a_produit()
    {
        $user = User::factory()->create();
        $categorie = Categorie::factory()->create();
        $produit = Produit::factory()->create(['nom' => 'Tablette', 'categorie_id' => $categorie->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/produits/{$produit->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('produits', ['id' => $produit->id]);
    }
}
