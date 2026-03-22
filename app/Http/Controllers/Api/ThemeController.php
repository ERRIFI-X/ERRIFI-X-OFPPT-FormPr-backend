<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Http\Resources\ThemeResource;
use App\Models\Theme;
use App\Notifications\ThemeUpdatedNotification;

class ThemeController extends Controller
{
    public function index()
    {
        return ThemeResource::collection(Theme::with(['participants.user', 'formation'])->latest()->paginate(10));
    }

    public function store(StoreThemeRequest $request)
    {
        $theme = Theme::create($request->validated());
        return new ThemeResource($theme);
    }

    public function show(Theme $theme)
    {
        return new ThemeResource($theme->load(['participants.user', 'formation']));
    }

    public function update(UpdateThemeRequest $request, Theme $theme)
    {
        $theme->update($request->validated());

        // Notify all formateurs (realParticipants)
        foreach ($theme->realParticipants as $participant) {
            $participant->user->notify(new ThemeUpdatedNotification($theme));
        }

        return new ThemeResource($theme);
    }

    public function destroy(Theme $theme)
    {
        // Authorization check logic would typically be in a policy, but for simplicity here we can hardcode for admin/cdc
        if (!auth()->user()->isAdmin() && !auth()->user()->isCdc()) {
            abort(403, 'Unauthorized action.');
        }

        $theme->delete();
        return response()->noContent();
    }
}
