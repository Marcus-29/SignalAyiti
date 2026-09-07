<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Signalement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Statistiques publiques et resumees, affichees sur la page d'accueil.
     */
    public function publicStats()
    {
        return response()->json([
            'resolus' => Signalement::where('statut', 'resolu')->count(),
            'en_cours' => Signalement::where('statut', 'en_cours')->count(),
            'quartiers_actifs' => Signalement::distinct('quartier')->count('quartier'),
        ]);
    }

    public function stats()
    {
        $parStatut = Signalement::query()
            ->select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->pluck('total', 'statut');

        $parCategorie = Signalement::query()
            ->select('categorie', DB::raw('count(*) as total'))
            ->groupBy('categorie')
            ->pluck('total', 'categorie');

        $parQuartier = Signalement::query()
            ->select('quartier', DB::raw('count(*) as total'))
            ->groupBy('quartier')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'quartier');

        return response()->json([
            'total' => Signalement::count(),
            'par_statut' => $parStatut,
            'par_categorie' => $parCategorie,
            'par_quartier' => $parQuartier,
        ]);
    }
}
