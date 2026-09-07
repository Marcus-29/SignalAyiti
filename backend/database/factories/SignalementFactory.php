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
        'electricite' => 'Panne d\'electricite recurrente (EDH)',
        'dechets' => 'Ordures non ramassees depuis une semaine',
        'eclairage' => 'Lampadaire public en panne',
        'securite' => 'Zone mal eclairee et insecurisante la nuit',
        'autre' => 'Probleme communautaire a signaler',
    ];

    private const DESCRIPTIONS = [
        'route' => 'Un grand nid de poule s\'est forme sur la route principale et rend la circulation difficile, surtout pour les motos et les pietons en saison de pluie.',
        'eau' => 'Le quartier n\'a plus recu d\'eau potable au robinet depuis plusieurs jours. Les familles doivent aller chercher de l\'eau plus loin.',
        'electricite' => 'Les coupures de courant sont tres frequentes ces derniers temps et durent parfois plusieurs heures, ce qui gene les commerces du quartier.',
        'dechets' => 'Les ordures s\'accumulent au coin de la rue depuis une semaine et commencent a degager une mauvaise odeur, avec un risque pour la sante.',
        'eclairage' => 'Le lampadaire public ne fonctionne plus depuis quelques semaines, ce qui rend la rue tres sombre et peu sure la nuit.',
        'securite' => 'Plusieurs habitants signalent un sentiment d\'insecurite dans cette zone, surtout en soiree, en raison du manque d\'eclairage et de presence policiere.',
        'autre' => 'Un probleme communautaire a ete observe dans le quartier et merite l\'attention des services de la commune.',
    ];

    private const QUARTIERS = ['Delmas 33', 'Petion-Ville', 'Carrefour-Feuilles', 'Cap-Haitien Centre', 'Croix-des-Bouquets', 'Cite Soleil'];

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
