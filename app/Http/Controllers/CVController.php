<?php

namespace App\Http\Controllers;

use App\Models\PersonnelTemporaire;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CVController extends Controller
{
    /**
     * Générer le CV d'un personnel temporaire
     */
    public function generateCV($id)
    {
        $personnel = PersonnelTemporaire::with([
            'typePersonnel',
            'diplomes',
            'experiencesProfessionnelles',
            'experiencesEnquetes',
            'evaluations.projet',
            'langues'
        ])->findOrFail($id);

        // Calculer l'âge
        $age = $personnel->date_naissance ? $personnel->date_naissance->age : null;

        // Organiser les expériences par ordre chronologique décroissant
        $experiences = $personnel->experiencesProfessionnelles()
            ->orderBy('date_debut', 'desc')
            ->get();

        // Organiser les diplômes par année décroissante et prendre les 3 derniers
        $diplomes = $personnel->diplomes()
            ->orderBy('annee', 'desc')
            ->take(3)
            ->get();

        // Organiser les expériences d'enquêtes par année décroissante
        $enquetes = $personnel->experiencesEnquetes()
            ->orderBy('annee', 'desc')
            ->get();

        // Calculer le score moyen des évaluations
        $scoreMoyen = $personnel->evaluations()->avg('score_total') ?? 0;

        // Récupérer les projets évalués
        $projetsEvalues = $personnel->evaluations()
            ->with('projet')
            ->whereHas('projet')
            ->get()
            ->pluck('projet')
            ->unique('id');

        // Préparer les compétences techniques (uniquement celles saisies par l'utilisateur)
        $competencesTechniques = [];
        if ($personnel->competences_cles) {
            $competencesTechniques = array_map('trim', explode(',', $personnel->competences_cles));
        }

        // Préparer les soft skills (uniquement celles saisies par l'utilisateur, si applicable)
        $softSkills = [];
        // Si vous avez un champ spécifique pour les soft skills dans votre modèle PersonnelTemporaire,
        // vous pouvez l'utiliser ici. Sinon, cette section restera vide ou affichera des compétences générales.
        // Pour l'instant, je vais laisser cette partie vide pour ne pas 'inventer' de données.


        // Préparer le chemin absolu de la photo pour Dompdf
        $photoPath = null;
        if ($personnel->photo) {
            $photoPath = public_path($personnel->photo);
            // Vérifier si le fichier existe
            if (!file_exists($photoPath)) {
                $photoPath = null;
            }
        }

        $data = [
            'personnel' => $personnel,
            'age' => $age,
            'experiences' => $experiences,
            'diplomes' => $diplomes,
            'enquetes' => $enquetes,
            'scoreMoyen' => $scoreMoyen,
            'projetsEvalues' => $projetsEvalues,
            'competencesTechniques' => $competencesTechniques,
            'softSkills' => $softSkills,
            'photoPath' => $photoPath,
        ];

        $pdf = PDF::loadView('cv.template', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'Arial',
            'dpi' => 150,
            'defaultPaperSize' => 'A4',
            'isRemoteEnabled' => true
        ]);

        return $pdf->download('CV_' . $personnel->nom . '_' . $personnel->prenom . '.pdf');
    }

    /**
     * Afficher l'aperçu du CV
     */
    public function previewCV($id)
    {
        $personnel = PersonnelTemporaire::with([
            'typePersonnel',
            'diplomes',
            'experiencesProfessionnelles',
            'experiencesEnquetes',
            'evaluations.projet',
            'langues'
        ])->findOrFail($id);

        // Calculer l'âge
        $age = $personnel->date_naissance ? $personnel->date_naissance->age : null;

        // Organiser les expériences par ordre chronologique décroissant
        $experiences = $personnel->experiencesProfessionnelles()
            ->orderBy('date_debut', 'desc')
            ->get();

        // Organiser les diplômes par année décroissante et prendre les 3 derniers
        $diplomes = $personnel->diplomes()
            ->orderBy('annee', 'desc')
            ->take(3)
            ->get();

        // Organiser les expériences d'enquêtes par année décroissante
        $enquetes = $personnel->experiencesEnquetes()
            ->orderBy('annee', 'desc')
            ->get();

        // Calculer le score moyen des évaluations
        $scoreMoyen = $personnel->evaluations()->avg('score_total') ?? 0;

        // Récupérer les projets évalués
        $projetsEvalues = $personnel->evaluations()
            ->with('projet')
            ->whereHas('projet')
            ->get()
            ->pluck('projet')
            ->unique('id');

        // Préparer les compétences techniques (uniquement celles saisies par l'utilisateur)
        $competencesTechniques = [];
        if ($personnel->competences_cles) {
            $competencesTechniques = array_map('trim', explode(',', $personnel->competences_cles));
        }

        // Préparer les soft skills (uniquement celles saisies par l'utilisateur, si applicable)
        $softSkills = [];
        // Si vous avez un champ spécifique pour les soft skills dans votre modèle PersonnelTemporaire,
        // vous pouvez l'utiliser ici. Sinon, cette section restera vide ou affichera des compétences générales.
        // Pour l'instant, je vais laisser cette partie vide pour ne pas 'inventer' de données.


        // Préparer le chemin de la photo pour l'aperçu
        $photoPath = null;
        if ($personnel->photo) {
            $photoPath = asset($personnel->photo);
        }

        $data = [
            'personnel' => $personnel,
            'age' => $age,
            'experiences' => $experiences,
            'diplomes' => $diplomes,
            'enquetes' => $enquetes,
            'scoreMoyen' => $scoreMoyen,
            'projetsEvalues' => $projetsEvalues,
            'competencesTechniques' => $competencesTechniques,
            'softSkills' => $softSkills,
            'photoPath' => $photoPath,
        ];

        return view('cv.template', $data);
    }


}
