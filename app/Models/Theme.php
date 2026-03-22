<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'duration', 'formation_id'];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function inscrits()
    {
        return $this->hasMany(Participant::class)->where('role', 'inscrit');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function realParticipants()
    {
        return $this->hasMany(Participant::class)->where('role', 'participant');
    }
}
