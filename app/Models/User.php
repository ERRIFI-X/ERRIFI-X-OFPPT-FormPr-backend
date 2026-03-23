<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // As CDC: formations they manage
    public function formations()
    {
        return $this->hasMany(Formation::class, 'cdc_id');
    }

    // As Formateur: formations assigned to them
    public function assignedFormations()
    {
        return $this->belongsToMany(Formation::class, 'formation_formateur', 'formateur_id', 'formation_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    // As Participant: themes they participate in via participations relation
    public function participations()
    {
        return $this->hasMany(Participant::class)->where('role', 'participant');
    }

    // Themes they participate in directly
    public function themes()
    {
        return $this->belongsToMany(Theme::class, 'participants', 'user_id', 'theme_id')
                    ->wherePivot('role', 'participant')
                    ->withPivot(['id', 'role', 'status', 'date_inscription']);
    }

    public function inscriptions()
    {
        return $this->hasMany(Participant::class)->where('role', 'inscrit');
    }

    // Documents uploaded by this user
    public function documents()
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role?->name === 'Admin';
    }

    public function isCdc(): bool
    {
        return $this->role?->name === 'CDC';
    }

    public function isFormateur(): bool
    {
        return $this->role?->name === 'Formateur';
    }
}
