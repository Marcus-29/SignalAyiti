<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SignalementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'categorie' => $this->categorie,
            'titre' => $this->titre,
            'description' => $this->description,
            'quartier' => $this->quartier,
            'photo_url' => $this->photo_path ? Storage::disk('public')->url($this->photo_path) : null,
            'statut' => $this->statut,
            'auteur' => $this->whenLoaded('user', fn () => $this->user->name),
            'user_id' => $this->user_id,
            'interventions' => InterventionResource::collection($this->whenLoaded('interventions')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
