<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    /** @test */
    public function it_can_list_users()
    {
        $user = User::factory()->create(); // utilisateur connecté
        User::factory()->count(3)->create(); // autres utilisateurs

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(4); // 1 connecté + 3 créés
    }


    /** @test */
    public function it_can_create_a_user()
    {
        $admin = User::factory()->create(); // utilisateur connecté
        $data = [
            'prenom' => 'Jean',
            'nom' => 'Dupont',
            'email' => 'jean@example.com',
            'password' => 'secret123',
            'role' => 'admin',
        ];

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/users', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['email' => 'jean@example.com']);

        $this->assertDatabaseHas('users', ['email' => 'jean@example.com']);
    }


    /** @test */
    public function it_can_show_a_user()
    {
        $admin = User::factory()->create(); // utilisateur connecté
        $user = User::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['email' => $user->email]);
    }


    /** @test */
    /** @test */
    public function it_can_update_a_user()
    {
        $admin = User::factory()->create(); // utilisateur connecté
        $user = User::factory()->create();

        $data = [
            'prenom' => 'Updated',
            'nom' => 'User',
        ];

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/users/{$user->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['prenom' => 'Updated']);

        $this->assertDatabaseHas('users', ['prenom' => 'Updated']);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $admin = User::factory()->create(); // utilisateur connecté
        $user = User::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }


    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'token']);
    }
    /** @test */

    public function it_can_logout_a_user()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret123'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Déconnexion réussie']);
    }
}
