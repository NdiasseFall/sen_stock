<?php

namespace Tests\Feature;

use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorieApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    /** @test */
    public function it_can_list_categories()
    {
        $user = \App\Models\User::factory()->create(); // utilisateur connecté
        \App\Models\Categorie::factory()->count(3)->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }


    /** @test */
    public function it_can_show_a_category()
    {
        $user = \App\Models\User::factory()->create(); // utilisateur connecté
        \App\Models\Categorie::factory()->count(3)->create();
        $categorie = Categorie::factory()->create();
        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/categories/' . $categorie->id);
        $response->assertStatus(200)->assertJsonFragment(['id' => $categorie->id]);
    }

    /** @test */
    public function it_can_create_a_category()
    {
        $user = \App\Models\User::factory()->create(); // utilisateur connecté

        $data = ['nom' => 'Informatique'];

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/categories', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['nom' => 'Informatique']);

        $this->assertDatabaseHas('categories', ['nom' => 'Informatique']);
    }


    /** @test */
    public function it_can_update_a_category()
    {
        $user = \App\Models\User::factory()->create(); // utilisateur connecté
        $categorie = \App\Models\Categorie::factory()->create(['nom' => 'Bureau']);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/categories/{$categorie->id}", ['nom' => 'Accessoires']);

        $response->assertStatus(200)
            ->assertJsonFragment(['nom' => 'Accessoires']);

        $this->assertDatabaseHas('categories', ['nom' => 'Accessoires']);
    }


    /** @test */
    public function it_can_delete_a_category()
    {
        $user = \App\Models\User::factory()->create(); // utilisateur connecté
        $categorie = \App\Models\Categorie::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/categories/{$categorie->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('categories', ['id' => $categorie->id]);
    }
}
