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
        Schema::table('bulletin_analyses', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn('patient_id');
            $table->unsignedBigInteger('patient_medical_id')->nullable();
            $table->foreign('patient_medical_id')->references('id')->on('patient_medicals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bulletin_analyses', function (Blueprint $table) {
            $table->dropColumn('patient_medical_id'); // Supprime la colonne patient_medical_id
            $table->unsignedBigInteger('patient_id'); // Réajoute la colonne patient_id
            $table->foreign('patient_id')->references('id')->on('patients'); // Réajoute la contrainte de clé étrangère
        });
    }
};
