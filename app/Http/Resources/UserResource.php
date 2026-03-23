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
            'formations' => $this->whenLoaded('themes', function () {
                $themes = $this->themes;
                // Group the loaded themes by formation
                $formations = $themes->map->formation->filter()->unique('id')->values();
                $formations->each(function ($formation) use ($themes) {
                    $formation->setRelation('themes', $themes->where('formation_id', $formation->id)->values());
                });
                return FormationResource::collection($formations);
            }),
        ];
    }
}
