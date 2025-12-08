<?php
// database/migrations/2025_12_05_000002_create_achats_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achats', function (Blueprint $table) {
            $table->id();

            // Références
            $table->unsignedBigInteger('id_utilisateur');
            $table->unsignedBigInteger('id_contenu');

            // Informations transaction
            $table->string('reference')->unique()->comment('Référence unique de transaction');
            $table->string('feda_transaction_id')->nullable()->comment('ID transaction FedaPay');

            // Montants
            $table->decimal('montant', 10, 2)->comment('Montant total payé en FCFA');
            $table->decimal('montant_auteur', 10, 2)->comment('Part revenant à l\'auteur');
            $table->decimal('montant_plateforme', 10, 2)->comment('Commission plateforme');

            // Statut
            $table->enum('statut', ['en_attente', 'payé', 'échoué', 'remboursé'])
                  ->default('en_attente');

            // Dates
            $table->timestamp('date_achat')->useCurrent();
            $table->timestamp('date_remboursement')->nullable();

            // Métadonnées
            $table->json('metadata')->nullable()->comment('Données supplémentaires');

            // Clés étrangères
            $table->foreign('id_utilisateur')
                  ->references('id')
                  ->on('utilisateurs')
                  ->onDelete('cascade');

            $table->foreign('id_contenu')
                  ->references('id')
                  ->on('contenus')
                  ->onDelete('cascade');

            // Index
            $table->index(['id_utilisateur', 'statut']);
            $table->index(['id_contenu', 'statut']);
            $table->index('reference');
            $table->index('feda_transaction_id');
            $table->index('date_achat');

            // Un utilisateur ne peut acheter qu'une fois un contenu (accès à vie)
            $table->unique(['id_utilisateur', 'id_contenu']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achats');
    }
};
