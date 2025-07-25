<x-app-layout>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Dossier de {{ $personnel->nom }}</h1>
        <p class="text-muted">Tous les détails du personnel temporaire</p>
    </div>

    <!-- Info principale -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Informations Générales
        </div>
        <div class="card-body">
            <p><strong>NCIN :</strong> {{ $personnel->ncin }}</p>
            <p><strong>Email :</strong> {{ $personnel->email }}</p>
            <p><strong>Sexe :</strong> {{ $personnel->sexe }}</p>
            <p><strong>Téléphone :</strong> {{ $personnel->telephone }}</p>
            <p><strong>Date de naissance :</strong> {{ $personnel->date_naissance }}</p>
            <p><strong>Domaine d'expertise :</strong> {{ $personnel->domaine_expertise }}</p>
            <p><strong>Domaine d'étude :</strong> {{ $personnel->domaine_etude }}</p>
            <p><strong>Diplôme le plus élevé :</strong> {{ $personnel->diplome_plus_eleve }}</p>
            <p><strong>Type :</strong> {{ $personnel->typePersonnel->nom ?? 'N/A' }}</p>
            <p><strong>Structure :</strong> {{ $personnel->structure->nom ?? 'N/A' }}</p>

            @if($personnel->type_agent)
                <p><strong>Type agent :</strong> {{ $personnel->type_agent }}</p>
            @endif
            @if($personnel->niveau_etudes)
                <p><strong>Niveau d'études :</strong> {{ $personnel->niveau_etudes }}</p>
            @endif
            @if($personnel->experience_cerd)
                <p><strong>Expérience CERD :</strong> {{ $personnel->experience_cerd }}</p>
            @endif
            @if($personnel->specialite_formation)
                <p><strong>Spécialité formation :</strong> {{ $personnel->specialite_formation }}</p>
            @endif
            @if($personnel->nombre_formations_animees)
                <p><strong>Formations animées :</strong> {{ $personnel->nombre_formations_animees }}</p>
            @endif
            @if($personnel->statut_mission)
                <p><strong>Statut mission volontaire :</strong> {{ $personnel->statut_mission }}</p>
            @endif
            @if($personnel->statut_stage)
                <p><strong>Statut stage :</strong> {{ $personnel->statut_stage }}</p>
            @endif
        </div>
    </div>

    <!-- Accordéon pour détails -->
    <div class="accordion" id="personnelDetails">

        <!-- Langues -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingLangues">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLangues">
                    Langues Parlées
                </button>
            </h2>
            <div id="collapseLangues" class="accordion-collapse collapse show" data-bs-parent="#personnelDetails">
                <div class="accordion-body">
                    <ul class="list-group">
                        @forelse($personnel->langues as $langue)
                            <li class="list-group-item">{{ $langue->nom }} — <strong>Niveau :</strong> {{ $langue->pivot->niveau }}</li>
                        @empty
                            <li class="list-group-item text-muted">Aucune langue renseignée</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Diplômes -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingDiplomes">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDiplomes">
                    Diplômes
                </button>
            </h2>
            <div id="collapseDiplomes" class="accordion-collapse collapse" data-bs-parent="#personnelDetails">
                <div class="accordion-body">
                    <ul class="list-group">
                        @forelse($personnel->diplomes as $diplome)
                            <li class="list-group-item">{{ $diplome->annee }} — {{ $diplome->intitule }} à {{ $diplome->etablissement }}</li>
                        @empty
                            <li class="list-group-item text-muted">Aucun diplôme renseigné</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Expériences Pro -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingExpPro">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExpPro">
                    Expériences Professionnelles
                </button>
            </h2>
            <div id="collapseExpPro" class="accordion-collapse collapse" data-bs-parent="#personnelDetails">
                <div class="accordion-body">
                    <ul class="list-group">
                        @forelse($personnel->experiencesProfessionnelles as $exp)
                            <li class="list-group-item">
                                <strong>{{ $exp->poste_occupe }}</strong> à {{ $exp->structure_nom }} ({{ $exp->pays }})<br>
                                {{ $exp->date_debut }} - {{ $exp->date_fin ?? 'En cours' }}<br>
                                <em>{{ $exp->domaine_intervention }}</em><br>
                                <small>{{ $exp->description }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aucune expérience professionnelle</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Enquêtes -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingEnquetes">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnquetes">
                    Expériences en Enquêtes
                </button>
            </h2>
            <div id="collapseEnquetes" class="accordion-collapse collapse" data-bs-parent="#personnelDetails">
                <div class="accordion-body">
                    <ul class="list-group">
                        @forelse($personnel->experiencesEnquetes as $enq)
                            <li class="list-group-item">
                                <strong>{{ ucfirst($enq->type_enquete) }}</strong> — {{ $enq->annee }}<br>
                                {{ $enq->intitule }} ({{ $enq->structure }})<br>
                                Fonction : {{ $enq->fonction }} — {{ $enq->nombre_enquetes }} enquêtes
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aucune enquête renseignée</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('personnel.index') }}" class="btn btn-outline-secondary">⬅ Retour à la liste</a>
    </div>
</div>


</x-app-layout>
