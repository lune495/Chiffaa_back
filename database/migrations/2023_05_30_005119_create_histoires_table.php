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
        Schema::create('histoires', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->float('prix')->default(0);
            $table->string('genre');
            $table->text('resume');
            $table->unsignedBigInteger('famille_histoire_id');
            $table->foreign('famille_histoire_id')->references('id')->on('famille_histoires');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histoires');
    }
};
