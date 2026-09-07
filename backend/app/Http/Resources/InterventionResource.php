<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterventionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ancien_statut' => $this->ancien_statut,
            'nouveau_statut' => $this->nouveau_statut,
            'commentaire' => $this->commentaire,
            'agent' => $this->whenLoaded('agent', fn () => $this->agent->name),
            'created_at' => $this->created_at,
        ];
    }
}
