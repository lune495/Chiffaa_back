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
        Schema::create('element_echographes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('echographe_id')->nullable();
            $table->foreign('echographe_id')->references('id')->on('echographes');
            $table->unsignedBigInteger('type_echographe_id')->nullable();
            $table->foreign('type_echographe_id')->references('id')->on('type_echographes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_echographes');
    }
};
