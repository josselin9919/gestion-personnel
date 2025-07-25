<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PersonnelTemporaire extends Model
{
    use HasFactory;

    protected $table = 'personnels_temporaires';

    protected $fillable = [
        'nom',
        'prenom',
        'ncin',
        'telephone',
        'email',
        'telephone',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'situation_matrimoniale',
        'nombre_enfants',
        'adresse',
        'ville',
        'region',
        'pays',
        'niveau_etude',
        'specialite',
        'experience_annees',
        'competences_cles',
        'disponibilite',
        'tarif_journalier',
        'devise',
        'statut',
        'type_personnel_id',
        'structure_id',

        // Champs spécifiques aux rôles
        'type_agent',
        'experience_cerd',
        'specialite_formation',
        'nombre_formations_animees',
        'statut_mission',
        'statut_stage',
        'statut_validation',

        // Champs communs du prompt
        'domaine_expertise',
        'diplome_plus_eleve',
        'domaine_etude',
        'niveau_etudes'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'nombre_enfants' => 'integer',
        'experience_annees' => 'integer',
        'tarif_journalier' => 'decimal:2',
        'nombre_formations_animees' => 'integer'
    ];

    // Relations
    public function typePersonnel(): BelongsTo
    {
        return $this->belongsTo(TypePersonnel::class);
    }

    public function structure(): BelongsTo
    {
        return $this->belongsTo(Structure::class);
    }

    public function diplomes(): HasMany
    {
        return $this->hasMany(Diplome::class);
    }

    public function experiencesProfessionnelles(): HasMany
    {
        return $this->hasMany(ExperienceProfessionnelle::class);
    }

    public function experiencesEnquetes(): HasMany
    {
        return $this->hasMany(ExperienceEnquete::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function langues(): BelongsToMany
    {
        return $this->belongsToMany(Langue::class, 'personnel_langues')
                    ->withPivot('niveau')
                    ->withTimestamps();
    }

    // Relations spécifiques par type d'enquête
    public function enquetesMenage(): HasMany
    {
        return $this->hasMany(ExperienceEnquete::class)->where('type_enquete', 'menage');
    }

    public function enquetesEntreprise(): HasMany
    {
        return $this->hasMany(ExperienceEnquete::class)->where('type_enquete', 'entreprise');
    }

    public function enquetesSocioEconomique(): HasMany
    {
        return $this->hasMany(ExperienceEnquete::class)->where('type_enquete', 'socio_economique');
    }

    // Accessors
    public function getAgeAttribute()
    {
        return $this->date_naissance ? $this->date_naissance->age : null;
    }

    public function getScoreMoyenAttribute()
    {
        return $this->evaluations()->avg('score_total') ?? 0;
    }

    public function getNomCompletAttribute()
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    // Scopes
    public function scopeParType($query, $typeId)
    {
        return $query->where('type_personnel_id', $typeId);
    }

    public function scopeParDomaine($query, $domaine)
    {
        return $query->where('domaine_expertise', 'like', "%{$domaine}%");
    }

    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeParStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    // Méthodes utilitaires
    public function isConsultant()
    {
        return $this->typePersonnel && strtolower($this->typePersonnel->nom) === 'consultant';
    }

    public function isFormateur()
    {
        return $this->typePersonnel && strtolower($this->typePersonnel->nom) === 'formateur';
    }

    public function isAgentCollecte()
    {
        return $this->typePersonnel && in_array(strtolower($this->typePersonnel->nom), ['agent de collecte', 'agent_de_collecte']);
    }

    public function isVolontaire()
    {
        return $this->typePersonnel && strtolower($this->typePersonnel->nom) === 'volontaire';
    }

    public function isStagiaire()
    {
        return $this->typePersonnel && strtolower($this->typePersonnel->nom) === 'stagiaire';
    }

    public function getTotalExperienceEnquetes()
    {
        return $this->experiencesEnquetes()->sum('nombre_enquetes');
    }
}

