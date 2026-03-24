<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\FormationResource;
use App\Http\Resources\ParticipantResource;

class ThemeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'duration'    => $this->duration,
            'my_role'     => $this->myRole ?? ($this->pivot?->role),
            'my_status'   => $this->myStatus ?? ($this->pivot?->status),
            'formation'   => new FormationResource($this->whenLoaded('formation')),
            'participants' => ParticipantResource::collection($this->whenLoaded('participants')),
            'sessions'    => SessionResource::collection($this->whenLoaded('sessions')),
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
