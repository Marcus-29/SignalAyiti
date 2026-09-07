<?php

namespace Tests\Feature\Api;

use App\Models\Notification;
use App\Models\Signalement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignalementTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_citoyen_peut_creer_un_signalement(): void
    {
        $citoyen = User::factory()->create();

        $response = $this->actingAs($citoyen, 'sanctum')->postJson('/api/signalements', [
            'categorie' => 'route',
            'titre' => 'Nid de poule rue principale',
            'description' => 'Un gros trou dangereux pour les motos.',
            'quartier' => 'Delmas 33',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.statut', 'nouveau')
            ->assertJsonPath('data.categorie', 'route');

        $this->assertDatabaseHas('signalements', [
            'titre' => 'Nid de poule rue principale',
            'user_id' => $citoyen->id,
        ]);
    }

    public function test_la_creation_echoue_sans_les_champs_obligatoires(): void
    {
        $citoyen = User::factory()->create();

        $response = $this->actingAs($citoyen, 'sanctum')->postJson('/api/signalements', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['categorie', 'titre', 'description', 'quartier']);
    }

    public function test_un_citoyen_ne_voit_que_ses_propres_signalements(): void
    {
        $citoyen = User::factory()->create();
        $autreCitoyen = User::factory()->create();

        Signalement::factory()->create(['user_id' => $citoyen->id]);
        Signalement::factory()->create(['user_id' => $autreCitoyen->id]);

        $response = $this->actingAs($citoyen, 'sanctum')->getJson('/api/signalements');

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
    }

    public function test_un_agent_voit_tous_les_signalements(): void
    {
        $agent = User::factory()->agent()->create();
        Signalement::factory()->count(3)->create();

        $response = $this->actingAs($agent, 'sanctum')->getJson('/api/signalements');

        $response->assertOk();
        $this->assertCount(3, $response->json('data'));
    }

    public function test_un_citoyen_ne_peut_pas_changer_le_statut_d_un_signalement(): void
    {
        $citoyen = User::factory()->create();
        $signalement = Signalement::factory()->create(['user_id' => $citoyen->id]);

        $response = $this->actingAs($citoyen, 'sanctum')->putJson("/api/signalements/{$signalement->id}/statut", [
            'statut' => 'resolu',
        ]);

        $response->assertStatus(403);
    }

    public function test_un_agent_peut_changer_le_statut_et_une_notification_est_creee(): void
    {
        $agent = User::factory()->agent()->create();
        $citoyen = User::factory()->create();
        $signalement = Signalement::factory()->create(['user_id' => $citoyen->id, 'statut' => 'nouveau']);

        $response = $this->actingAs($agent, 'sanctum')->putJson("/api/signalements/{$signalement->id}/statut", [
            'statut' => 'en_cours',
            'commentaire' => 'Equipe technique envoyee sur place.',
        ]);

        $response->assertOk()->assertJsonPath('data.statut', 'en_cours');

        $this->assertDatabaseHas('interventions', [
            'signalement_id' => $signalement->id,
            'agent_id' => $agent->id,
            'ancien_statut' => 'nouveau',
            'nouveau_statut' => 'en_cours',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $citoyen->id,
            'signalement_id' => $signalement->id,
        ]);
    }

    public function test_un_citoyen_ne_peut_pas_consulter_le_signalement_d_un_autre(): void
    {
        $citoyen = User::factory()->create();
        $autreCitoyen = User::factory()->create();
        $signalement = Signalement::factory()->create(['user_id' => $autreCitoyen->id]);

        $response = $this->actingAs($citoyen, 'sanctum')->getJson("/api/signalements/{$signalement->id}");

        $response->assertStatus(403);
    }

    public function test_un_citoyen_peut_supprimer_un_signalement_encore_nouveau(): void
    {
        $citoyen = User::factory()->create();
        $signalement = Signalement::factory()->create(['user_id' => $citoyen->id, 'statut' => 'nouveau']);

        $response = $this->actingAs($citoyen, 'sanctum')->deleteJson("/api/signalements/{$signalement->id}");

        $response->assertOk();
        $this->assertDatabaseMissing('signalements', ['id' => $signalement->id]);
    }

    public function test_un_citoyen_ne_peut_pas_supprimer_un_signalement_deja_pris_en_charge(): void
    {
        $citoyen = User::factory()->create();
        $signalement = Signalement::factory()->create(['user_id' => $citoyen->id, 'statut' => 'en_cours']);

        $response = $this->actingAs($citoyen, 'sanctum')->deleteJson("/api/signalements/{$signalement->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('signalements', ['id' => $signalement->id]);
    }

    public function test_seul_un_agent_peut_consulter_le_tableau_de_bord(): void
    {
        $citoyen = User::factory()->create();

        $response = $this->actingAs($citoyen, 'sanctum')->getJson('/api/dashboard/stats');

        $response->assertStatus(403);
    }

    public function test_un_agent_peut_consulter_le_tableau_de_bord(): void
    {
        $agent = User::factory()->agent()->create();
        Signalement::factory()->count(2)->create(['statut' => 'nouveau']);

        $response = $this->actingAs($agent, 'sanctum')->getJson('/api/dashboard/stats');

        $response->assertOk()->assertJsonStructure(['total', 'par_statut', 'par_categorie', 'par_quartier']);
    }

    public function test_un_citoyen_peut_marquer_une_notification_comme_lue(): void
    {
        $citoyen = User::factory()->create();
        $signalement = Signalement::factory()->create(['user_id' => $citoyen->id]);
        $notification = Notification::create([
            'user_id' => $citoyen->id,
            'signalement_id' => $signalement->id,
            'message' => 'Test notification',
        ]);

        $response = $this->actingAs($citoyen, 'sanctum')->putJson("/api/notifications/{$notification->id}/lu");

        $response->assertOk()->assertJsonPath('data.lu', true);
    }
}
