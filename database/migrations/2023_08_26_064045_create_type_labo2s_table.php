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
        Schema::create('type_labo2s', function (Blueprint $table) {
            $table->id();
            $table->string("nom"); 
            $table->string("prix");
            $table->unsignedBigInteger('sous_type_labo2_id')->nullable();
            $table->foreign('sous_type_labo2_id')->references('id')->on('sous_type_labo2s');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_labo2s');
    }
};