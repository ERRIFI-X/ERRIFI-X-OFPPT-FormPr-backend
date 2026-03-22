<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'formation_id' => $this->formation_id,
            'theme_id'     => $this->theme_id,
            'title'        => $this->title,
            'date'         => $this->date?->toDateString(),
            'start_time'   => $this->start_time,
            'end_time'     => $this->end_time,
            'location'     => $this->location,
            'formation'    => new FormationResource($this->whenLoaded('formation')),
            'theme'        => new ThemeResource($this->whenLoaded('theme')),
        ];
    }
}
