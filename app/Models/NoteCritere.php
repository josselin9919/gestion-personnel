<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteCritere extends Model
{
    use HasFactory;

    protected $table = 'notes_criteres';

    protected $fillable = [
        'evaluation_id',
        'critere_evaluation_id',
        'note',
    ];

    protected $casts = [
        'note' => 'decimal:2',
    ];

    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function critereEvaluation(): BelongsTo
    {
        return $this->belongsTo(CritereEvaluation::class);
    }
}
