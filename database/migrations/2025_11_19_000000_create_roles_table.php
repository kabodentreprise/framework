<?php
// database/migrations/2025_11_19_000000_create_roles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nom_role', 100)->unique();
            $table->text('description')->nullable();
            $table->integer('niveau_hierarchie')->default(10)
                  ->comment('1=Administrateur, 2=Modérateur/Expert, 3=Contributeur/Éditeur/Traducteur, 4=Utilisateur/Guide, 5=Visiteur');
            $table->string('couleur', 20)->nullable()
                  ->comment('Couleur hexadécimale pour l\'affichage (#dc3545)');
            $table->boolean('est_systeme')->default(false)
                  ->comment('Rôle système non supprimable (true pour Administrateur, Modérateur, Contributeur, Utilisateur, Visiteur)');
            $table->boolean('est_actif')->default(true);
            $table->integer('ordre_affichage')->default(0);
            $table->json('permissions')->nullable()
                  ->comment('Permissions spécifiques au format JSON');
            $table->timestamps();
            $table->softDeletes();

            // Index pour optimiser les recherches
            $table->index(['est_actif', 'ordre_affichage']);
            $table->index('niveau_hierarchie');
            $table->index('est_systeme');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
