<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('criteres_evaluation', function (Blueprint $table) {
            // Supprimer la colonne type_personnel_id
            $table->dropForeign(['type_personnel_id']);
            $table->dropColumn('type_personnel_id');

            // Ajouter la colonne projet_id
            $table->unsignedBigInteger('projet_id')->after('description');
            $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('criteres_evaluation', function (Blueprint $table) {
            // Supprimer la colonne projet_id
            $table->dropForeign(['projet_id']);
            $table->dropColumn('projet_id');

            // Remettre la colonne type_personnel_id
            $table->unsignedBigInteger('type_personnel_id')->after('description');
            $table->foreign('type_personnel_id')->references('id')->on('type_personnels')->onDelete('cascade');
        });
    }
};
