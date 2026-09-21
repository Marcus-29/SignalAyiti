<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'categorie', 'titre', 'description', 'quartier', 'photo_path', 'statut'])]
class Signalement extends Model
{
    use HasFactory;

    public const CATEGORIES = ['route', 'eau', 'electricite', 'dechets', 'eclairage', 'securite', 'autre'];

    public const STATUTS = ['nouveau', 'en_cours', 'resolu', 'rejete'];

    public const STATUT_LABELS = [
        'nouveau' => 'nouveau',
        'en_cours' => 'en cours',
        'resolu' => 'résolu',
        'rejete' => 'rejeté',
    ];

    public static function statutLabel(string $statut): string
    {
        return self::STATUT_LABELS[$statut] ?? $statut;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class)->latest();
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
