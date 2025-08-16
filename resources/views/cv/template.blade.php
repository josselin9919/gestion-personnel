<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $personnel->prenom }} {{ $personnel->nom }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }

        .cv-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            display: flex;
            min-height: 297mm;
        }

        /* Colonne de gauche */
        .left-column {
            width: 35%;
            background: #2c3e50;
            color: white;
            padding: 30px 25px;
        }

        .profile-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: #34495e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: bold;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .title {
            font-size: 14px;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .contact-info {
            margin-bottom: 30px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 12px;
        }

        .contact-icon {
            width: 16px;
            margin-right: 10px;
            text-align: center;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }

        .skill-item {
            margin-bottom: 8px;
            font-size: 12px;
        }

        .skill-item::before {
            content: "•";
            color: #3498db;
            margin-right: 8px;
        }

        .language-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 12px;
        }

        /* Colonne de droite */
        .right-column {
            width: 65%;
            padding: 30px 25px;
        }

        .header {
            margin-bottom: 30px;
        }

        .main-title {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .subtitle {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-header {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }

        .experience-item, .education-item, .project-item {
            margin-bottom: 20px;
            padding-left: 15px;
            border-left: 3px solid #3498db;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .item-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }

        .item-date {
            font-size: 12px;
            color: #7f8c8d;
            font-weight: bold;
        }

        .item-company {
            font-size: 13px;
            color: #3498db;
            margin-bottom: 8px;
        }

        .item-description {
            font-size: 12px;
            line-height: 1.5;
            color: #555;
        }

        .item-description ul {
            margin-left: 15px;
        }

        .item-description li {
            margin-bottom: 4px;
        }

        .technologies {
            font-size: 11px;
            color: #7f8c8d;
            margin-top: 8px;
            font-style: italic;
        }

        .score-badge {
            background: #3498db;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .cv-container {
                box-shadow: none;
                margin: 0;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <!-- Colonne de gauche -->
        <div class="left-column">
            <!-- Photo et informations de base -->
            <div class="profile-section">
                <div class="profile-photo">
                    @if($photoPath)
                        <img src="{{ $photoPath }}" alt="Photo de {{ $personnel->prenom }} {{ $personnel->nom }}">
                    @else
                        {{ strtoupper(substr($personnel->prenom, 0, 1) . substr($personnel->nom, 0, 1)) }}
                    @endif
                </div>
                <div class="name">{{ $personnel->prenom }} {{ $personnel->nom }}</div>
                <div class="title">{{ $personnel->typePersonnel->nom ?? 'Professionnel' }} - {{ $personnel->domaine_expertise }}</div>
            </div>

            <!-- Informations de contact -->
            <div class="contact-info">
                @if($personnel->email)
                <div class="contact-item">
                    <span class="contact-icon">@</span>
                    <span>{{ $personnel->email }}</span>
                </div>
                @endif

                @if($personnel->telephone)
                <div class="contact-item">
                    <span class="contact-icon">📞</span>
                    <span>{{ $personnel->telephone }}</span>
                </div>
                @endif

                @if($age)
                <div class="contact-item">
                    <span class="contact-icon">🎂</span>
                    <span>{{ $age }} ans</span>
                </div>
                @endif

                @if($personnel->ncin)
                <div class="contact-item">
                    <span class="contact-icon">🆔</span>
                    <span>{{ $personnel->ncin }}</span>
                </div>
                @endif
            </div>

            <!-- Soft Skills -->
            @if(count($softSkills) > 0)
            <div class="section">
                <div class="section-title">Soft Skills</div>
                @foreach($softSkills as $skill)
                <div class="skill-item">{{ $skill }}</div>
                @endforeach
            </div>
            @endif

            <!-- Compétences techniques -->
            @if(count($competencesTechniques) > 0)
            <div class="section">
                <div class="section-title">Technologies</div>
                @foreach($competencesTechniques as $competence)
                <div class="skill-item">{{ $competence }}</div>
                @endforeach
            </div>
            @endif

            <!-- Langues -->
            @if($personnel->langues->count() > 0)
            <div class="section">
                <div class="section-title">Langues</div>
                @foreach($personnel->langues as $langue)
                <div class="language-item">
                    <span>{{ $langue->nom }}</span>
                    <span>{{ $langue->pivot->niveau ?? 'Intermédiaire' }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Colonne de droite -->
        <div class="right-column">
            <!-- En-tête -->
            <div class="header">
                <div class="main-title">{{ $personnel->prenom }} {{ $personnel->nom }}</div>
                <div class="subtitle">{{ $personnel->typePersonnel->nom ?? 'Professionnel' }} en {{ $personnel->domaine_expertise }}</div>
                @if($scoreMoyen > 0)
                <div style="margin-top: 10px;">
                    <span class="score-badge">Score moyen: {{ number_format($scoreMoyen, 1) }}/5</span>
                </div>
                @endif
            </div>

            <!-- Expérience professionnelle -->
            @if($experiences->count() > 0)
            <div class="section">
                <div class="section-header">Expérience</div>
                @foreach($experiences as $experience)
                <div class="experience-item">
                    <div class="item-header">
                        <div class="item-title">{{ $experience->poste_occupe ?? 'Poste' }}</div>
                        <div class="item-date">
                            {{ $experience->date_debut ? $experience->date_debut->format('M Y') : '' }} –
                            {{ $experience->date_fin ? $experience->date_fin->format('M Y') : 'Aujourd\'hui' }}
                        </div>
                    </div>
                    <div class="item-company">{{ $experience->structure_nom }} • {{ $experience->pays }}</div>
                    @if($experience->description)
                    <div class="item-description">
                        {!! nl2br(e($experience->description)) !!}
                    </div>
                    @endif
                    @if($experience->domaine_intervention)
                    <div class="technologies">Domaine: {{ $experience->domaine_intervention }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Projets évalués -->
            @if($personnel->evaluations->count() > 0)
            <div class="section">
                <div class="section-header">Projets Évalués</div>
                @foreach($personnel->evaluations as $evaluation)
                @if($evaluation->projet)
                <div class="project-item">
                    <div class="item-header">
                        <div class="item-title">{{ $evaluation->projet->nom }}</div>
                        <div class="item-date">
                            {{ $evaluation->projet->date_debut ? $evaluation->projet->date_debut->format('M Y') : '' }} –
                            {{ $evaluation->projet->date_fin ? $evaluation->projet->date_fin->format('M Y') : 'n cours' }}
                        </div>
                    </div>
                    <div class="item-company">Note: {{ number_format($evaluation->score_total, 1) }}/5</div>
                    @if($evaluation->projet->description)
                    <div class="item-description">
                        {{ $evaluation->projet->description }}
                    </div>
                    @endif
                </div>
                @endif
                @endforeach
            </div>
            @endif

            <!-- Expériences d'enquêtes -->
            @if($enquetes->count() > 0)
            <div class="section">
                <div class="section-header">Expériences d'enquêtes</div>
                @foreach($enquetes as $enquete)
                <div class="experience-item">
                    <div class="item-header">
                        <div class="item-title">{{ $enquete->intitule }}</div>
                        <div class="item-date">{{ $enquete->annee }}</div>
                    </div>
                    <div class="item-company">{{ $enquete->structure }} • {{ $enquete->fonction }}</div>
                    <div class="item-description">
                        Nombre d'enquêtes réalisées: {{ $enquete->nombre_enquetes }}
                        <br>Type: {{ ucfirst(str_replace('_', ' ', $enquete->type_enquete)) }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Formation -->
            @if($diplomes->count() > 0)
            <div class="section">
                <div class="section-header">Éducation</div>
                @foreach($diplomes as $diplome)
                <div class="education-item">
                    <div class="item-header">
                        <div class="item-title">{{ $diplome->intitule }}</div>
                        <div class="item-date">{{ $diplome->annee }}</div>
                    </div>
                    <div class="item-company">{{ $diplome->etablissement }}</div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</body>
</html>

