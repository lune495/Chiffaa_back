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
        Schema::create('element_dentaires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dentaire_id')->nullable();
            $table->foreign('dentaire_id')->references('id')->on('dentaires');
            $table->unsignedBigInteger('type_dentaire_id')->nullable();
            $table->foreign('type_dentaire_id')->references('id')->on('type_dentaires');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_dentaires');
    }
};
