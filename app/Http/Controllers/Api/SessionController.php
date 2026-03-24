<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Resources\SessionResource;
use App\Models\Formation;
use App\Models\Session;
use App\Models\Theme;
use App\Notifications\SessionScheduledNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $query = Session::with(['formation', 'theme.participants.user']);
        
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
        
        // Notify all participants of the theme and update status
        $theme = Theme::find($session->theme_id);
        if ($theme) {
            // Update theme status to in progress
            $theme->update(['status' => 'en_cours']);

            // Update formation status
            $formation = $theme->formation;
            if ($formation) {
                // If the formation was pending, mark it as in progress
                if ($formation->status !== 'clôturé') {
                    $formation->update(['status' => 'en_cours']);
                }
            }

            foreach ($theme->realParticipants as $participant) {
                $participant->user->notify(new SessionScheduledNotification($session, $theme));
            }
        }

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
