<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExperienceEnquete extends Model
{
    use HasFactory;
    protected $table = 'experiences_enquetes';
    protected $fillable = [
        'personnel_temporaire_id',
        'type_enquete',
        'annee',
        'intitule',
        'fonction',
        'structure',
        'nombre_enquetes'
    ];

    protected $casts = [
        'annee' => 'integer',
        'nombre_enquetes' => 'integer'
    ];

    public function personnelTemporaire(): BelongsTo
    {
        return $this->belongsTo(PersonnelTemporaire::class);
    }

    // Scopes pour filtrer par type d'enquête
    public function scopeMenage($query)
    {
        return $query->where('type_enquete', 'menage');
    }

    public function scopeEntreprise($query)
    {
        return $query->where('type_enquete', 'entreprise');
    }

    public function scopeSocioEconomique($query)
    {
        return $query->where('type_enquete', 'socio_economique');
    }
}

