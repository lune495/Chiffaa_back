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
        Schema::create('element_maternites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maternite_id')->nullable();
            $table->foreign('maternite_id')->references('id')->on('maternites');
            $table->unsignedBigInteger('type_maternite_id')->nullable();
            $table->foreign('type_maternite_id')->references('id')->on('type_maternites');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_maternites');
    }
};
