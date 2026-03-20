<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'title',
        'date',
        'start_time',
        'end_time',
        'location',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
