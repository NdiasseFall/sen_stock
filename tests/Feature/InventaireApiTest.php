<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produit;
use App\Models\Inventaire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventaireApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_inventaires()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        Inventaire::factory()->create(['produit_id' => $produit->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/inventaires');

        $response->assertStatus(200)->assertJsonCount(1);
    }

    /** @test */
    public function it_can_show_an_inventaire()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $inventaire = Inventaire::factory()->create(['produit_id' => $produit->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/inventaires/{$inventaire->id}");

        $response->assertStatus(200)->assertJsonFragment(['id' => $inventaire->id]);
    }

    /** @test */
    public function it_can_create_an_inventaire()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();

        $data = [
            'produit_id' => $produit->id,
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/inventaires', $data);

        $response->assertStatus(201)->assertJsonFragment(['produit_id' => $produit->id]);
        $this->assertDatabaseHas('inventaires', ['produit_id' => $produit->id]);
    }

    /** @test */
    public function it_can_update_an_inventaire()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $inventaire = Inventaire::factory()->create(['produit_id' => $produit->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/inventaires/{$inventaire->id}", ['produit_id' => $produit->id]);

        $response->assertStatus(200)->assertJsonFragment(['produit_id' => $produit->id]);
        $this->assertDatabaseHas('inventaires', ['id' => $inventaire->id]);
    }

    /** @test */
    public function it_can_delete_an_inventaire()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create();
        $inventaire = Inventaire::factory()->create(['produit_id' => $produit->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/inventaires/{$inventaire->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('inventaires', ['id' => $inventaire->id]);
    }
}
