<?php
// database/migrations/2025_11_20_000001_create_contenus_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contenus', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 255);
            $table->text('texte');
            $table->text('excerpt')->nullable()->comment('Résumé court pour les aperçus');
            $table->string('slug')->unique()->comment('URL SEO-friendly');

            // Statut du contenu
            $table->enum('statut', ['brouillon', 'en_attente', 'publié', 'rejeté'])->default('brouillon');
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamp('date_validation')->nullable();
            $table->timestamp('published_at')->nullable()->comment('Date de publication publique');

            // Type et catégorisation
            $table->unsignedBigInteger('id_type_contenu');
            $table->unsignedBigInteger('id_auteur');
            $table->unsignedBigInteger('id_moderateur')->nullable();

            // Géographie et langue
            $table->unsignedBigInteger('id_region');
            $table->unsignedBigInteger('id_langue');

            // Traductions et versions
            $table->unsignedBigInteger('parent_id')->nullable()->comment('Pour les traductions');
            $table->integer('version')->default(1);

            // ===== NOUVEAUX CHAMPS POUR CONTENUS PAYANTS =====
            // Système payant/gratuit
            $table->enum('type_acces', ['gratuit', 'payant'])->default('gratuit')
                  ->comment('gratuit = accessible à tous, payant = nécessite achat');

            $table->decimal('prix', 10, 2)->nullable()
                  ->comment('Prix en FCFA si payant, NULL si gratuit');

            $table->decimal('pourcentage_auteur', 5, 2)->default(70.00)
                  ->comment('Pourcentage du prix qui revient à l\'auteur (70% par défaut)');

            $table->text('extrait_gratuit')->nullable()
                  ->comment('Extrait visible gratuitement pour les contenus payants');

            // Statistiques
            $table->integer('vues_count')->default(0);
            $table->integer('achats_count')->default(0)->comment('Nombre d\'achats si payant');
            $table->decimal('revenu_total', 15, 2)->default(0.00)->comment('Revenu généré si payant');

            // Métadonnées
            $table->json('mots_cles')->nullable();
            $table->json('metadata')->nullable()->comment('Données supplémentaires');

            // Soft delete et timestamps
            $table->softDeletes();
            $table->timestamps();

            // ===== CONTRAINTES =====
            // Contrainte pour éviter les références circulaires
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('contenus')
                  ->onDelete('set null');

            // Région
            $table->foreign('id_region')
                  ->references('id')
                  ->on('regions')
                  ->onDelete('restrict');

            // Langue
            $table->foreign('id_langue')
                  ->references('id')
                  ->on('langues')
                  ->onDelete('restrict');

            // Modérateur
            $table->foreign('id_moderateur')
                  ->references('id')
                  ->on('utilisateurs')
                  ->onDelete('set null');

            // Type de contenu
            $table->foreign('id_type_contenu')
                  ->references('id')
                  ->on('type_contenus')
                  ->onDelete('restrict');

            // Auteur
            $table->foreign('id_auteur')
                  ->references('id')
                  ->on('utilisateurs')
                  ->onDelete('restrict');

            // ===== INDEX POUR PERFORMANCES =====
            // Recherche par statut et date
            $table->index(['statut', 'published_at']);

            // Recherche par auteur
            $table->index(['id_auteur', 'statut']);

            // Recherche par région et langue
            $table->index(['id_region', 'id_langue', 'statut']);

            // Recherche par type de contenu
            $table->index(['id_type_contenu', 'statut']);

            // Recherche par type d'accès (gratuit/payant)
            $table->index(['type_acces', 'statut']);

            // Recherche par prix
            $table->index(['type_acces', 'prix']);

            // Full-text search
            $table->fullText(['titre', 'texte', 'excerpt']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contenus');
    }
};
