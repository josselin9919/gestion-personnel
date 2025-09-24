<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Modifier le personnel") }} - {{ $personnel->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('personnel.update', $personnel->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Informations Personnelles (Champs Communs) -->
                        <h3 class="text-lg font-semibold mb-4">Informations Personnelles</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" name="nom" id="nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('nom', $personnel->nom) }}" required>
                                @error('nom')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="sexe" class="block text-sm font-medium text-gray-700">Sexe</label>
                                <select name="sexe" id="sexe" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Sélectionner</option>
                                    <option value="M" {{ old('sexe', $personnel->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('sexe', $personnel->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('sexe')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de Naissance</label>
                                <input type="date" name="date_naissance" id="date_naissance" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('date_naissance', $personnel->date_naissance ? $personnel->date_naissance->format('Y-m-d') : '') }}" required>
                                @error('date_naissance')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="domaine_expertise" class="block text-sm font-medium text-gray-700">Domaine d'expertise</label>
                                <input type="text" name="domaine_expertise" id="domaine_expertise" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('domaine_expertise', $personnel->domaine_expertise) }}" required>
                                @error('domaine_expertise')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Profil Académique (Champs Communs) -->
                        <h3 class="text-lg font-semibold mb-4">Profil Académique</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="diplome_plus_eleve" class="block text-sm font-medium text-gray-700">Diplôme le plus élevé</label>
                                <input type="text" name="diplome_plus_eleve" id="diplome_plus_eleve" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('diplome_plus_eleve', $personnel->diplome_plus_eleve) }}" required>
                                @error('diplome_plus_eleve')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="domaine_etude" class="block text-sm font-medium text-gray-700">Domaine d'étude</label>
                                <input type="text" name="domaine_etude" id="domaine_etude" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('domaine_etude', $personnel->domaine_etude) }}" required>
                                @error('domaine_etude')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="niveau_etudes" class="block text-sm font-medium text-gray-700">Niveau d'études</label>
                                <input type="text" name="niveau_etudes" id="niveau_etudes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('niveau_etudes', $personnel->niveau_etudes) }}">
                                @error('niveau_etudes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Trois derniers diplômes -->
                        <div class="mb-6">
                            <h4 class="text-md font-semibold mb-2">Trois derniers diplômes</h4>
                            <div id="diplomes_container">
                                @if(old('diplomes'))
                                    @foreach(old('diplomes') as $index => $diplome)
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border p-4 rounded-md">
                                            <div>
                                                <label for="diplomes[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                <input type="number" name="diplomes[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $diplome['annee'] ?? '' }}" required>
                                            </div>
                                            <div>
                                                <label for="diplomes[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                <input type="text" name="diplomes[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $diplome['intitule'] ?? '' }}" required>
                                            </div>
                                            <div>
                                                <label for="diplomes[{{ $index }}][etablissement]" class="block text-sm font-medium text-gray-700">Établissement</label>
                                                <input type="text" name="diplomes[{{ $index }}][etablissement]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $diplome['etablissement'] ?? '' }}" required>
                                            </div>
                                            @if(isset($diplome['id']))
                                                <input type="hidden" name="diplomes[{{ $index }}][id]" value="{{ $diplome['id'] }}">
                                            @endif
                                        </div>
                                    @endforeach
                                @elseif($personnel->diplomes->count() > 0)
                                    @foreach($personnel->diplomes as $index => $diplome)
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border p-4 rounded-md">
                                            <div>
                                                <label for="diplomes[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                <input type="number" name="diplomes[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $diplome->annee }}" required>
                                            </div>
                                            <div>
                                                <label for="diplomes[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                <input type="text" name="diplomes[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $diplome->intitule }}" required>
                                            </div>
                                            <div>
                                                <label for="diplomes[{{ $index }}][etablissement]" class="block text-sm font-medium text-gray-700">Établissement</label>
                                                <input type="text" name="diplomes[{{ $index }}][etablissement]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $diplome->etablissement }}" required>
                                            </div>
                                            <input type="hidden" name="diplomes[{{ $index }}][id]" value="{{ $diplome->id }}">
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-600">Aucun diplôme enregistré. Ajoutez au moins un diplôme.</p>
                                @endif
                            </div>
                            <button type="button" id="add_diplome" class="btn btn-success">
                                Ajouter un diplôme
                            </button>
                        </div>

                        <!-- Expériences Professionnelles (Champs Communs) -->
                        <h3 class="text-lg font-semibold mb-4">Expériences Professionnelles</h3>
                        <div class="mb-6">
                            <div id="experiences_container">
                                @if(old('experiences'))
                                    @foreach(old('experiences') as $index => $experience)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                            <div>
                                                <label for="experiences[{{ $index }}][date_debut]" class="block text-sm font-medium text-gray-700">Date Début</label>
                                                <input type="date" name="experiences[{{ $index }}][date_debut]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience['date_debut'] ?? '' }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][date_fin]" class="block text-sm font-medium text-gray-700">Date Fin</label>
                                                <input type="date" name="experiences[{{ $index }}][date_fin]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience['date_fin'] ?? '' }}">
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][pays]" class="block text-sm font-medium text-gray-700">Pays</label>
                                                <input type="text" name="experiences[{{ $index }}][pays]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience['pays'] ?? '' }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][structure_nom]" class="block text-sm font-medium text-gray-700">Nom Structure</label>
                                                <input type="text" name="experiences[{{ $index }}][structure_nom]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience['structure_nom'] ?? '' }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][domaine_intervention]" class="block text-sm font-medium text-gray-700">Domaine d'intervention</label>
                                                <input type="text" name="experiences[{{ $index }}][domaine_intervention]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience['domaine_intervention'] ?? '' }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][poste_occupe]" class="block text-sm font-medium text-gray-700">Poste Occupé</label>
                                                <input type="text" name="experiences[{{ $index }}][poste_occupe]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience['poste_occupe'] ?? '' }}" required>
                                            </div>
                                            <div class="md:col-span-2">
                                                <label for="experiences[{{ $index }}][description]" class="block text-sm font-medium text-gray-700">Description</label>
                                                <textarea name="experiences[{{ $index }}][description]" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $experience['description'] ?? '' }}</textarea>
                                            </div>
                                            @if(isset($experience['id']))
                                                <input type="hidden" name="experiences[{{ $index }}][id]" value="{{ $experience['id'] }}">
                                            @endif
                                        </div>
                                    @endforeach
                                @elseif($personnel->experiencesProfessionnelles->count() > 0)
                                    @foreach($personnel->experiencesProfessionnelles as $index => $experience)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                            <div>
                                                <label for="experiences[{{ $index }}][date_debut]" class="block text-sm font-medium text-gray-700">Date Début</label>
                                                <input type="date" name="experiences[{{ $index }}][date_debut]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience->date_debut ? $experience->date_debut->format('Y-m-d') : '' }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][date_fin]" class="block text-sm font-medium text-gray-700">Date Fin</label>
                                                <input type="date" name="experiences[{{ $index }}][date_fin]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience->date_fin ? $experience->date_fin->format('Y-m-d') : '' }}">
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][pays]" class="block text-sm font-medium text-gray-700">Pays</label>
                                                <input type="text" name="experiences[{{ $index }}][pays]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience->pays }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][structure_nom]" class="block text-sm font-medium text-gray-700">Nom Structure</label>
                                                <input type="text" name="experiences[{{ $index }}][structure_nom]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience->structure_nom }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][domaine_intervention]" class="block text-sm font-medium text-gray-700">Domaine d'intervention</label>
                                                <input type="text" name="experiences[{{ $index }}][domaine_intervention]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience->domaine_intervention }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][poste_occupe]" class="block text-sm font-medium text-gray-700">Poste Occupé</label>
                                                <input type="text" name="experiences[{{ $index }}][poste_occupe]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience->poste_occupe }}" required>
                                            </div>
                                            <div class="md:col-span-2">
                                                <label for="experiences[{{ $index }}][description]" class="block text-sm font-medium text-gray-700">Description</label>
                                                <textarea name="experiences[{{ $index }}][description]" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $experience->description }}</textarea>
                                            </div>
                                            <input type="hidden" name="experiences[{{ $index }}][id]" value="{{ $experience->id }}">
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-600">Aucune expérience professionnelle enregistrée. Ajoutez au moins une expérience.</p>
                                @endif
                            </div>
                            <button type="button" id="add_experience" class="btn btn-success">
                                Ajouter une expérience
                            </button>
                        </div>

                        <!-- Type de Personnel -->
                        <h3 class="text-lg font-semibold mb-4">Type de Personnel</h3>
                        <div class="mb-6">
                            <label for="type_personnel_id" class="block text-sm font-medium text-gray-700">Sélectionner le Type de Personnel</label>
                            <select name="type_personnel_id" id="type_personnel_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required onchange="toggleFields()">
                                <option value="">Sélectionner un type</option>
                                @foreach($typesPersonnel as $type)
                                    <option value="{{ $type->id }}" data-type-name="{{ Str::slug($type->nom, '_') }}" {{ old('type_personnel_id', $personnel->type_personnel_id) == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                                @endforeach
                            </select>
                            @error('type_personnel_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Champs Spécifiques -->
                        <div id="specific_fields_container">
                            <!-- Formateurs -->
                            <div id="formateur_fields" class="hidden">
                                <h3 class="text-lg font-semibold mb-4">Champs Spécifiques Formateur</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="specialite_formation" class="block text-sm font-medium text-gray-700">Spécialité de formation</label>
                                        <input type="text" name="specialite_formation" id="specialite_formation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('specialite_formation', $personnel->specialite_formation) }}">
                                    </div>
                                    <div>
                                        <label for="nombre_formations_animees" class="block text-sm font-medium text-gray-700">Nombre de formations animées</label>
                                        <input type="number" name="nombre_formations_animees" id="nombre_formations_animees" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('nombre_formations_animees', $personnel->nombre_formations_animees) }}" min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Agents de collecte -->
                            <div id="agent_de_collecte_fields" class="hidden">
                                <h3 class="text-lg font-semibold mb-4">Champs Spécifiques Agent de Collecte</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="type_agent_collecte" class="block text-sm font-medium text-gray-700">Type d'agent de collecte</label>
                                        <select name="type_agent_collecte" id="type_agent_collecte" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="">Sélectionner</option>
                                            <option value="superviseur" {{ old('type_agent_collecte', $personnel->type_agent) == 'superviseur' ? 'selected' : '' }}>Superviseur</option>
                                            <option value="controleur" {{ old('type_agent_collecte', $personnel->type_agent) == 'controleur' ? 'selected' : '' }}>Contrôleur</option>
                                            <option value="enqueteur" {{ old('type_agent_collecte', $personnel->type_agent) == 'enqueteur' ? 'selected' : '' }}>Enquêteur</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Langues parlées -->
                                <div class="mb-6">
                                    <h4 class="text-md font-semibold mb-2">Langues parlées</h4>
                                    <div id="langues_parlees_container">
                                        @if(old('langues_parlees'))
                                            @foreach(old('langues_parlees') as $index => $langue)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="langues_parlees[{{ $index }}][langue]" class="block text-sm font-medium text-gray-700">Langue</label>
                                                        <input type="text" name="langues_parlees[{{ $index }}][langue]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $langue['langue'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="langues_parlees[{{ $index }}][niveau]" class="block text-sm font-medium text-gray-700">Niveau</label>
                                                        <input type="text" name="langues_parlees[{{ $index }}][niveau]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $langue['niveau'] ?? '' }}">
                                                    </div>
                                                    @if(isset($langue['id']))
                                                        <input type="hidden" name="langues_parlees[{{ $index }}][id]" value="{{ $langue['id'] }}">
                                                    @endif
                                                </div>
                                            @endforeach
                                        @elseif($personnel->langues->count() > 0)
                                            @foreach($personnel->langues as $index => $langue)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="langues_parlees[{{ $index }}][langue]" class="block text-sm font-medium text-gray-700">Langue</label>
                                                        <input type="text" name="langues_parlees[{{ $index }}][langue]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $langue->nom }}">
                                                    </div>
                                                    <div>
                                                        <label for="langues_parlees[{{ $index }}][niveau]" class="block text-sm font-medium text-gray-700">Niveau</label>
                                                        <input type="text" name="langues_parlees[{{ $index }}][niveau]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $langue->pivot->niveau ?? '' }}">
                                                    </div>
                                                    <input type="hidden" name="langues_parlees[{{ $index }}][id]" value="{{ $langue->id }}">
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-600">Aucune langue enregistrée. Ajoutez au moins une langue.</p>
                                        @endif
                                    </div>
                                    <button type="button" id="add_langue" class="btn btn-success">
                                        Ajouter une langue
                                    </button>
                                </div>

                                <!-- Expérience d'enquêtes -->
                                <div class="mb-6">
                                    <h4 class="text-md font-semibold mb-2">Expérience d'enquêtes (Ménage)</h4>
                                    <div id="enquetes_menage_container">
                                        @php
                                            $enquetesMenage = $personnel->experiencesEnquetes->where('type_enquete', 'menage');
                                        @endphp
                                        @if(old('enquetes_menage'))
                                            @foreach(old('enquetes_menage') as $index => $enquete)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                        <input type="number" name="enquetes_menage[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['annee'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                        <input type="text" name="enquetes_menage[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['intitule'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                                                        <input type="text" name="enquetes_menage[{{ $index }}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['fonction'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                                                        <input type="text" name="enquetes_menage[{{ $index }}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['structure'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d'enquêtes</label>
                                                        <input type="number" name="enquetes_menage[{{ $index }}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['nombre_enquetes'] ?? '' }}">
                                                    </div>
                                                    @if(isset($enquete['id']))
                                                        <input type="hidden" name="enquetes_menage[{{ $index }}][id]" value="{{ $enquete['id'] }}">
                                                    @endif
                                                </div>
                                            @endforeach
                                        @elseif($enquetesMenage->count() > 0)
                                            @foreach($enquetesMenage as $index => $enquete)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                        <input type="number" name="enquetes_menage[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->annee }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                        <input type="text" name="enquetes_menage[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->intitule }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                                                        <input type="text" name="enquetes_menage[{{ $index }}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->fonction }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                                                        <input type="text" name="enquetes_menage[{{ $index }}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->structure }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d'enquêtes</label>
                                                        <input type="number" name="enquetes_menage[{{ $index }}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->nombre_enquetes }}">
                                                    </div>
                                                    <input type="hidden" name="enquetes_menage[{{ $index }}][id]" value="{{ $enquete->id }}">
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-600">Aucune expérience d'enquête Ménage enregistrée.</p>
                                        @endif
                                    </div>
                                    <button type="button" id="add_enquete_menage" class="btn btn-success">
                                        Ajouter une enquête Ménage
                                    </button>
                                </div>

                                <div class="mb-6">
                                    <h4 class="text-md font-semibold mb-2">Expérience d'enquêtes (Entreprise)</h4>
                                    <div id="enquetes_entreprise_container">
                                        @php
                                            $enquetesEntreprise = $personnel->experiencesEnquetes->where('type_enquete', 'entreprise');
                                        @endphp
                                        @if(old('enquetes_entreprise'))
                                            @foreach(old('enquetes_entreprise') as $index => $enquete)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                        <input type="number" name="enquetes_entreprise[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['annee'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                        <input type="text" name="enquetes_entreprise[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['intitule'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                                                        <input type="text" name="enquetes_entreprise[{{ $index }}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['fonction'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                                                        <input type="text" name="enquetes_entreprise[{{ $index }}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['structure'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d'enquêtes</label>
                                                        <input type="number" name="enquetes_entreprise[{{ $index }}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['nombre_enquetes'] ?? '' }}">
                                                    </div>
                                                    @if(isset($enquete['id']))
                                                        <input type="hidden" name="enquetes_entreprise[{{ $index }}][id]" value="{{ $enquete['id'] }}">
                                                    @endif
                                                </div>
                                            @endforeach
                                        @elseif($enquetesEntreprise->count() > 0)
                                            @foreach($enquetesEntreprise as $index => $enquete)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                        <input type="number" name="enquetes_entreprise[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->annee }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                        <input type="text" name="enquetes_entreprise[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->intitule }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                                                        <input type="text" name="enquetes_entreprise[{{ $index }}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->fonction }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                                                        <input type="text" name="enquetes_entreprise[{{ $index }}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->structure }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d'enquêtes</label>
                                                        <input type="number" name="enquetes_entreprise[{{ $index }}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->nombre_enquetes }}">
                                                    </div>
                                                    <input type="hidden" name="enquetes_entreprise[{{ $index }}][id]" value="{{ $enquete->id }}">
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-600">Aucune expérience d'enquête Entreprise enregistrée.</p>
                                        @endif
                                    </div>
                                    <button type="button" id="add_enquete_entreprise" class="btn btn-success">
                                        Ajouter une enquête Entreprise
                                    </button>
                                </div>

                                <div class="mb-6">
                                    <h4 class="text-md font-semibold mb-2">Expérience d'enquêtes (Socio-économique)</h4>
                                    <div id="enquetes_socio_economique_container">
                                        @php
                                            $enquetesSocioEconomique = $personnel->experiencesEnquetes->where('type_enquete', 'socio_economique');
                                        @endphp
                                        @if(old('enquetes_socio_economique'))
                                            @foreach(old('enquetes_socio_economique') as $index => $enquete)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                        <input type="number" name="enquetes_socio_economique[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['annee'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                        <input type="text" name="enquetes_socio_economique[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['intitule'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                                                        <input type="text" name="enquetes_socio_economique[{{ $index }}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['fonction'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                                                        <input type="text" name="enquetes_socio_economique[{{ $index }}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['structure'] ?? '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d'enquêtes</label>
                                                        <input type="number" name="enquetes_socio_economique[{{ $index }}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete['nombre_enquetes'] ?? '' }}">
                                                    </div>
                                                    @if(isset($enquete['id']))
                                                        <input type="hidden" name="enquetes_socio_economique[{{ $index }}][id]" value="{{ $enquete['id'] }}">
                                                    @endif
                                                </div>
                                            @endforeach
                                        @elseif($enquetesSocioEconomique->count() > 0)
                                            @foreach($enquetesSocioEconomique as $index => $enquete)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                        <input type="number" name="enquetes_socio_economique[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->annee }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                        <input type="text" name="enquetes_socio_economique[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->intitule }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                                                        <input type="text" name="enquetes_socio_economique[{{ $index }}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->fonction }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                                                        <input type="text" name="enquetes_socio_economique[{{ $index }}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->structure }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d'enquêtes</label>
                                                        <input type="number" name="enquetes_socio_economique[{{ $index }}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete->nombre_enquetes }}">
                                                    </div>
                                                    <input type="hidden" name="enquetes_socio_economique[{{ $index }}][id]" value="{{ $enquete->id }}">
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-600">Aucune expérience d'enquête Socio-économique enregistrée.</p>
                                        @endif
                                    </div>
                                    <button type="button" id="add_enquete_socio_economique" class="btn btn-success">
                                        Ajouter une enquête Socio-économique
                                    </button>
                                </div>

                                <div class="mb-6">
                                    <label for="experience_cerd" class="block text-sm font-medium text-gray-700">Expérience avec le CERD</label>
                                    <textarea name="experience_cerd" id="experience_cerd" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('experience_cerd', $personnel->experience_cerd) }}</textarea>
                                </div>
                            </div>

                            <!-- Volontaires -->
                            <div id="volontaire_fields" class="hidden">
                                <h3 class="text-lg font-semibold mb-4">Champs Spécifiques Volontaire</h3>
                                <div class="mb-6">
                                    <label for="statut_mission_volontaire" class="block text-sm font-medium text-gray-700">Statut de mission</label>
                                    <select name="statut_mission_volontaire" id="statut_mission_volontaire" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Sélectionner</option>
                                        <option value="achevee" {{ old('statut_mission_volontaire', $personnel->statut_mission) == 'achevee' ? 'selected' : '' }}>Achevée</option>
                                        <option value="en_cours" {{ old('statut_mission_volontaire', $personnel->statut_mission) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="en_attente" {{ old('statut_mission_volontaire', $personnel->statut_mission) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Stagiaires -->
                            <div id="stagiaire_fields" class="hidden">
                                <h3 class="text-lg font-semibold mb-4">Champs Spécifiques Stagiaire</h3>
                                <div class="mb-6">
                                    <label for="statut_stagiaire" class="block text-sm font-medium text-gray-700">Statut</label>
                                    <select name="statut_stagiaire" id="statut_stagiaire" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Sélectionner</option>
                                        <option value="en_attente" {{ old('statut_stagiaire', $personnel->statut_stage) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="en_cours" {{ old('statut_stagiaire', $personnel->statut_stage) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="validee" {{ old('statut_stagiaire', $personnel->statut_stage) == 'validee' ? 'selected' : '' }}>Validée</option>
                                        <option value="achevee" {{ old('statut_stagiaire', $personnel->statut_stage) == 'achevee' ? 'selected' : '' }}>Achevée</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a href="{{ route('personnel.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Annuler
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Mettre à jour Personnel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFields() {
            const typePersonnelSelect = document.getElementById('type_personnel_id');
            const selectedOption = typePersonnelSelect.options[typePersonnelSelect.selectedIndex];
            const typeName = selectedOption ? selectedOption.dataset.typeName : null;

            // Hide all specific field containers first
            document.getElementById('formateur_fields').style.display = 'none';
            document.getElementById('agent_de_collecte_fields').style.display = 'none';
            document.getElementById('volontaire_fields').style.display = 'none';
            document.getElementById('stagiaire_fields').style.display = 'none';

            // Reset required attributes for all specific fields
            const specificFieldInputs = document.querySelectorAll('#specific_fields_container input, #specific_fields_container select, #specific_fields_container textarea');
            specificFieldInputs.forEach(input => input.removeAttribute('required'));

            // Show fields based on type and set required attributes if necessary
            switch (typeName) {
                case 'formateur':
                    document.getElementById('formateur_fields').style.display = 'block';
                    break;
                case 'agent_de_collecte': // Note: slugified name
                    document.getElementById('agent_de_collecte_fields').style.display = 'block';
                    break;
                case 'volontaire':
                    document.getElementById('volontaire_fields').style.display = 'block';
                    break;
                case 'stagiaire':
                    document.getElementById('stagiaire_fields').style.display = 'block';
                    break;
                default:
                    // Consultants and others have no specific fields to show/hide
                    break;
            }
        }

        // Call toggleFields on page load to set initial state
        document.addEventListener('DOMContentLoaded', function() {
            toggleFields();

            // Dynamic fields for Diplômes
            document.getElementById('add_diplome').addEventListener('click', function() {
                const container = document.getElementById('diplomes_container');
                const index = container.children.length;
                const newDiplomeHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border p-4 rounded-md">
                        <div >
                        <button type="button"
                            class="delete-field bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-md transition duration-200"
                            title="Supprimer ce diplôme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                        <div>
                            <label for="diplomes[${index}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                            <input type="number" name="diplomes[${index}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="diplomes[${index}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                            <input type="text" name="diplomes[${index}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="diplomes[${index}][etablissement]" class="block text-sm font-medium text-gray-700">Établissement</label>
                            <input type="text" name="diplomes[${index}][etablissement]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newDiplomeHtml);
                setupDeleteHandlers(); // Appeler après l'ajout
            });

            // Dynamic fields for Expériences Professionnelles
            document.getElementById('add_experience').addEventListener('click', function() {
                const container = document.getElementById('experiences_container');
                const index = container.children.length;
                const newExperienceHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                        <div >
                        <button type="button"
                            class="delete-field bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-md transition duration-200"
                            title="Supprimer ce diplôme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                        <div>
                            <label for="experiences[${index}][date_debut]" class="block text-sm font-medium text-gray-700">Date Début</label>
                            <input type="date" name="experiences[${index}][date_debut]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="experiences[${index}][date_fin]" class="block text-sm font-medium text-gray-700">Date Fin</label>
                            <input type="date" name="experiences[${index}][date_fin]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="experiences[${index}][pays]" class="block text-sm font-medium text-gray-700">Pays</label>
                            <input type="text" name="experiences[${index}][pays]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="experiences[${index}][structure_nom]" class="block text-sm font-medium text-gray-700">Nom Structure</label>
                            <input type="text" name="experiences[${index}][structure_nom]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="experiences[${index}][domaine_intervention]" class="block text-sm font-medium text-gray-700">Domaine d'intervention</label>
                            <input type="text" name="experiences[${index}][domaine_intervention]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="experiences[${index}][poste_occupe]" class="block text-sm font-medium text-gray-700">Poste Occupé</label>
                            <input type="text" name="experiences[${index}][poste_occupe]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="experiences[${index}][description]" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="experiences[${index}][description]" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newExperienceHtml);
                setupDeleteHandlers(); // Appeler après l'ajout
            });

            // Dynamic fields for Langues parlées (Agents de collecte)
            document.getElementById('add_langue').addEventListener('click', function() {
                const container = document.getElementById('langues_parlees_container');
                const index = container.children.length;
                const newLangueHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                        <div >
                        <button type="button"
                            class="delete-field bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-md transition duration-200"
                            title="Supprimer ce diplôme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                        <div>
                            <label for="langues_parlees[${index}][langue]" class="block text-sm font-medium text-gray-700">Langue</label>
                            <input type="text" name="langues_parlees[${index}][langue]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="langues_parlees[${index}][niveau]" class="block text-sm font-medium text-gray-700">Niveau</label>
                            <input type="text" name="langues_parlees[${index}][niveau]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newLangueHtml);
                setupDeleteHandlers(); // Appeler après l'ajout
            });

            // Dynamic fields for Expérience d'enquêtes (Ménage)
            document.getElementById('add_enquete_menage').addEventListener('click', function() {
                const container = document.getElementById('enquetes_menage_container');
                const index = container.children.length;
                const newEnqueteMenageHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                        <div >
                        <button type="button"
                            class="delete-field bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-md transition duration-200"
                            title="Supprimer ce diplôme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                        <div>
                            <label for="enquetes_menage[${index}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                            <input type="number" name="enquetes_menage[${index}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_menage[${index}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                            <input type="text" name="enquetes_menage[${index}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_menage[${index}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                            <input type="text" name="enquetes_menage[${index}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_menage[${index}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                            <input type="text" name="enquetes_menage[${index}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_menage[${index}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d'enquêtes</label>
                            <input type="number" name="enquetes_menage[${index}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newEnqueteMenageHtml);
                setupDeleteHandlers(); // Appeler après l'ajout
            });

            // Dynamic fields for Expérience d'enquêtes (Entreprise)
            document.getElementById('add_enquete_entreprise').addEventListener('click', function() {
                const container = document.getElementById('enquetes_entreprise_container');
                const index = container.children.length;
                const newEnqueteEntrepriseHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                        <div >
                        <button type="button"
                            class="delete-field bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-md transition duration-200"
                            title="Supprimer ce diplôme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                        <div>
                            <label for="enquetes_entreprise[${index}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                            <input type="number" name="enquetes_entreprise[${index}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_entreprise[${index}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                            <input type="text" name="enquetes_entreprise[${index}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_entreprise[${index}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                            <input type="text" name="enquetes_entreprise[${index}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_entreprise[${index}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                            <input type="text" name="enquetes_entreprise[${index}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_entreprise[${index}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d'enquêtes</label>
                            <input type="number" name="enquetes_entreprise[${index}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newEnqueteEntrepriseHtml);
                setupDeleteHandlers(); // Appeler après l'ajout
            });

            // Dynamic fields for Expérience d'enquêtes (Socio-économique)
            document.getElementById('add_enquete_socio_economique').addEventListener('click', function() {
                const container = document.getElementById('enquetes_socio_economique_container');
                const index = container.children.length;
                const newEnqueteSocioEconomiqueHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                        <div >
                        <button type="button"
                            class="delete-field bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-md transition duration-200"
                            title="Supprimer ce diplôme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                        <div>
                            <label for="enquetes_socio_economique[${index}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                            <input type="number" name="enquetes_socio_economique[${index}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_socio_economique[${index}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                            <input type="text" name="enquetes_socio_economique[${index}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_socio_economique[${index}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                            <input type="text" name="enquetes_socio_economique[${index}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_socio_economique[${index}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                            <input type="text" name="enquetes_socio_economique[${index}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="enquetes_socio_economique[${index}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d'enquêtes</label>
                            <input type="number" name="enquetes_socio_economique[${index}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newEnqueteSocioEconomiqueHtml);
                setupDeleteHandlers(); // Appeler après l'ajout
            });
        });
    </script>
</x-app-layout>
