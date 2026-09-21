<?php

namespace Database\Factories;

use App\Models\Signalement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Signalement>
 */
class SignalementFactory extends Factory
{
    protected $model = Signalement::class;

    private const TITRES = [
        'route' => 'Nid de poule dangereux sur la route',
        'eau' => 'Coupure d\'eau potable depuis plusieurs jours',
        'electricite' => 'Panne d\'électricité récurrente (EDH)',
        'dechets' => 'Ordures non ramassées depuis une semaine',
        'eclairage' => 'Lampadaire public en panne',
        'securite' => 'Zone mal éclairée et insécurisante la nuit',
        'autre' => 'Problème communautaire à signaler',
    ];

    private const DESCRIPTIONS = [
        'route' => 'Un grand nid de poule s\'est formé sur la route principale et rend la circulation difficile, surtout pour les motos et les piétons en saison de pluie.',
        'eau' => 'Le quartier n\'a plus reçu d\'eau potable au robinet depuis plusieurs jours. Les familles doivent aller chercher de l\'eau plus loin.',
        'electricite' => 'Les coupures de courant sont très fréquentes ces derniers temps et durent parfois plusieurs heures, ce qui gêne les commerces du quartier.',
        'dechets' => 'Les ordures s\'accumulent au coin de la rue depuis une semaine et commencent à dégager une mauvaise odeur, avec un risque pour la santé.',
        'eclairage' => 'Le lampadaire public ne fonctionne plus depuis quelques semaines, ce qui rend la rue très sombre et peu sûre la nuit.',
        'securite' => 'Plusieurs habitants signalent un sentiment d\'insécurité dans cette zone, surtout en soirée, en raison du manque d\'éclairage et de présence policière.',
        'autre' => 'Un problème communautaire a été observé dans le quartier et mérite l\'attention des services de la commune.',
    ];

    private const QUARTIERS = ['Delmas 33', 'Pétion-Ville', 'Carrefour-Feuilles', 'Cap-Haïtien Centre', 'Croix-des-Bouquets', 'Cité Soleil'];

    public function definition(): array
    {
        $categorie = fake()->randomElement(Signalement::CATEGORIES);

        return [
            'user_id' => User::factory(),
            'categorie' => $categorie,
            'titre' => self::TITRES[$categorie],
            'description' => self::DESCRIPTIONS[$categorie],
            'quartier' => fake()->randomElement(self::QUARTIERS),
            'statut' => fake()->randomElement(Signalement::STATUTS),
        ];
    }
}
