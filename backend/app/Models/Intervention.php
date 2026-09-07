<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['signalement_id', 'agent_id', 'ancien_statut', 'nouveau_statut', 'commentaire'])]
class Intervention extends Model
{
    use HasFactory;

    public function signalement(): BelongsTo
    {
        return $this->belongsTo(Signalement::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
