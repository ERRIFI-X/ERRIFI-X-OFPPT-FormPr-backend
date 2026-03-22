<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Resources\ParticipantResource;
use App\Models\Formation;
use App\Models\Participant;
use App\Notifications\ThemeAssignedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $role = $request->input('role', 'participant');
        $query = Participant::where('role', $role)->with(['user', 'theme']);
        
        if ($request->has('theme_id')) {
            $query->where('theme_id', $request->theme_id);
        }

        return ParticipantResource::collection($query->paginate(20));
    }

    public function store(StoreParticipantRequest $request)
    {
        $data = $request->validated();
        $data['role'] = 'participant'; // Force role to participant for this endpoint
        $data['status'] = 'valide';    // Default status for participants
        
        $participant = Participant::create($data);
        
        // Notify the formateur
        $participant->user->notify(new ThemeAssignedNotification($participant->theme, auth()->user()));

        return new ParticipantResource($participant->load(['user', 'theme']));
    }

    public function destroy(Participant $participant)
    {
        // Authorization is handled by policies.
        $this->authorize('delete', $participant);

        $participant->delete();
        return response()->noContent();
    }
}
