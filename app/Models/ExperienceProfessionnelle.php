<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExperienceProfessionnelle extends Model
{
    use HasFactory;

    protected $table = 'experiences_professionnelles'; // Ajout de cette ligne pour spécifier le nom de la table

    protected $fillable = [
        'personnel_temporaire_id',
        'date_debut',
        'date_fin',
        'pays',
        'structure_nom',
        'domaine_intervention',
        'poste_occupe',
        'description'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date'
    ];

    public function personnelTemporaire(): BelongsTo
    {
        return $this->belongsTo(PersonnelTemporaire::class);
    }
}
