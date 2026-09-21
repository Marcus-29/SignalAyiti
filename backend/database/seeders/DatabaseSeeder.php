<?php

namespace Database\Seeders;

use App\Models\Intervention;
use App\Models\Notification;
use App\Models\Signalement;
use App\Models\User;
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
        $agent = User::factory()->agent()->create([
            'name' => 'Agent Communal',
            'email' => 'agent@signalayiti.ht',
            'quartier' => 'Mairie de Delmas',
        ]);

        $citoyens = User::factory()->count(4)->create();

        User::factory()->create([
            'name' => 'Citoyen Demo',
            'email' => 'citoyen@signalayiti.ht',
        ]);

        $signalements = Signalement::factory()
            ->count(14)
            ->recycle($citoyens)
            ->create();

        foreach ($signalements as $signalement) {
            if ($signalement->statut === 'nouveau') {
                continue;
            }

            $intervention = Intervention::create([
                'signalement_id' => $signalement->id,
                'agent_id' => $agent->id,
                'ancien_statut' => 'nouveau',
                'nouveau_statut' => $signalement->statut,
                'commentaire' => match ($signalement->statut) {
                    'en_cours' => 'Une équipe technique a été envoyée sur place.',
                    'resolu' => 'Le problème a été corrigé par les services de la commune.',
                    'rejete' => 'Signalement en dehors du périmètre de la commune.',
                    default => null,
                },
            ]);

            Notification::create([
                'user_id' => $signalement->user_id,
                'signalement_id' => $signalement->id,
                'message' => "Votre signalement \"{$signalement->titre}\" est passé au statut : ".Signalement::statutLabel($signalement->statut).'.',
                'lu' => fake()->boolean(40),
                'created_at' => $intervention->created_at,
            ]);
        }
    }
}
