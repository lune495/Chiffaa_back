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
        Schema::create('element_labo2s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('labo2_id')->nullable();
            $table->foreign('labo2_id')->references('id')->on('labo2s');
            $table->unsignedBigInteger('type_labo2_id')->nullable();
            $table->foreign('type_labo2_id')->references('id')->on('type_labo2s');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_labo2s');
    }
};
