<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Projet;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'personnel_temporaire_id',
        'evaluateur_nom',
        'projet_id',
        'commentaire_global',
        'score_total',
        'date_evaluation'
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    protected $casts = [
        'date_evaluation' => 'date',
        'score_total' => 'decimal:2'
    ];

    public function personnelTemporaire(): BelongsTo
    {
        return $this->belongsTo(PersonnelTemporaire::class);
    }

    public function notesCriteres(): HasMany
    {
        return $this->hasMany(NoteCritere::class);
    }

    // Calculer le score total automatiquement
    public function calculerScoreTotal()
    {
        $notes = $this->notesCriteres()->with('critereEvaluation')->get();

        if ($notes->isEmpty()) {
            return 0;
        }

        $scoreTotal = 0;
        $poidsTotal = 0;

        foreach ($notes as $note) {
            $poids = $note->critereEvaluation->poids;
            $scoreTotal += $note->note * $poids;
            $poidsTotal += $poids;
        }

        $this->score_total = $poidsTotal > 0 ? $scoreTotal / $poidsTotal : 0;
        $this->save();

        return $this->score_total;
    }
}
