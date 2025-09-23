<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_debut',
        'date_fin',
        'nom_projet',
        'nom_client',
        'description',
        'statut',
    ];
     protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function criteresEvaluation()
    {
        return $this->hasMany(CritereEvaluation::class);
    }
}
