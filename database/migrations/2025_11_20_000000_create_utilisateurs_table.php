<?php
// database/migrations/2025_11_20_000000_create_utilisateurs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->enum('sexe', ['M', 'F', 'Autre'])->default('M');
            $table->timestamp('date_inscription')->useCurrent();
            $table->date('date_naissance');
            $table->enum('statut', ['actif', 'inactif', 'suspendu', 'restreint', 'banni'])
                  ->default('actif');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('id_role');
            $table->unsignedBigInteger('id_langue')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index(['statut', 'date_inscription']);
            $table->index('email');

            // Clés étrangères
            $table->foreign('id_role')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('id_langue')
                  ->references('id')
                  ->on('langues')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
