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
            // Drop the foreign key constraint first if it exists
            if (Schema::hasColumn("experiences_professionnelles", "structure_id")) {
                $table->dropForeign(["structure_id"]);
                $table->dropColumn("structure_id");
            }

            // Add the new structure_nom column
            $table->string("structure_nom")->nullable()->after("pays");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("experiences_professionnelles", function (Blueprint $table) {
            $table->dropColumn("structure_nom");
            // Re-add structure_id if needed for rollback, but it won't have a foreign key to 'structures' table as it will be dropped later
            $table->unsignedBigInteger("structure_id")->nullable()->after("pays");
        });
    }
};



