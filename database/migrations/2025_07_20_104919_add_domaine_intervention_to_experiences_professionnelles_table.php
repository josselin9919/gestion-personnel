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
        Schema::table("experiences_professionnelles", function (Blueprint $table) {
            $table->string("domaine_intervention")->nullable()->after("structure_nom");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("experiences_professionnelles", function (Blueprint $table) {
            $table->dropColumn("domaine_intervention");
        });
    }
};
