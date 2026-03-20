<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Resources\SessionResource;
use App\Models\Formation;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $query = Session::with('formation');
        
        if ($request->has('formation_id')) {
            $query->where('formation_id', $request->formation_id);
        }

        return SessionResource::collection($query->latest()->paginate(20));
    }

    public function store(StoreSessionRequest $request)
    {
        $formation = Formation::findOrFail($request->formation_id);
        
        if (!auth()->user()->isAdmin() && !(auth()->user()->isCdc() && $formation->cdc_id === auth()->id())) {
            abort(403, 'Unauthorized action.');
        }

        $session = Session::create($request->validated());
        return new SessionResource($session);
    }

    public function show(Session $session)
    {
        return new SessionResource($session->load('formation'));
    }

    public function destroy(Session $session)
    {
        $formation = $session->formation;
        if (!auth()->user()->isAdmin() && !(auth()->user()->isCdc() && $formation->cdc_id === auth()->id())) {
            abort(403, 'Unauthorized action.');
        }

        $session->delete();
        return response()->noContent();
    }
}
