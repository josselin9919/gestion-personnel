<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un utilisateur admin s'il n'existe pas
        if (!User::where('email', 'admin@cerd.org')->exists()) {
            User::factory()->create([
                'name' => 'Administrateur CERD',
                'email' => 'admin@cerd.org',
            ]);
        }

        $this->call([
            TypePersonnelSeeder::class,
            CritereEvaluationSeeder::class,
            // Ajoutez d'autres seeders ici si nécessaire
        ]);
    }
}

