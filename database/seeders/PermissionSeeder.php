<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Réinitialiser le cache des rôles et permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Définir toutes les permissions pour chaque module
        $permissions = [
            // Gestion des utilisateurs
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Gestion des rôles et permissions
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'permissions.assign',

            // Gestion des projets
            'projets.view',
            'projets.create',
            'projets.edit',
            'projets.delete',

            // Gestion du personnel temporaire
            'personnel.view',
            'personnel.create',
            'personnel.edit',
            'personnel.delete',

            // Gestion des critères d'évaluation
            'criteres.view',
            'criteres.create',
            'criteres.edit',
            'criteres.delete',
            'criteres.toggle',

            // Gestion des évaluations
            'evaluations.view',
            'evaluations.create',
            'evaluations.edit',
            'evaluations.delete',
            'evaluations.historique',

            // Gestion des types de personnel
            'types-personnel.view',
            'types-personnel.create',
            'types-personnel.edit',
            'types-personnel.delete',

            // Gestion des structures
            'structures.view',
            'structures.create',
            'structures.edit',
            'structures.delete',

            // Dashboard et rapports
            'dashboard.view',
            'reports.view',
            'reports.export',

            // Administration système
            'system.settings',
            'system.logs',
            'system.backup',
        ];

        // Créer toutes les permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Créer le rôle Super Admin avec toutes les permissions
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Créer d'autres rôles de base
        $adminRole = Role::create(['name' => 'Administrateur']);
        $adminRole->givePermissionTo([
            'users.view', 'users.create', 'users.edit',
            'projets.view', 'projets.create', 'projets.edit', 'projets.delete',
            'personnel.view', 'personnel.create', 'personnel.edit', 'personnel.delete',
            'criteres.view', 'criteres.create', 'criteres.edit', 'criteres.delete', 'criteres.toggle',
            'evaluations.view', 'evaluations.create', 'evaluations.edit', 'evaluations.delete', 'evaluations.historique',
            'dashboard.view', 'reports.view', 'reports.export',
        ]);

        $managerRole = Role::create(['name' => 'Gestionnaire']);
        $managerRole->givePermissionTo([
            'projets.view', 'projets.create', 'projets.edit',
            'personnel.view', 'personnel.create', 'personnel.edit',
            'criteres.view', 'criteres.create', 'criteres.edit',
            'evaluations.view', 'evaluations.create', 'evaluations.edit', 'evaluations.historique',
            'dashboard.view', 'reports.view',
        ]);

        $evaluatorRole = Role::create(['name' => 'Évaluateur']);
        $evaluatorRole->givePermissionTo([
            'projets.view',
            'personnel.view',
            'criteres.view',
            'evaluations.view', 'evaluations.create', 'evaluations.edit',
            'dashboard.view',
        ]);

        // Créer un utilisateur Super Admin par défaut
        $superAdmin = User::create([
            'name' => 'Super Administrateur',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password123'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        echo "Permissions et rôles créés avec succès!\n";
        echo "Super Admin créé: superadmin@example.com / password123\n";
    }
}
