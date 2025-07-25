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
        'type_personnel_id',
        'poids',
        'actif'
    ];

    protected $casts = [
        'poids' => 'decimal:2',
        'actif' => 'boolean'
    ];

    public function typePersonnel(): BelongsTo
    {
        return $this->belongsTo(TypePersonnel::class);
    }

    public function notesCriteres(): HasMany
    {
        return $this->hasMany(NoteCritere::class);
    }
}
