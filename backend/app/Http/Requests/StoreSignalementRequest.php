<?php

namespace App\Http\Requests;

use App\Models\Signalement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSignalementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categorie' => ['required', Rule::in(Signalement::CATEGORIES)],
            'titre' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:2000'],
            'quartier' => ['required', 'string', 'max:150'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
