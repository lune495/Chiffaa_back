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
        Schema::create('element_labos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('labo_id')->nullable();
            $table->foreign('labo_id')->references('id')->on('labos');
            $table->unsignedBigInteger('type_labo_id')->nullable();
            $table->foreign('type_labo_id')->references('id')->on('type_labos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_labos');
    }
};
