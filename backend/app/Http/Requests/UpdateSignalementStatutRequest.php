<?php

namespace App\Http\Requests;

use App\Models\Signalement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSignalementStatutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'statut' => ['required', Rule::in(Signalement::STATUTS)],
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
