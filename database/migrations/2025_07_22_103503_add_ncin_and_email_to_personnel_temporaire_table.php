<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('personnels_temporaires', function (Blueprint $table) {
        $table->string('ncin')->nullable()->after('nom'); // ou après le champ de ton choix
        $table->string('email')->nullable()->unique()->after('ncin');
    });
}

public function down()
{
    Schema::table('personnels_temporaires', function (Blueprint $table) {
        $table->dropColumn(['ncin', 'email']);
    });
}
};
