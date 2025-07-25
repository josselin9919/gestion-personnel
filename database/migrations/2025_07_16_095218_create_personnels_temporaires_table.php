<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personnels_temporaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->enum('sexe', ['M', 'F']);
            $table->enum('situation_matrimoniale', ['celibataire', 'marie', 'divorce', 'veuf']);
            $table->integer('nombre_enfants')->nullable();
            $table->string('adresse');
            $table->string('ville');
            $table->string('region');
            $table->string('pays');
            $table->string('niveau_etude');
            $table->string('specialite')->nullable();
            $table->integer('experience_annees')->nullable();
            $table->text('competences_cles')->nullable();
            $table->enum('disponibilite', ['temps_plein', 'temps_partiel', 'ponctuel']);
            $table->decimal('tarif_journalier', 10, 2)->nullable();
            $table->string('devise', 10)->nullable();
            $table->enum('statut', ['actif', 'inactif', 'suspendu']);
            $table->foreignId('type_personnel_id')->constrained('types_personnel');
            $table->foreignId('structure_id')->nullable()->constrained('structures');

            // Champs spécifiques aux rôles
            $table->enum('type_agent', ['enqueteur', 'controleur', 'superviseur'])->nullable();
            $table->text('experience_cerd')->nullable();

            $table->string('specialite_formation')->nullable();
            $table->integer('nombre_formations_animees')->nullable();

            $table->enum('statut_mission', ['en_attente', 'en_cours', 'achevee'])->nullable();

            $table->enum('statut_stage', ['en_attente', 'en_cours', 'validee', 'achevee'])->nullable();
            $table->enum('statut_validation', ['valide', 'non_valide'])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnels_temporaires');
    }
};
