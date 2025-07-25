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
        Schema::create('notes_criteres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained('evaluations')->onDelete('cascade');
            $table->foreignId('critere_evaluation_id')->constrained('criteres_evaluation');
            $table->decimal('note', 3, 2); // note sur 5
            $table->text('commentaire')->nullable();
            $table->timestamps();
            
            $table->unique(['evaluation_id', 'critere_evaluation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes_criteres');
    }
};
