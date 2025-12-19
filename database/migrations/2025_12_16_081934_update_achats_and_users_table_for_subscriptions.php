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
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->decimal('solde', 10, 2)->default(0)->after('statut');
        });

        Schema::table('achats', function (Blueprint $table) {
            $table->unsignedBigInteger('id_contenu')->nullable()->change();
            $table->string('type')->default('contenu')->after('id_contenu'); // 'contenu', 'abonnement'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->dropColumn('solde');
        });

        Schema::table('achats', function (Blueprint $table) {
            // Attention: SQLite peut avoir du mal à revenir en arrière sur le "change"
            // sans perdre les valeurs NULL si elles existent.
            // On tente de remettre nullable(false) si possible.
            $table->unsignedBigInteger('id_contenu')->nullable(false)->change();
            $table->dropColumn('type');
        });
    }
};
