<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CritereEvaluation;
use App\Models\TypePersonnel;

class CritereEvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultantType = TypePersonnel::where("nom", "Consultant")->first();
        $formateurType = TypePersonnel::where("nom", "Formateur")->first();
        $agentCollecteType = TypePersonnel::where("nom", "Agent de Collecte")->first();

        $criteres = [
            // Critères généraux
            [
                "nom" => "Ponctualité",
                "description" => "Respect des délais et des horaires.",
                "type_personnel_id" => null,
                "poids" => 0.5,
                "actif" => true,
            ],
            [
                "nom" => "Autonomie",
                "description" => "Capacité à travailler de manière indépendante.",
                "type_personnel_id" => null,
                "poids" => 0.8,
                "actif" => true,
            ],
            [
                "nom" => "Esprit d\"équipe",
                "description" => "Capacité à collaborer avec les autres membres de l\"équipe.",
                "type_personnel_id" => null,
                "poids" => 0.7,
                "actif" => true,
            ],

            // Critères spécifiques aux Consultants
            [
                "nom" => "Analyse et Diagnostic",
                "description" => "Capacité à analyser des situations complexes et à poser des diagnostics pertinents.",
                "type_personnel_id" => $consultantType->id ?? null,
                "poids" => 1.5,
                "actif" => true,
            ],
            [
                "nom" => "Qualité des Recommandations",
                "description" => "Pertinence et applicabilité des solutions proposées.",
                "type_personnel_id" => $consultantType->id ?? null,
                "poids" => 1.8,
                "actif" => true,
            ],

            // Critères spécifiques aux Formateurs
            [
                "nom" => "Pédagogie",
                "description" => "Capacité à transmettre les connaissances de manière claire et efficace.",
                "type_personnel_id" => $formateurType->id ?? null,
                "poids" => 1.7,
                "actif" => true,
            ],
            [
                "nom" => "Maîtrise du Sujet",
                "description" => "Profondeur et exactitude des connaissances dans le domaine enseigné.",
                "type_personnel_id" => $formateurType->id ?? null,
                "poids" => 1.9,
                "actif" => true,
            ],

            // Critères spécifiques aux Agents de Collecte
            [
                "nom" => "Rigueur de la Collecte",
                "description" => "Précision et exhaustivité des données collectées.",
                "type_personnel_id" => $agentCollecteType->id ?? null,
                "poids" => 1.6,
                "actif" => true,
            ],
            [
                "nom" => "Gestion des Difficultés Terrain",
                "description" => "Capacité à résoudre les problèmes rencontrés sur le terrain.",
                "type_personnel_id" => $agentCollecteType->id ?? null,
                "poids" => 1.4,
                "actif" => true,
            ],
        ];

        foreach ($criteres as $critere) {
            CritereEvaluation::firstOrCreate(
                ["nom" => $critere["nom"]],
                $critere
            );
        }
    }
}

