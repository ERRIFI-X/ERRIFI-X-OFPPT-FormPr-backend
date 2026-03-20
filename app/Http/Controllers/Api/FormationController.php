<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormationRequest;
use App\Http\Requests\UpdateFormationRequest;
use App\Http\Resources\FormationResource;
use App\Models\Formation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index(Request $request)
    {
        $query = Formation::with(['themes.participants.user', 'cdc' , 'formateurs', 'sessions', 'documents']);

        // Non-admins only see formations relevant to them
        if (auth()->user()->isCdc()) {
            $query->where('cdc_id', auth()->id());
        } elseif (auth()->user()->isFormateur()) {
            // Include formations where they are the assigned formateur OR where they are a participant in one of the themes
            $query->where(function (Builder $q) {
                $q->whereHas('formateurs', function (Builder $sq) {
                    $sq->where('users.id', auth()->id());
                })->orWhereHas('themes.participants', function (Builder $sq) {
                    $sq->where('user_id', auth()->id());
                });
            });
        }

        return FormationResource::collection($query->latest()->paginate(10));
    }

    public function store(StoreFormationRequest $request)
    {
        $data = $request->validated();
        
        // Auto-assign CDC if not specified and user is CDC
        if (!isset($data['cdc_id']) && auth()->user()->isCdc()) {
            $data['cdc_id'] = auth()->id();
        }

        $formation = Formation::create($data);
        return new FormationResource($formation->load(['themes', 'cdc']));
    }

    public function show(Formation $formation)
    {
        return new FormationResource($formation->load(['themes.inscrits', 'themes.participants.user', 'cdc', 'formateurs', 'sessions', 'documents']));
    }

    public function update(UpdateFormationRequest $request, Formation $formation)
    {
        $this->authorizeAction($formation);
        
        $formation->update($request->validated());
        return new FormationResource($formation->load(['themes', 'cdc']));
    }

    public function destroy(Formation $formation)
    {
        $this->authorizeAction($formation);
        
        $formation->delete();
        return response()->noContent();
    }

    private function authorizeAction(Formation $formation)
    {
        if (!auth()->user()->isAdmin() && !(auth()->user()->isCdc() && $formation->cdc_id === auth()->id())) {
            abort(403, 'Unauthorized action.');
        }
    }
}
