<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Langue extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'code_iso'
    ];

    public function personnelsTemporaires(): BelongsToMany
    {
        return $this->belongsToMany(PersonnelTemporaire::class, 'personnel_langues')
                    ->withPivot('niveau')
                    ->withTimestamps();
    }
}

