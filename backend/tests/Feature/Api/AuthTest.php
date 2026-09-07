<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_citoyen_peut_creer_un_compte(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Jean Baptiste',
            'email' => 'jean.baptiste@example.com',
            'password' => 'motdepasse123',
            'password_confirmation' => 'motdepasse123',
            'quartier' => 'Delmas 33',
        ]);

        $response->assertCreated()
            ->assertJsonPath('user.email', 'jean.baptiste@example.com')
            ->assertJsonPath('user.role', 'citoyen')
            ->assertJsonStructure(['user', 'token']);

        $this->assertDatabaseHas('users', [
            'email' => 'jean.baptiste@example.com',
            'role' => 'citoyen',
        ]);
    }

    public function test_l_inscription_echoue_si_l_email_est_deja_utilise(): void
    {
        User::factory()->create(['email' => 'existe@example.com']);

        $response = $this->postJson('/api/register', [
            'name' => 'Doublon',
            'email' => 'existe@example.com',
            'password' => 'motdepasse123',
            'password_confirmation' => 'motdepasse123',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors('email');
    }

    public function test_un_utilisateur_peut_se_connecter_avec_de_bons_identifiants(): void
    {
        User::factory()->create([
            'email' => 'marie@example.com',
            'password' => Hash::make('motdepasse123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'marie@example.com',
            'password' => 'motdepasse123',
        ]);

        $response->assertOk()->assertJsonStructure(['user', 'token']);
    }

    public function test_la_connexion_echoue_avec_un_mauvais_mot_de_passe(): void
    {
        User::factory()->create([
            'email' => 'marie@example.com',
            'password' => Hash::make('motdepasse123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'marie@example.com',
            'password' => 'mauvais_mot_de_passe',
        ]);

        $response->assertStatus(422);
    }

    public function test_un_utilisateur_non_connecte_ne_peut_pas_acceder_a_son_profil(): void
    {
        $response = $this->getJson('/api/me');

        $response->assertStatus(401);
    }

    public function test_un_utilisateur_connecte_peut_consulter_son_profil(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/me');

        $response->assertOk()->assertJsonPath('data.email', $user->email);
    }
}
