<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ParticipantResource;
use App\Models\Participant;

class InscritController extends Controller
{
    public function index()
    {
        return ParticipantResource::collection(
            Participant::where('role', 'inscrit')
                ->with(['user', 'theme'])
                ->latest()
                ->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'theme_id' => 'required|exists:themes,id',
            'status' => 'sometimes|in:en_attente,valide,annule',
            'date_inscription' => 'sometimes|date',
        ]);

        $data['role'] = 'inscrit';
        if (!isset($data['status'])) {
            $data['status'] = 'en_attente';
        }

        $inscrit = Participant::create($data);
        return new ParticipantResource($inscrit->load(['user', 'theme']));
    }

    public function show(Participant $inscrit)
    {
        if ($inscrit->role !== 'inscrit') {
            abort(404);
        }
        return new ParticipantResource($inscrit->load(['user', 'theme']));
    }

    public function update(Request $request, Participant $inscrit)
    {
        if ($inscrit->role !== 'inscrit') {
            abort(404);
        }

        $data = $request->validate([
            'status' => 'sometimes|in:en_attente,valide,annule',
            'date_inscription' => 'sometimes|date',
        ]);

        $inscrit->update($data);
        return new ParticipantResource($inscrit->load(['user', 'theme']));
    }

    public function destroy(Participant $inscrit)
    {
        if ($inscrit->role !== 'inscrit') {
            abort(404);
        }
        if (!auth()->user()->isAdmin() && !auth()->user()->isCdc()) {
            abort(403, 'Unauthorized action.');
        }

        $inscrit->delete();
        return response()->noContent();
    }
}
