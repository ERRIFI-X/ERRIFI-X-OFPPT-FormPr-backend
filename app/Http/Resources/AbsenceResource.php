<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsenceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'participant_id' => $this->participant_id,
            'session_id'     => $this->session_id,
            'date'           => $this->date?->toDateString(),
            'reason'         => $this->reason,
            'participant'    => new ParticipantResource($this->whenLoaded('participant')),
            'session'        => new SessionResource($this->whenLoaded('session')),
        ];
    }
}
