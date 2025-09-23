<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CritereEvaluation extends Model
{
    use HasFactory;

    protected $table = 'criteres_evaluation';

    protected $fillable = [
        'nom',
        'description',
        'projet_id',
        'poids',
        'actif'
    ];

    protected $casts = [
        'poids' => 'decimal:2',
        'actif' => 'boolean'
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function notesCriteres(): HasMany
    {
        return $this->hasMany(NoteCritere::class);
    }
}
