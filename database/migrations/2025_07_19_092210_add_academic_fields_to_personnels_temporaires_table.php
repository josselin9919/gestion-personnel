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
        Schema::table("personnels_temporaires", function (Blueprint $table) {
            $table->string("diplome_plus_eleve")->nullable()->after("domaine_expertise");
            $table->string("domaine_etude")->nullable()->after("diplome_plus_eleve");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("personnels_temporaires", function (Blueprint $table) {
            $table->dropColumn("diplome_plus_eleve");
            $table->dropColumn("domaine_etude");
        });
    }
};
