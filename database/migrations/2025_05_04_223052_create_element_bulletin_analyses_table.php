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
        Schema::create('element_bulletin_analyses', function (Blueprint $table) 
        {
            $table->id();
            $table->unsignedBigInteger('bulletin_analyse_id');
            $table->foreign('bulletin_analyse_id')->references('id')->on('bulletin_analyses');
            $table->unsignedBigInteger('type_service_id');
            $table->foreign('type_service_id')->references('id')->on('type_services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_bulletin_analyses');
    }
};