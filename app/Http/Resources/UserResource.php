<?php

namespace App\Http\Resources;

use App\Http\Resources\FormationResource;
use App\Http\Resources\ParticipantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role'  => $this->whenLoaded('role', fn () => $this->role->name),
            'assigned_formations' => FormationResource::collection($this->whenLoaded('assignedFormations')),
            'participations' => ParticipantResource::collection($this->whenLoaded('participations')),
        ];
    }
}
