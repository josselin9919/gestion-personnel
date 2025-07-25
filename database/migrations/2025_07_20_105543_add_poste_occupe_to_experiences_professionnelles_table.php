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
            $table->string("poste_occupe")->nullable()->after("domaine_intervention");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("experiences_professionnelles", function (Blueprint $table) {
            $table->dropColumn("poste_occupe");
        });
    }
};
