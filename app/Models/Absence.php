<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'session_id',
        'date',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
