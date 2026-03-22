<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Traitement;
use Illuminate\Http\Request;

class TraitementController extends Controller
{
    public function index()
    {
        return response()->json(Traitement::with(['user', 'theme.formation.sessions'])->latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'theme_id' => 'required|exists:themes,id',
            'type' => 'sometimes|string',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'status' => 'sometimes|in:en_attente,valide,annule',
            'date_traitement' => 'required|date',
        ]);

        $traitement = Traitement::create($validated);
        return response()->json($traitement->load(['user', 'theme']), 201);
    }

    public function show(Traitement $traitement)
    {
        return response()->json($traitement->load(['user', 'theme.formation.sessions']));
    }

    public function update(Request $request, Traitement $traitement)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'theme_id' => 'sometimes|exists:themes,id',
            'type' => 'sometimes|string',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'status' => 'sometimes|in:en_attente,valide,annule',
            'date_traitement' => 'sometimes|date',
        ]);

        $traitement->update($validated);
        return response()->json($traitement->load(['user', 'theme']));
    }

    public function destroy(Traitement $traitement)
    {
        $traitement->delete();
        return response()->json(null, 204);
    }
}
