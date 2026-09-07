<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'lu' => $this->lu,
            'signalement_id' => $this->signalement_id,
            'created_at' => $this->created_at,
        ];
    }
}
