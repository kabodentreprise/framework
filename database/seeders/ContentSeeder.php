<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Contenus;
use App\Models\TypeContenus;
use App\Models\Medias;
use App\Models\TypeMedias;
use App\Models\Utilisateurs;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure Types exist
        $types = [
            'Article' => 'Article',
            'Vidéo' => 'Vidéo', // Using Accents to match likely existing data or creating new
            'Livre' => 'Livre',
            'Audio' => 'Audio',
        ];

        foreach ($types as $key => $val) {
            TypeContenus::firstOrCreate(['nom_contenu' => $val]);
        }

        // 2. Ensure Media Types exist
        $mediaTypes = [
            'Image' => 'Image',
            'Vidéo MP4' => 'Vidéo', // Simplified to 'Vidéo' if that matches typical naming, or keep specific if table allows text
            'PDF' => 'Document', 
        ];
        // Correction: Let's assume standard names "Image", "Vidéo", "Document" based on usage
        
        $mtImage = TypeMedias::firstOrCreate(['nom_media' => 'Image']);
        $mtVideo = TypeMedias::firstOrCreate(['nom_media' => 'Vidéo']);
        $mtDoc   = TypeMedias::firstOrCreate(['nom_media' => 'Document']);

        // 3. Get specific author "Maurice Comlan"
        $author = Utilisateurs::where('nom', 'Comlan')
                    ->where('prenom', 'Maurice')
                    ->first();
        
        if (!$author) {
            // Fallback: Try with reversed names or just pick the first admin
             $author = Utilisateurs::first(); 
        }

        // Fetch valid Region and Language for NOT NULL constraints
        $region = \App\Models\Regions::first();
        if (!$region) {
            // Create a default if none exists, though typically seeded
            $region = \App\Models\Regions::create([
                'nom_region' => 'Atlantique',
                'description' => 'Région cotère', 
                // Adapt fields based on Regions model if known, assuming basics
            ]);
        }

        $langue = \App\Models\Langues::first();
        if (!$langue) {
            $langue = \App\Models\Langues::create([
                'nom_langue' => 'Fon',
                'code_iso' => 'fon',
            ]);
        }

        // 4. Create FREE Content
        $freeContents = [
            [
                'titre' => 'Découverte du Vaudou',
                'description' => 'Une introduction complète aux traditions vaudou du Bénin.',
                'type' => 'Article',
                'media_type' => 'Image',
            ],
            [
                'titre' => 'Les Rythmes du Nord',
                'description' => 'Exploration musicale des régions septentrionales.',
                'type' => 'Audio',
                'media_type' => 'Image', 
            ],
            [
                'titre' => 'Cuisine Béninoise : La Sauce Graine',
                'description' => 'Recette traditionnelle expliquée pas à pas.',
                'type' => 'Vidéo',
                'media_type' => 'Vidéo',
            ],
            [
                'titre' => 'Histoire d’Abomey',
                'description' => 'Récit historique sur le royaume de Danxomè.',
                'type' => 'Article',
                'media_type' => 'Image',
            ],
            [
                'titre' => 'Guide Touristique : Ouidah',
                'description' => 'Les incontournables à visiter à Ouidah.',
                'type' => 'Article',
                'media_type' => 'Image',
            ],
        ];

        foreach ($freeContents as $content) {
            $typeObj = TypeContenus::where('nom_contenu', $content['type'])->firstOrCreate(['nom_contenu' => $content['type']]);
            
            $c = Contenus::create([
                'titre' => $content['titre'],
                'slug' => Str::slug($content['titre']) . '-' . rand(100,999),
                'texte' => $content['description'] . " Ceci est un contenu gratuit accessible à tous. Lorem ipsum dolor sit amet...",
                'excerpt' => $content['description'],
                'statut' => 'publié',
                'date_creation' => now(),
                'published_at' => now(),
                'id_type_contenu' => $typeObj->id,
                'id_auteur' => $author->id,
                'id_region' => $region->id, // Fixed NOT NULL
                'id_langue' => $langue->id, // Fixed likely NOT NULL
                'type_acces' => 'gratuit',
                'prix' => 0,
                'vues_count' => rand(100, 5000),
            ]);

            // Determine Media Type ID
            $mediaTypeId = $mtImage->id;
            if ($content['media_type'] === 'Vidéo') $mediaTypeId = $mtVideo->id;
            if ($content['media_type'] === 'Document') $mediaTypeId = $mtDoc->id;


            Medias::create([
                'description' => 'Média pour ' . $content['titre'],
                'chemin' => 'https://via.placeholder.com/600x400?text=' . str_replace(' ', '+', $content['titre']),
                // 'type' removed, 'id_utilisateur' removed, 'statut' removed
                'id_type_media' => $mediaTypeId,
                'id_contenu' => $c->id,
            ]);
        }

        // 5. Create PREMIUM (Paid) Content
        $premiumContents = [
            [
                'titre' => 'Masterclass : Danses Traditionnelles',
                'description' => 'Formation vidéo complète de 2h sur les danses sacrées.',
                'type' => 'Vidéo',
                'prix' => 15000,
            ],
            [
                'titre' => 'Dictionnaire Fon-Français (PDF)',
                'description' => 'Version numérique complète du dictionnaire de référence.',
                'type' => 'Livre',
                'prix' => 5000,
            ],
            [
                'titre' => 'Reportage Exclusif : Les Rois du Bénin',
                'description' => 'Documentaire inédit sur la royauté actuelle.',
                'type' => 'Vidéo',
                'prix' => 2000,
            ],
            [
                'titre' => 'Album : Échos des Collines',
                'description' => 'Album musical MP3 haute qualité.',
                'type' => 'Audio',
                'prix' => 3000,
            ],
             [
                'titre' => 'Cours de Langue : Niveau Avancé',
                'description' => 'Série de 10 leçons pour maîtriser les subtilités de la langue.',
                'type' => 'Article',
                'prix' => 10000,
            ],
        ];

        foreach ($premiumContents as $content) {
            $typeObj = TypeContenus::where('nom_contenu', $content['type'])->firstOrCreate(['nom_contenu' => $content['type']]);

            $c = Contenus::create([
                'titre' => $content['titre'],
                'slug' => Str::slug($content['titre']) . '-' . rand(100,999), 
                'texte' => $content['description'] . " CONTENU BLOQUÉ. Ce contenu est payant...",
                'excerpt' => $content['description'],
                'extrait_gratuit' => $content['description'] . " (Extrait gratuit visible par tous)",
                'statut' => 'publié',
                'date_creation' => now(),
                'published_at' => now(),
                'id_type_contenu' => $typeObj->id,
                'id_auteur' => $author->id,
                'id_region' => $region->id, // Fixed NOT NULL
                'id_langue' => $langue->id, // Fixed likely NOT NULL
                'type_acces' => 'payant',
                'prix' => $content['prix'],
                'pourcentage_auteur' => 70,
                'vues_count' => rand(50, 1000),
                'achats_count' => rand(0, 50),
            ]);

             Medias::create([
                'description' => 'Preview ' . $content['titre'],
                'chemin' => 'https://via.placeholder.com/600x400?text=PREMIUM+' . str_replace(' ', '+', $content['titre']),
                // Removed invalid cols
                'id_type_media' => $mtImage->id,
                'id_contenu' => $c->id,
            ]);
        }
    }
}
