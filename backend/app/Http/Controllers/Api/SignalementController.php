<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSignalementRequest;
use App\Http\Requests\UpdateSignalementStatutRequest;
use App\Http\Resources\SignalementResource;
use App\Models\Intervention;
use App\Models\Notification;
use App\Models\Signalement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignalementController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Signalement::query()->with('user')->latest();

        if (! $user->isAgent()) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->string('statut'));
        }

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->string('categorie'));
        }

        if ($request->filled('quartier')) {
            $query->where('quartier', 'like', '%'.$request->string('quartier').'%');
        }

        $signalements = $query->paginate(10);

        return SignalementResource::collection($signalements);
    }

    public function store(StoreSignalementRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('signalements', 'public');
        }

        $signalement = Signalement::create([
            ...$data,
            'user_id' => $request->user()->id,
            'statut' => 'nouveau',
        ]);

        return new SignalementResource($signalement->load('user'));
    }

    public function show(Request $request, Signalement $signalement)
    {
        $user = $request->user();

        if (! $user->isAgent() && $signalement->user_id !== $user->id) {
            abort(403, 'Ce signalement ne vous appartient pas.');
        }

        return new SignalementResource($signalement->load(['user', 'interventions.agent']));
    }

    public function updateStatut(UpdateSignalementStatutRequest $request, Signalement $signalement)
    {
        $ancienStatut = $signalement->statut;
        $nouveauStatut = $request->string('statut')->value();

        $signalement->update(['statut' => $nouveauStatut]);

        Intervention::create([
            'signalement_id' => $signalement->id,
            'agent_id' => $request->user()->id,
            'ancien_statut' => $ancienStatut,
            'nouveau_statut' => $nouveauStatut,
            'commentaire' => $request->input('commentaire'),
        ]);

        Notification::create([
            'user_id' => $signalement->user_id,
            'signalement_id' => $signalement->id,
            'message' => "Votre signalement \"{$signalement->titre}\" est passe au statut : ".Signalement::statutLabel($nouveauStatut).'.',
        ]);

        return new SignalementResource($signalement->load(['user', 'interventions.agent']));
    }

    public function destroy(Request $request, Signalement $signalement)
    {
        $user = $request->user();
        $peutSupprimer = $user->isAgent() || ($signalement->user_id === $user->id && $signalement->statut === 'nouveau');

        if (! $peutSupprimer) {
            abort(403, 'Ce signalement ne peut plus etre supprime.');
        }

        if ($signalement->photo_path) {
            Storage::disk('public')->delete($signalement->photo_path);
        }

        $signalement->delete();

        return response()->json(['message' => 'Signalement supprime.']);
    }
}
