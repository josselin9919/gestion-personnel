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
        Schema::table('evaluations', function (Blueprint $table) {
            // Ajoute la colonne projet_id et la rend nullable pour les données existantes
            $table->foreignId("projet_id")->nullable()->constrained("projets")->onDelete("cascade");
            // Supprime la colonne mission_contexte
            $table->dropColumn("mission_contexte");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("evaluations", function (Blueprint $table) {
            $table->dropForeign(["projet_id"]);
            $table->dropColumn("projet_id");
            $table->string("mission_contexte");
        });
    }
};
