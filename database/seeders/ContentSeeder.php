<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateurs;
use App\Models\Contenus;
use App\Models\Medias;
use App\Models\Roles;
use App\Models\Langues;
use App\Models\Regions;
use App\Models\TypeContenus;
use App\Models\TypeMedias;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Récupération des IDs nécessaires
        $roleAdmin = Roles::where('nom_role', 'Administrateur')->first()->id;
        $roleUser = Roles::where('nom_role', 'Utilisateur')->first()->id;
        $langueFr = Langues::where('code_langue', 'fr')->first()->id;
        $region = Regions::first()->id;
        $typeArticle = TypeContenus::where('nom_contenu', 'Article')->first()->id;
        $typeImage = TypeMedias::where('nom_media', 'Image')->first()->id;

        // 1. Création Admin
        $admin = Utilisateurs::firstOrCreate(
            ['email' => 'admin@culture.bj'],
            [
                'nom' => 'Administrateur',
                'prenom' => 'Système',
                'mot_de_passe' => Hash::make('password'),
                'sexe' => 'M',
                'date_naissance' => '1990-01-01',
                'id_role' => $roleAdmin,
                'id_langue' => $langueFr,
                'statut' => 'actif'
            ]
        );

        // 2. Création Utilisateur Standard
        $user = Utilisateurs::firstOrCreate(
            ['email' => 'user@culture.bj'],
            [
                'nom' => 'Utilisateur',
                'prenom' => 'Test',
                'mot_de_passe' => Hash::make('password'),
                'sexe' => 'F',
                'date_naissance' => '1995-05-15',
                'id_role' => $roleUser,
                'id_langue' => $langueFr,
                'statut' => 'actif'
            ]
        );

        // 3. Création Contenu (Article Gratuit)
        $article = Contenus::create([
            'titre' => 'Découverte de la Culture Béninoise',
            'texte' => 'Le Bénin regorge de richesses culturelles inestimables...',
            'excerpt' => 'Une introduction aux merveilles du Bénin.',
            'slug' => Str::slug('Decouverte Culture Beninoise ' . uniqid()),
            'statut' => 'publié',
            'id_type_contenu' => $typeArticle,
            'id_auteur' => $admin->id,
            'id_region' => $region,
            'id_langue' => $langueFr,
            'type_acces' => 'gratuit',
            'published_at' => now(),
        ]);

        // 4. Média associé
        Medias::create([
            'chemin' => 'https://via.placeholder.com/800x600.png?text=Culture+Benin', // Placeholder valide
            'description' => 'Image illustrative',
            'id_contenu' => $article->id,
            'id_type_media' => $typeImage,
        ]);

        // 5. Contenu Payant (Exemple)
        Contenus::create([
            'titre' => 'Guide Secret des Voduns (Premium)',
            'texte' => 'Contenu exclusif réservé aux abonnés...',
            'excerpt' => 'Les secrets les mieux gardés.',
            'slug' => Str::slug('Guide Secret Voduns ' . uniqid()),
            'statut' => 'publié',
            'id_type_contenu' => $typeArticle,
            'id_auteur' => $admin->id,
            'id_region' => $region,
            'id_langue' => $langueFr,
            'type_acces' => 'payant',
            'prix' => 5000.00,
            'extrait_gratuit' => 'Voici un aperçu gratuit de ce guide incroyable...',
            'published_at' => now(),
        ]);
    }
}
