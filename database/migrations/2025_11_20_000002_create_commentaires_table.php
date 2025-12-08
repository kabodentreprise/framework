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
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->text('texte');
            $table->integer('note');
            $table->date('date');
            $table->unsignedBigInteger('id_utilisateur');
            $table->unsignedBigInteger('id_contenu');

            $table->foreign('id_utilisateur')->references('id')->on('utilisateurs');
            $table->foreign('id_contenu')->references('id')->on('contenus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaires');
    }
};
