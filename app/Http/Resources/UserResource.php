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
                // Get unique formations
                $formations = $themes->map(fn($t) => $t->formation)->filter()->unique('id')->values();
                
                $formations->each(function ($formation) use ($themes) {
                    $formationThemes = $themes->where('formation_id', $formation->id)->values();
                    
                    // Prevent infinite recursion (Formation -> Theme -> Formation -> Theme...)
                    foreach ($formationThemes as $theme) {
                        $theme->unsetRelation('formation');
                        if ($theme->pivot) {
                            $theme->myRole = $theme->pivot->role;
                            $theme->myStatus = $theme->pivot->status;
                        }
                    }
                    
                    $formation->setRelation('themes', $formationThemes);
                });
                
                return FormationResource::collection($formations);
            }),
        ];
    }
}
