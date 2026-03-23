<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cdc_id',
        'location',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    public function cdc()
    {
        return $this->belongsTo(User::class, 'cdc_id');
    }

    public function formateurs()
    {
        return $this->belongsToMany(User::class, 'formation_formateur', 'formation_id', 'formateur_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
