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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medecin_id');
            $table->foreign('medecin_id')->references('id')->on('medecins');
            $table->unsignedBigInteger('creneau_id');
            $table->foreign('creneau_id')->references('id')->on('creneaux');
            $table->string('type'); // exemple: 'rdv_nouveau', 'rdv_annule'
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
