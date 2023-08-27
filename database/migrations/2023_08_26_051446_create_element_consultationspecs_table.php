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
        Schema::create('element_consultationspecs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultationspec_id')->nullable();
            $table->foreign('consultationspec_id')->references('id')->on('consultationspecs');
            $table->unsignedBigInteger('type_consultationspec_id')->nullable();
            $table->foreign('type_consultationspec_id')->references('id')->on('type_consultationspecs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_consultationspecs');
    }
};
