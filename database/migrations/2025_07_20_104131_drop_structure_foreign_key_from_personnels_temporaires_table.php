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
            if (Schema::hasColumn("personnels_temporaires", "structure_id")) {
                $table->dropForeign(["structure_id"]);
                $table->dropColumn("structure_id");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("personnels_temporaires", function (Blueprint $table) {
            // Re-add structure_id if needed for rollback
            $table->unsignedBigInteger("structure_id")->nullable();
            $table->foreign("structure_id")->references("id")->on("structures");
        });
    }
};
