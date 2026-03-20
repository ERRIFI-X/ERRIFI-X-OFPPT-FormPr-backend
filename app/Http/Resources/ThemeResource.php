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
            'formation'   => new FormationResource($this->whenLoaded('formation')),
            'participants' => ParticipantResource::collection($this->whenLoaded('participants')),
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
