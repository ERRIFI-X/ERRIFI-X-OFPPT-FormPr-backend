<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    protected $table = 'participants';
    
    protected $fillable = [
        'theme_id',
        'user_id',
        'role',
        'status',
        'date_inscription',
    ];

    protected $casts = [
        'date_inscription' => 'datetime',
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
