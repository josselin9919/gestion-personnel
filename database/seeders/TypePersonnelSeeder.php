<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypePersonnel;

class TypePersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'nom' => 'Consultant',
                'description' => 'Expert fournissant des conseils spécialisés.'
            ],
            [
                'nom' => 'Formateur',
                'description' => 'Professionnel chargé de dispenser des formations.'
            ],
            [
                'nom' => 'Agent de Collecte',
                'description' => 'Agent chargé de la collecte de données sur le terrain.'
            ],
            [
                'nom' => 'Volontaire',
                'description' => 'Personne offrant ses services bénévolement.'
            ],
            [
                'nom' => 'Stagiaire',
                'description' => 'Personne en formation pratique en entreprise.'
            ],
        ];

        foreach ($types as $type) {
            TypePersonnel::firstOrCreate(['nom' => $type['nom']], $type);
        }
    }
}
