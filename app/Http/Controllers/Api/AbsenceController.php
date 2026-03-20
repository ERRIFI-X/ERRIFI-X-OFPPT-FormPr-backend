<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbsenceRequest;
use App\Http\Resources\AbsenceResource;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index(Request $request)
    {
        $query = Absence::with(['participant.user', 'session']);
        
        if ($request->has('session_id')) {
            $query->where('session_id', $request->session_id);
        }
        
        if ($request->has('participant_id')) {
            $query->where('participant_id', $request->participant_id);
        }

        return AbsenceResource::collection($query->latest()->paginate(20));
    }

    public function store(StoreAbsenceRequest $request)
    {
        $absence = Absence::create($request->validated());
        return new AbsenceResource($absence->load(['participant', 'session']));
    }

    public function destroy(Absence $absence)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isCdc() && !auth()->user()->isFormateur()) {
            abort(403, 'Unauthorized action.');
        }

        $absence->delete();
        return response()->noContent();
    }
}
