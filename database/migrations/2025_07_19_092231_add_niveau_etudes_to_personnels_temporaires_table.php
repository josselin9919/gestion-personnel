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
            $table->string("niveau_etudes")->nullable()->after("domaine_etude");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("personnels_temporaires", function (Blueprint $table) {
            $table->dropColumn("niveau_etudes");
        });
    }
};
