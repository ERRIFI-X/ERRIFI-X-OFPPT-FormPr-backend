<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'location'    => $this->location,
            'start_date'  => $this->start_date?->toDateString(),
            'end_date'    => $this->end_date?->toDateString(),
            'themes'      => ThemeResource::collection($this->whenLoaded('themes')),
            'cdc'         => new UserResource($this->whenLoaded('cdc')),
            'formateurs'  => UserResource::collection($this->whenLoaded('formateurs')),
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
