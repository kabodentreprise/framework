<?php
// database/seeders/RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. D'abord, assurez-vous que votre table 'roles' a les bonnes colonnes
        // Ajoutez ces colonnes via une migration si nécessaire:
        // php artisan make:migration add_description_to_roles_table --table=roles

        $roles = [
            // === RÔLES PRINCIPAUX DU CAHIER DES CHARGES ===

            // 1. ADMINISTRATEUR (Cahier: "gestion technique, utilisateurs et validation finale")
            [
                'nom_role' => 'Administrateur',
                'description' => 'Gestion technique complète, administration des utilisateurs et validation finale des contenus',
                'niveau_hierarchie' => 1, // Plus haut niveau
                'couleur' => '#dc3545', // Rouge
                'est_systeme' => true, // Rôle système non supprimable
                'ordre_affichage' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 2. MODÉRATEUR (Cahier: "vérification et validation des contributions")
            [
                'nom_role' => 'Modérateur',
                'description' => 'Vérification, validation et modération des contributions des utilisateurs',
                'niveau_hierarchie' => 2,
                'couleur' => '#fd7e14', // Orange
                'est_systeme' => true,
                'ordre_affichage' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 3. CONTRIBUTEUR (Cahier: "création de contenus et proposition de traductions")
            // C'est l'AUTEUR dans votre MLD (table contenus.id_auteur)
            [
                'nom_role' => 'Contributeur',
                'description' => 'Création de contenus culturels (contes, recettes, articles) et proposition de traductions',
                'niveau_hierarchie' => 3,
                'couleur' => '#198754', // Vert
                'est_systeme' => true,
                'ordre_affichage' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 4. UTILISATEUR (équivalent à "Lecteur" dans le cahier)
            // Cahier: "consultation, partage et interaction (commentaires, favoris)"
            [
                'nom_role' => 'Utilisateur',
                'description' => 'Consultation des contenus, commentaires, partage et ajout aux favoris',
                'niveau_hierarchie' => 4,
                'couleur' => '#0d6efd', // Bleu
                'est_systeme' => true,
                'ordre_affichage' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // === RÔLES SPÉCIALISÉS (optionnels) ===

            // 5. ÉDITEUR (amélioration des contenus existants)
            [
                'nom_role' => 'Éditeur',
                'description' => 'Édition et amélioration des contenus existants, organisation thématique',
                'niveau_hierarchie' => 3,
                'couleur' => '#ffc107', // Jaune
                'est_systeme' => false,
                'ordre_affichage' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 6. EXPERT CULTUREL (validation scientifique)
            [
                'nom_role' => 'Expert Culturel',
                'description' => 'Validation scientifique et culturelle des contenus, expertise des traditions',
                'niveau_hierarchie' => 2,
                'couleur' => '#6f42c1', // Violet
                'est_systeme' => false,
                'ordre_affichage' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 7. TRADUCTEUR (spécialiste traduction)
            [
                'nom_role' => 'Traducteur',
                'description' => 'Traduction professionnelle entre langues nationales béninoises',
                'niveau_hierarchie' => 3,
                'couleur' => '#20c997', // Turquoise
                'est_systeme' => false,
                'ordre_affichage' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 8. ANIMATEUR (animation communauté)
            [
                'nom_role' => 'Animateur',
                'description' => 'Animation de la communauté, organisation des débats et événements',
                'niveau_hierarchie' => 3,
                'couleur' => '#e83e8c', // Rose
                'est_systeme' => false,
                'ordre_affichage' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 9. GUIDE (accompagnement)
            [
                'nom_role' => 'Guide',
                'description' => 'Accompagnement des nouveaux utilisateurs, aide à la navigation',
                'niveau_hierarchie' => 4,
                'couleur' => '#795548', // Marron
                'est_systeme' => false,
                'ordre_affichage' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 10. VISITEUR (accès limité - non connecté)
            [
                'nom_role' => 'Visiteur',
                'description' => 'Accès en consultation seule sans authentification',
                'niveau_hierarchie' => 5,
                'couleur' => '#6c757d', // Gris
                'est_systeme' => true,
                'ordre_affichage' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('roles')->insert($roles);

        $this->command->info('✅ 10 rôles insérés avec succès !');
        $this->command->info('');
        $this->command->info('📋 RÔLES PRINCIPAUX (cahier des charges):');
        $this->command->info('   1. Administrateur - Gestion technique et validation finale');
        $this->command->info('   2. Modérateur - Vérification des contributions');
        $this->command->info('   3. Contributeur - Création de contenus (Auteur)');
        $this->command->info('   4. Utilisateur - Consultation et interaction (Lecteur)');
        $this->command->info('');
        $this->command->info('🎭 RÔLES SPÉCIALISÉS:');
        $this->command->info('   5. Éditeur - 6. Expert Culturel - 7. Traducteur');
        $this->command->info('   8. Animateur - 9. Guide - 10. Visiteur');
    }
}
