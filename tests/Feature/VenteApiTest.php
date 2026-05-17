<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use App\Models\Vente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VenteApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_ventes()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        Vente::factory()->create(['produit_id' => $produit->id, 'quantite' => 2, 'prix_total' => 5000]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/ventes');

        $response->assertStatus(200)->assertJsonCount(1);
    }

    /** @test */
    public function it_can_show_a_vente()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $vente = Vente::factory()->create(['produit_id' => $produit->id, 'quantite' => 3, 'prix_total' => 7500]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/ventes/{$vente->id}");

        $response->assertStatus(200)->assertJsonFragment(['id' => $vente->id]);
    }

    /** @test */
    public function it_can_create_a_vente()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();

        $data = [
            'type_transaction' => 'sortie',
            'produit_id' => $produit->id,
            'quantite'   => 4,
            'prix_total' => 10000,
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/ventes', $data);

        $response->assertStatus(201)->assertJsonFragment(['quantite' => 4]);
        $this->assertDatabaseHas('ventes', ['produit_id' => $produit->id, 'quantite' => 4]);
    }

    /** @test */
    public function it_can_update_a_vente()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $vente = Vente::factory()->create(['produit_id' => $produit->id, 'quantite' => 2, 'prix_total' => 5000]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/ventes/{$vente->id}", ['quantite' => 5, 'prix_total' => 12500]);

        $response->assertStatus(200)->assertJsonFragment(['quantite' => 5]);
        $this->assertDatabaseHas('ventes', ['id' => $vente->id, 'quantite' => 5]);
    }

    /** @test */
    public function it_can_delete_a_vente()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $vente = Vente::factory()->create(['produit_id' => $produit->id, 'quantite' => 1, 'prix_total' => 2500]);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/ventes/{$vente->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('ventes', ['id' => $vente->id]);
    }
}
