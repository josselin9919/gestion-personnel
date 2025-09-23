<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Ajouter un nouveau personnel") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route("personnel.store") }}">
                        @csrf

                        <!-- Informations Personnelles (Champs Communs) -->
                        <h3 class="text-lg font-semibold mb-4">Informations Personnelles</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" name="nom" id="nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old("nom") }}" required>
                                @error("nom")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="ncin" class="block text-sm font-medium text-gray-700">Numéro de CNI</label>
                                <input type="text" name="ncin" id="ncin" class="mt-1 block w-full" value="{{ old('ncin', $personnel->ncin ?? '') }}">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full" value="{{ old('email', $personnel->email ?? '') }}">
                            </div>
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input type="text" name="telephone" id="telephone" class="mt-1 block w-full" value="{{ old('telephone', $personnel->telephone ?? '') }}">
                            </div>
                            <div>
                                <label for="sexe" class="block text-sm font-medium text-gray-700">Sexe</label>
                                <select name="sexe" id="sexe" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Sélectionner</option>
                                    <option value="M" {{ old("sexe") == "M" ? "selected" : "" }}>Masculin</option>
                                    <option value="F" {{ old("sexe") == "F" ? "selected" : "" }}>Féminin</option>

                                </select>
                                @error("sexe")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de Naissance</label>
                                <input type="date" name="date_naissance" id="date_naissance" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old("date_naissance") }}" required>
                                @error("date_naissance")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="domaine_expertise" class="block text-sm font-medium text-gray-700">Domaine d'expertise</label>
                                <input type="text" name="domaine_expertise" id="domaine_expertise" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old("domaine_expertise") }}" required>
                                @error("domaine_expertise")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Profil Académique (Champs Communs) -->
                        <h3 class="text-lg font-semibold mb-4">Profil Académique</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="diplome_plus_eleve" class="block text-sm font-medium text-gray-700">Diplôme le plus élevé</label>
                                <input type="text" name="diplome_plus_eleve" id="diplome_plus_eleve" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old("diplome_plus_eleve") }}" required>
                                @error("diplome_plus_eleve")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="domaine_etude" class="block text-sm font-medium text-gray-700">Domaine d'étude</label>
                                <input type="text" name="domaine_etude" id="domaine_etude" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old("domaine_etude") }}" required>
                                @error("domaine_etude")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- Trois derniers diplômes -->
                        <div class="mb-6">
                            <h4 class="text-md font-semibold mb-2">Trois derniers diplômes</h4>
                            <div id="diplomes_container">
                                @if(old("diplomes"))
                                    @foreach(old("diplomes") as $index => $diplome)
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border p-4 rounded-md">
                                            <div>
                                                <label for="diplomes[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                <input type="number" name="diplomes[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $diplome["annee"] ?? "" }}" required>
                                            </div>
                                            <div>
                                                <label for="diplomes[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                <input type="text" name="diplomes[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $diplome["intitule"] ?? "" }}" required>
                                            </div>
                                            <div>
                                                <label for="diplomes[{{ $index }}][etablissement]" class="block text-sm font-medium text-gray-700">Établissement</label>
                                                <input type="text" name="diplomes[{{ $index }}][etablissement]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $diplome["etablissement"] ?? "" }}" required>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-600">Ajoutez au moins un diplôme.</p>
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
                                @if(old("experiences"))
                                    @foreach(old("experiences") as $index => $experience)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                            <div>
                                                <label for="experiences[{{ $index }}][date_debut]" class="block text-sm font-medium text-gray-700">Date Début</label>
                                                <input type="date" name="experiences[{{ $index }}][date_debut]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience["date_debut"] ?? "" }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][date_fin]" class="block text-sm font-medium text-gray-700">Date Fin</label>
                                                <input type="date" name="experiences[{{ $index }}][date_fin]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience["date_fin"] ?? "" }}">
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][pays]" class="block text-sm font-medium text-gray-700">Pays</label>
                                                <input type="text" name="experiences[{{ $index }}][pays]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience["pays"] ?? "" }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][structure_nom]" class="block text-sm font-medium text-gray-700">Nom Structure</label>
                                                <input type="text" name="experiences[{{ $index }}][structure_nom]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience["structure_nom"] ?? "" }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][domaine_intervention]" class="block text-sm font-medium text-gray-700">Domaine d\\'intervention</label>
                                                <input type="text" name="experiences[{{ $index }}][domaine_intervention]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience["domaine_intervention"] ?? "" }}" required>
                                            </div>
                                            <div>
                                                <label for="experiences[{{ $index }}][poste_occupe]" class="block text-sm font-medium text-gray-700">Poste Occupé</label>
                                                <input type="text" name="experiences[{{ $index }}][poste_occupe]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $experience["poste_occupe"] ?? "" }}" required>
                                            </div>
                                            <div class="md:col-span-2">
                                                <label for="experiences[{{ $index }}][description]" class="block text-sm font-medium text-gray-700">Description</label>
                                                <textarea name="experiences[{{ $index }}][description]" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $experience["description"] ?? "" }}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-600">Ajoutez au moins une expérience professionnelle.</p>
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
                                    <option value="{{ $type->id }}" data-type-name="{{ Str::slug($type->nom, '_') }}" {{ old("type_personnel_id") == $type->id ? "selected" : "" }}>{{ $type->nom }}</option>
                                @endforeach
                            </select>
                            @error("type_personnel_id")
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
                                        <input type="text" name="specialite_formation" id="specialite_formation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old("specialite_formation") }}">
                                    </div>
                                    <div>
                                        <label for="nombre_formations_animees" class="block text-sm font-medium text-gray-700">Nombre de formations animées</label>
                                        <input type="number" name="nombre_formations_animees" id="nombre_formations_animees" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old("nombre_formations_animees") }}" min="0">
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
                                            <option value="superviseur" {{ old("type_agent_collecte") == "superviseur" ? "selected" : "" }}>Superviseur</option>
                                            <option value="controleur" {{ old("type_agent_collecte") == "controleur" ? "selected" : "" }}>Contrôleur</option>
                                            <option value="enqueteur" {{ old("type_agent_collecte") == "enqueteur" ? "selected" : "" }}>Enquêteur</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="niveau_etudes" class="block text-sm font-medium text-gray-700">Niveau d'études</label>
                                        <input type="text" name="niveau_etudes" id="niveau_etudes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old("niveau_etudes") }}">
                                    </div>
                                </div>
                                <!-- Langues parlées -->
                                <div class="mb-6">
                                    <h4 class="text-md font-semibold mb-2">Langues parlées</h4>
                                    <div id="langues_parlees_container">
                                        @if(old("langues_parlees"))
                                            @foreach(old("langues_parlees") as $index => $langue)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="langues_parlees[{{ $index }}][langue]" class="block text-sm font-medium text-gray-700">Langue</label>
                                                        <input type="text" name="langues_parlees[{{ $index }}][langue]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $langue["langue"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="langues_parlees[{{ $index }}][niveau]" class="block text-sm font-medium text-gray-700">Niveau</label>
                                                        <input type="text" name="langues_parlees[{{ $index }}][niveau]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $langue["niveau"] ?? "" }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-600">Ajoutez au moins une langue.</p>
                                        @endif
                                    </div>
                                    <button type="button" id="add_langue" class="btn btn-success">
                                        Ajouter une langue
                                    </button>
                                </div>
                                <!-- Expérience d\\'enquêtes -->
                                <div class="mb-6">
                                    <h4 class="text-md font-semibold mb-2">Expérience d'enquêtes (Ménage)</h4>
                                    <div id="enquetes_menage_container">
                                        @if(old("enquetes_menage"))
                                            @foreach(old("enquetes_menage") as $index => $enquete)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                        <input type="number" name="enquetes_menage[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["annee"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                        <input type="text" name="enquetes_menage[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["intitule"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                                                        <input type="text" name="enquetes_menage[{{ $index }}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["fonction"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                                                        <input type="text" name="enquetes_menage[{{ $index }}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["structure"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_menage[{{ $index }}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d\\'enquêtes</label>
                                                        <input type="number" name="enquetes_menage[{{ $index }}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["nombre_enquetes"] ?? "" }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-600">Ajoutez au moins une expérience d'enquête Ménage.</p>
                                        @endif
                                    </div>
                                    <button type="button" id="add_enquete_menage" class="btn btn-success">
                                        Ajouter une enquête Ménage
                                    </button>
                                </div>

                                <div class="mb-6">
                                    <h4 class="text-md font-semibold mb-2">Expérience d'enquêtes (Entreprise)</h4>
                                    <div id="enquetes_entreprise_container">
                                        @if(old("enquetes_entreprise"))
                                            @foreach(old("enquetes_entreprise") as $index => $enquete)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                        <input type="number" name="enquetes_entreprise[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["annee"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                        <input type="text" name="enquetes_entreprise[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["intitule"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                                                        <input type="text" name="enquetes_entreprise[{{ $index }}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["fonction"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                                                        <input type="text" name="enquetes_entreprise[{{ $index }}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["structure"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_entreprise[{{ $index }}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d\\'enquêtes</label>
                                                        <input type="number" name="enquetes_entreprise[{{ $index }}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["nombre_enquetes"] ?? "" }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-600">Ajoutez au moins une expérience d\\'enquête Entreprise.</p>
                                        @endif
                                    </div>
                                    <button type="button" id="add_enquete_entreprise" class="btn btn-success">
                                        Ajouter une enquête Entreprise
                                    </button>
                                </div>

                                <div class="mb-6">
                                    <h4 class="text-md font-semibold mb-2">Expérience d\\'enquêtes (Socio-économique)</h4>
                                    <div id="enquetes_socio_economique_container">
                                        @if(old("enquetes_socio_economique"))
                                            @foreach(old("enquetes_socio_economique") as $index => $enquete)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][annee]" class="block text-sm font-medium text-gray-700">Année</label>
                                                        <input type="number" name="enquetes_socio_economique[{{ $index }}][annee]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["annee"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][intitule]" class="block text-sm font-medium text-gray-700">Intitulé</label>
                                                        <input type="text" name="enquetes_socio_economique[{{ $index }}][intitule]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["intitule"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][fonction]" class="block text-sm font-medium text-gray-700">Fonction</label>
                                                        <input type="text" name="enquetes_socio_economique[{{ $index }}][fonction]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["fonction"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][structure]" class="block text-sm font-medium text-gray-700">Structure</label>
                                                        <input type="text" name="enquetes_socio_economique[{{ $index }}][structure]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["structure"] ?? "" }}">
                                                    </div>
                                                    <div>
                                                        <label for="enquetes_socio_economique[{{ $index }}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d\\'enquêtes</label>
                                                        <input type="number" name="enquetes_socio_economique[{{ $index }}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $enquete["nombre_enquetes"] ?? "" }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-600">Ajoutez au moins une expérience d'enquête Socio-économique.</p>
                                        @endif
                                    </div>
                                    <button type="button" id="add_enquete_socio_economique" class="btn btn-success">
                                        Ajouter une enquête Socio-économique
                                    </button>
                                </div>

                                <div class="mb-6">
                                    <label for="experience_cerd" class="block text-sm font-medium text-gray-700">Expérience avec le CERD</label>
                                    <textarea name="experience_cerd" id="experience_cerd" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old("experience_cerd") }}</textarea>
                                </div>
                            </div>

                            <!-- Volontaires -->
                            <div id="volontaire_fields" class="hidden">
                                <h3 class="text-lg font-semibold mb-4">Champs Spécifiques Volontaire</h3>
                                <div class="mb-6">
                                    <label for="statut_mission_volontaire" class="block text-sm font-medium text-gray-700">Statut de mission</label>
                                    <select name="statut_mission_volontaire" id="statut_mission_volontaire" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Sélectionner</option>
                                        <option value="achevee" {{ old("statut_mission_volontaire") == "achevee" ? "selected" : "" }}>Achevée</option>
                                        <option value="en_cours" {{ old("statut_mission_volontaire") == "en_cours" ? "selected" : "" }}>En cours</option>
                                        <option value="en_attente" {{ old("statut_mission_volontaire") == "en_attente" ? "selected" : "" }}>En attente</option>
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
                                        <option value="en_attente" {{ old("statut_stagiaire") == "en_attente" ? "selected" : "" }}>En attente</option>
                                        <option value="en_cours" {{ old("statut_stagiaire") == "en_cours" ? "selected" : "" }}>En cours</option>
                                        <option value="validee" {{ old("statut_stagiaire") == "validee" ? "selected" : "" }}>Validée</option>
                                        <option value="achevee" {{ old("statut_stagiaire") == "achevee" ? "selected" : "" }}>Achevée</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 bg-green-500 hover:bg-green-600 text-white">
                                Ajouter Personnel
                            </button>
                        </div>
                    <div id="dynamic-fields-container" class="my-4"></div>
</form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFields() {
            const typePersonnelSelect = document.getElementById("type_personnel_id");
            const selectedOption = typePersonnelSelect.options[typePersonnelSelect.selectedIndex];
            const typeName = selectedOption ? selectedOption.dataset.typeName : null;

            // Hide all specific field containers first
            document.getElementById("formateur_fields").style.display = "none";
            document.getElementById("agent_de_collecte_fields").style.display = "none";
            document.getElementById("volontaire_fields").style.display = "none";
            document.getElementById("stagiaire_fields").style.display = "none";

            // Reset required attributes for all specific fields
            const specificFieldInputs = document.querySelectorAll("#specific_fields_container input, #specific_fields_container select, #specific_fields_container textarea");
            specificFieldInputs.forEach(input => input.removeAttribute("required"));

            // Show fields based on type and set required attributes if necessary
            switch (typeName) {
                case "formateur":
                    document.getElementById("formateur_fields").style.display = "block";
                    // Add required attributes for formateur fields if needed
                    // document.getElementById("specialite_formation").setAttribute("required", "required");
                    break;
                case "agent_de_collecte": // Note: slugified name
                    document.getElementById("agent_de_collecte_fields").style.display = "block";
                    // Add required attributes for agent_de_collecte fields if needed
                    // document.getElementById("type_agent_collecte").setAttribute("required", "required");
                    break;
                case "volontaire":
                    document.getElementById("volontaire_fields").style.display = "block";
                    // Add required attributes for volontaire fields if needed
                    // document.getElementById("statut_mission_volontaire").setAttribute("required", "required");
                    break;
                case "stagiaire":
                    document.getElementById("stagiaire_fields").style.display = "block";
                    // Add required attributes for stagiaire fields if needed
                    // document.getElementById("statut_stagiaire").setAttribute("required", "required");
                    break;
                default:
                    // Consultants and others have no specific fields to show/hide
                    break;
            }
        }

        // Call toggleFields on page load to set initial state
        document.addEventListener("DOMContentLoaded", function() {
            toggleFields();

            // Dynamic fields for Diplômes
            document.getElementById("add_diplome").addEventListener("click", function() {
                const container = document.getElementById("diplomes_container");
                const index = container.children.length;
                const newDiplomeHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border p-4 rounded-md">
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
                container.insertAdjacentHTML("beforeend", newDiplomeHtml);
            });

            // Dynamic fields for Expériences Professionnelles
            document.getElementById("add_experience").addEventListener("click", function() {
                const container = document.getElementById("experiences_container");
                const index = container.children.length;
                const newExperienceHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
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
                            <label for="experiences[${index}][domaine_intervention]" class="block text-sm font-medium text-gray-700">Domaine d\\'intervention</label>
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
                container.insertAdjacentHTML("beforeend", newExperienceHtml);
            });

            // Dynamic fields for Langues parlées (Agents de collecte)
            document.getElementById("add_langue").addEventListener("click", function() {
                const container = document.getElementById("langues_parlees_container");
                const index = container.children.length;
                const newLangueHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
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
                container.insertAdjacentHTML("beforeend", newLangueHtml);
            });

            // Dynamic fields for Expérience d\\'enquêtes (Ménage)
            document.getElementById("add_enquete_menage").addEventListener("click", function() {
                const container = document.getElementById("enquetes_menage_container");
                const index = container.children.length;
                const newEnqueteMenageHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
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
                            <label for="enquetes_menage[${index}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d\\'enquêtes</label>
                            <input type="number" name="enquetes_menage[${index}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML("beforeend", newEnqueteMenageHtml);
            });

            // Dynamic fields for Expérience d\\'enquêtes (Entreprise)
            document.getElementById("add_enquete_entreprise").addEventListener("click", function() {
                const container = document.getElementById("enquetes_entreprise_container");
                const index = container.children.length;
                const newEnqueteEntrepriseHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
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
                            <label for="enquetes_entreprise[${index}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d\\'enquêtes</label>
                            <input type="number" name="enquetes_entreprise[${index}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML("beforeend", newEnqueteEntrepriseHtml);
            });

            // Dynamic fields for Expérience d\\'enquêtes (Socio-économique)
            document.getElementById("add_enquete_socio_economique").addEventListener("click", function() {
                const container = document.getElementById("enquetes_socio_economique_container");
                const index = container.children.length;
                const newEnqueteSocioEconomiqueHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border p-4 rounded-md">
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
                            <label for="enquetes_socio_economique[${index}][nombre_enquetes]" class="block text-sm font-medium text-gray-700">Nombre d\\'enquêtes</label>
                            <input type="number" name="enquetes_socio_economique[${index}][nombre_enquetes]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML("beforeend", newEnqueteSocioEconomiqueHtml);
            });
        });
    </script>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-field')) {
            e.preventDefault();
            e.target.closest('.dynamic-field')?.remove();
        }
    });

    document.querySelectorAll('.add-field').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const container = document.querySelector('#dynamic-fields-container');
            const newField = document.createElement('div');
            newField.className = 'dynamic-field flex items-center gap-2 mb-2';
            newField.innerHTML = `
                <input type="text" name="custom_fields[]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                <button class="remove-field bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" title="Supprimer ce champ">X</button>
            `;
            container.appendChild(newField);
        });
    });
});
</script>
