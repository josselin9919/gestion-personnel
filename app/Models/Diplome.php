<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diplome extends Model
{
    use HasFactory;

    protected $fillable = [
        'personnel_temporaire_id',
        'annee',
        'intitule',
        'etablissement'
    ];

    protected $casts = [
        'annee' => 'integer'
    ];

    public function personnelTemporaire(): BelongsTo
    {
        return $this->belongsTo(PersonnelTemporaire::class);
    }
}

