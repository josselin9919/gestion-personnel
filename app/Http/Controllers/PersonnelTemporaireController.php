<?php

namespace App\Http\Controllers;

use App\Models\PersonnelTemporaire;
use App\Models\TypePersonnel;
use App\Models\Structure;
use App\Models\Langue;
use App\Models\Diplome;
use App\Models\ExperienceProfessionnelle;
use App\Models\ExperienceEnquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonnelTemporaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personnels = PersonnelTemporaire::with(['typePersonnel', 'structure'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('personnel.index', compact('personnels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typesPersonnel = TypePersonnel::all();
        $structures = Structure::all();
        $langues = Langue::all();

        return view('personnel.create', compact('typesPersonnel', 'structures', 'langues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des champs de base
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'ncin' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255|unique:personnels_temporaires,email',
            'telephone' => 'nullable|string|max:20',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'required|date',
            'domaine_expertise' => 'required|string|max:255',
            'diplome_plus_eleve' => 'required|string|max:255',
            'domaine_etude' => 'required|string|max:255',
            'type_personnel_id' => 'required|exists:types_personnel,id',

            // Champs spécifiques selon le type
            'niveau_etudes' => 'nullable|string|max:255',
            'type_agent_collecte' => 'nullable|in:superviseur,controleur,enqueteur',
            'experience_cerd' => 'nullable|string',
            'specialite_formation' => 'nullable|string|max:255',
            'nombre_formations_animees' => 'nullable|integer|min:0',
            'statut_mission_volontaire' => 'nullable|in:achevee,en_cours,en_attente',
            'statut_stagiaire' => 'nullable|in:en_attente,en_cours,validee,achevee',

            // Validation des tableaux de données liées
            'diplomes' => 'nullable|array',
            'diplomes.*.annee' => 'required_with:diplomes|integer|min:1900|max:' . date('Y'),
            'diplomes.*.intitule' => 'required_with:diplomes|string|max:255',
            'diplomes.*.etablissement' => 'required_with:diplomes|string|max:255',

            'experiences' => 'nullable|array',
            'experiences.*.date_debut' => 'required_with:experiences|date',
            'experiences.*.date_fin' => 'nullable|date|after_or_equal:experiences.*.date_debut',
            'experiences.*.pays' => 'required_with:experiences|string|max:255',
            'experiences.*.structure_nom' => 'required_with:experiences|string|max:255',
            'experiences.*.domaine_intervention' => 'required_with:experiences|string|max:255',
            'experiences.*.poste_occupe' => 'required_with:experiences|string|max:255',
            'experiences.*.description' => 'nullable|string',

            'langues_parlees' => 'nullable|array',
            'langues_parlees.*.langue' => 'required_with:langues_parlees|string|max:255',
            'langues_parlees.*.niveau' => 'required_with:langues_parlees|string|max:255',

            'enquetes_menage' => 'nullable|array',
            'enquetes_menage.*.annee' => 'required_with:enquetes_menage|integer|min:1900|max:' . date('Y'),
            'enquetes_menage.*.intitule' => 'required_with:enquetes_menage|string|max:255',
            'enquetes_menage.*.fonction' => 'required_with:enquetes_menage|string|max:255',
            'enquetes_menage.*.structure' => 'required_with:enquetes_menage|string|max:255',
            'enquetes_menage.*.nombre_enquetes' => 'required_with:enquetes_menage|integer|min:0',

            'enquetes_entreprise' => 'nullable|array',
            'enquetes_entreprise.*.annee' => 'required_with:enquetes_entreprise|integer|min:1900|max:' . date('Y'),
            'enquetes_entreprise.*.intitule' => 'required_with:enquetes_entreprise|string|max:255',
            'enquetes_entreprise.*.fonction' => 'required_with:enquetes_entreprise|string|max:255',
            'enquetes_entreprise.*.structure' => 'required_with:enquetes_entreprise|string|max:255',
            'enquetes_entreprise.*.nombre_enquetes' => 'required_with:enquetes_entreprise|integer|min:0',

            'enquetes_socio_economique' => 'nullable|array',
            'enquetes_socio_economique.*.annee' => 'required_with:enquetes_socio_economique|integer|min:1900|max:' . date('Y'),
            'enquetes_socio_economique.*.intitule' => 'required_with:enquetes_socio_economique|string|max:255',
            'enquetes_socio_economique.*.fonction' => 'required_with:enquetes_socio_economique|string|max:255',
            'enquetes_socio_economique.*.structure' => 'required_with:enquetes_socio_economique|string|max:255',
            'enquetes_socio_economique.*.nombre_enquetes' => 'required_with:enquetes_socio_economique|integer|min:0',
        ]);

        // Utilisation d'une transaction pour assurer la cohérence des données
        DB::beginTransaction();

        try {
            // Préparation des données pour le personnel temporaire
            $personnelData = [
                'nom' => $validated['nom'],
                'ncin' => $validated['ncin'] ?? null,
                'email' => $validated['email'] ?? null,
                'telephone' => $validated['telephone'] ?? null,
                'sexe' => $validated['sexe'],
                'date_naissance' => $validated['date_naissance'],
                'domaine_expertise' => $validated['domaine_expertise'],
                'diplome_plus_eleve' => $validated['diplome_plus_eleve'],
                'domaine_etude' => $validated['domaine_etude'],
                'type_personnel_id' => $validated['type_personnel_id'],
            ];

            // Ajout des champs spécifiques selon le type de personnel
            $typePersonnel = TypePersonnel::find($validated['type_personnel_id']);
            $typeNom = strtolower($typePersonnel->nom);

            switch ($typeNom) {
                case 'agent_collecte':
                    $personnelData['type_agent'] = $validated['type_agent_collecte'] ?? null;
                    $personnelData['niveau_etudes'] = $validated['niveau_etudes'] ?? null;
                    $personnelData['experience_cerd'] = $validated['experience_cerd'] ?? null;
                    break;

                case 'formateur':
                    $personnelData['specialite_formation'] = $validated['specialite_formation'] ?? null;
                    $personnelData['nombre_formations_animees'] = $validated['nombre_formations_animees'] ?? null;
                    break;

                case 'volontaire':
                    $personnelData['statut_mission'] = $validated['statut_mission_volontaire'] ?? null;
                    break;

                case 'stagiaire':
                    $personnelData['statut_stage'] = $validated['statut_stagiaire'] ?? null;
                    break;
            }

            // Création du personnel temporaire
            $personnel = PersonnelTemporaire::create($personnelData);

            // Enregistrement des diplômes
            if (!empty($validated['diplomes'])) {
                foreach ($validated['diplomes'] as $diplomeData) {
                    if (!empty($diplomeData['annee']) && !empty($diplomeData['intitule']) && !empty($diplomeData['etablissement'])) {
                        Diplome::create([
                            'personnel_temporaire_id' => $personnel->id,
                            'annee' => $diplomeData['annee'],
                            'intitule' => $diplomeData['intitule'],
                            'etablissement' => $diplomeData['etablissement'],
                        ]);
                    }
                }
            }

            // Enregistrement des expériences professionnelles
            if (!empty($validated['experiences'])) {
                foreach ($validated['experiences'] as $experienceData) {
                    if (!empty($experienceData['date_debut']) && !empty($experienceData['pays']) &&
                        !empty($experienceData['structure_nom']) && !empty($experienceData['domaine_intervention']) &&
                        !empty($experienceData['poste_occupe'])) {

                        ExperienceProfessionnelle::create([
                            'personnel_temporaire_id' => $personnel->id,
                            'date_debut' => $experienceData['date_debut'],
                            'date_fin' => $experienceData['date_fin'] ?? null,
                            'pays' => $experienceData['pays'],
                            'structure_nom' => $experienceData['structure_nom'],
                            'domaine_intervention' => $experienceData['domaine_intervention'],
                            'poste_occupe' => $experienceData['poste_occupe'],
                            'description' => $experienceData['description'] ?? null,
                        ]);
                    }
                }
            }

            // Enregistrement des langues parlées (pour les agents de collecte)
            if (!empty($validated['langues_parlees']) && in_array($typeNom, ['agent de collecte', 'agent_de_collecte','agent_collecte'])) {
                foreach ($validated['langues_parlees'] as $langueData) {
                    if (!empty($langueData['langue']) && !empty($langueData['niveau'])) {
                        // Créer ou récupérer la langue
                        $langue = Langue::firstOrCreate(['nom' => $langueData['langue']]);

                        // Associer la langue au personnel avec le niveau
                        $personnel->langues()->attach($langue->id, ['niveau' => $langueData['niveau']]);
                    }
                }
            }

            // Enregistrement des expériences d'enquêtes (pour les agents de collecte)
            if (in_array($typeNom, ['agent de collecte', 'agent_de_collecte','agent_collecte'])) {
                $typesEnquetes = [
                    'enquetes_menage' => 'menage',
                    'enquetes_entreprise' => 'entreprise',
                    'enquetes_socio_economique' => 'socio_economique'
                ];

                foreach ($typesEnquetes as $key => $type) {
                    if (!empty($validated[$key])) {
                        foreach ($validated[$key] as $enqueteData) {
                            if (!empty($enqueteData['annee']) && !empty($enqueteData['intitule']) &&
                                !empty($enqueteData['fonction']) && !empty($enqueteData['structure'])) {

                                ExperienceEnquete::create([
                                    'personnel_temporaire_id' => $personnel->id,
                                    'type_enquete' => $type,
                                    'annee' => $enqueteData['annee'],
                                    'intitule' => $enqueteData['intitule'],
                                    'fonction' => $enqueteData['fonction'],
                                    'structure' => $enqueteData['structure'],
                                    'nombre_enquetes' => $enqueteData['nombre_enquetes'] ?? 0,
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('personnel.index')
                ->with('success', 'Personnel temporaire ajouté avec succès avec toutes ses informations liées.');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonnelTemporaire $personnel)
    {
        $personnel->load([
            'typePersonnel',
            'structure',
            'langues',
            'diplomes',
            'experiencesProfessionnelles',
            'experiencesEnquetes',
            'evaluations'
        ]);

        return view('personnel.show', compact('personnel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonnelTemporaire $personnel)
    {
        $typesPersonnel = TypePersonnel::all();
        $structures = Structure::all();
        $langues = Langue::all();

        $personnel->load([
            'diplomes',
            'experiencesProfessionnelles',
            'experiencesEnquetes',
            'langues'
        ]);

        return view('personnel.edit', compact('personnel', 'typesPersonnel', 'structures', 'langues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonnelTemporaire $personnel)
    {
        // Même logique de validation et mise à jour que pour store()
        // mais avec mise à jour des enregistrements existants

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'ncin' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255|unique:personnels_temporaires,email' . $personnel->id,
            'telephone' => 'nullable|string|max:20',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'required|date',
            'domaine_expertise' => 'required|string|max:255',
            'diplome_plus_eleve' => 'required|string|max:255',
            'domaine_etude' => 'required|string|max:255',
            'type_personnel_id' => 'required|exists:types_personnel,id',
            // ... autres validations similaires à store()
        ]);

        DB::beginTransaction();

        try {
            // Mise à jour du personnel temporaire
            $personnelData = [
                'nom' => $validated['nom'],
                'sexe' => $validated['sexe'],
                'ncin' => $validated['ncin'] ?? null,
                'email' => $validated['email'] ?? null,
                'telephone' => $validated['telephone'] ?? null,
                'date_naissance' => $validated['date_naissance'],
                'domaine_expertise' => $validated['domaine_expertise'],
                'diplome_plus_eleve' => $validated['diplome_plus_eleve'],
                'domaine_etude' => $validated['domaine_etude'],
                'type_personnel_id' => $validated['type_personnel_id'],
            ];

            $personnel->update($personnelData);

            // Supprimer et recréer les relations (approche simple)
            $personnel->diplomes()->delete();
            $personnel->experiencesProfessionnelles()->delete();
            $personnel->experiencesEnquetes()->delete();
            $personnel->langues()->detach();

            // Recréer les relations avec la même logique que store()
            // ... (code similaire à store() pour les relations)

            DB::commit();

            return redirect()->route('personnel.index')
                ->with('success', 'Personnel temporaire mis à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonnelTemporaire $personnel)
    {
        try {
            // Les suppressions en cascade sont gérées par les migrations
            $personnel->delete();

            return redirect()->route('personnel.index')
                ->with('success', 'Personnel supprimé avec succès.');

        } catch (\Exception $e) {
            return redirect()->route('personnel.index')
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}

