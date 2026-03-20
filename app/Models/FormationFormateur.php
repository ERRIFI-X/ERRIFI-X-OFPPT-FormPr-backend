<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationFormateur extends Model
{
    use HasFactory;

    protected $table = 'formation_formateur';

    protected $fillable = [
        'formation_id',
        'formateur_id',
        'status',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }
}
