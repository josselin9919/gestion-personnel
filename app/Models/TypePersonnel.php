<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypePersonnel extends Model
{
    use HasFactory;

    protected $table = 'types_personnel';

    protected $fillable = [
        'nom',
        'description'
    ];

    public function personnelsTemporaires(): HasMany
    {
        return $this->hasMany(PersonnelTemporaire::class);
    }

    public function criteresEvaluation(): HasMany
    {
        return $this->hasMany(CritereEvaluation::class);
    }
}
