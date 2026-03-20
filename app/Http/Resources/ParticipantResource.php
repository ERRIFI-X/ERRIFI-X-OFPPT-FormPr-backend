<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'theme_id' => $this->theme_id,
            'user_id'  => $this->user_id,
            'role'     => $this->role,
            'status'   => $this->status,
            'date_inscription' => $this->date_inscription?->toDateTimeString(),
            'user'     => new UserResource($this->whenLoaded('user')),
            'theme'    => new ThemeResource($this->whenLoaded('theme')),
        ];
    }
}
