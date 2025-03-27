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
        Schema::create('creneaux', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planning_id');
            $table->foreign('planning_id')->references('id')->on('plannings');
            $table->date('date'); // Date du créneau
            $table->string('heure_debut'); // Heure de début (ex: "08:00")
            $table->string('heure_fin'); // Heure de fin (ex: "08:30")
            $table->boolean('disponible')->default(true); // true = libre, false = réservé
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creneaux');
    }
};
