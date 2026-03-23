<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormateurRequest;
use App\Http\Requests\UpdateFormateurRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class FormateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formateurs = User::whereHas('role', function ($query) {
            $query->where('name', 'Formateur');
        })->with(['role', 'themes.formation', 'themes.participants.user'])->get();

        return UserResource::collection($formateurs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormateurRequest $request)
    {
        $data = $request->validated();
        
        $role = \App\Models\Role::where('name', 'Formateur')->firstOrFail();
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'role_id' => $role->id,
        ]);

        return new UserResource($user->load('role'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $formateur)
    {
        if (!$formateur->isFormateur()) {
            abort(404, 'User is not a formateur.');
        }

        return new UserResource($formateur->load(['role', 'themes.formation', 'themes.participants.user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormateurRequest $request, User $formateur)
    {
        $data = $request->validated();
        
        if (isset($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        }

        $formateur->update($data);

        return new UserResource($formateur->load('role'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $formateur)
    {
        $formateur->delete();
        return response()->noContent();
    }
}
