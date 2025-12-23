<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Roles;
use App\Models\Langues;
use App\Models\Regions;
use App\Models\TypeContenus;
use App\Models\TypeMedias;

class ReferenceTablesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Rôles
        $roles = [
            ['nom_role' => 'Administrateur', 'niveau_hierarchie' => 1, 'est_systeme' => true],
            ['nom_role' => 'Modérateur', 'niveau_hierarchie' => 2, 'est_systeme' => true],
            ['nom_role' => 'Contributeur', 'niveau_hierarchie' => 3, 'est_systeme' => true],
            ['nom_role' => 'Utilisateur', 'niveau_hierarchie' => 4, 'est_systeme' => true],
        ];
        foreach ($roles as $role) {
            Roles::firstOrCreate(['nom_role' => $role['nom_role']], $role);
        }

        // 2. Langues
        $langues = [
            ['nom_langue' => 'Français', 'code_langue' => 'fr'],
            ['nom_langue' => 'Anglais', 'code_langue' => 'en'],
            ['nom_langue' => 'Fon', 'code_langue' => 'fon'],
            ['nom_langue' => 'Yoruba', 'code_langue' => 'yo'],
        ];
        foreach ($langues as $langue) {
            Langues::firstOrCreate(['code_langue' => $langue['code_langue']], $langue);
        }

        // 3. Régions (Requis pour Contenus)
        $regions = [
            ['nom_region' => 'Littoral', 'population' => 701137, 'superficie' => 79, 'localisation' => 'Sud'],
            ['nom_region' => 'Atlantique', 'population' => 1398229, 'superficie' => 3233, 'localisation' => 'Sud'],
            ['nom_region' => 'Ouémé', 'population' => 1100404, 'superficie' => 1281, 'localisation' => 'Sud-Est'],
        ];
        foreach ($regions as $region) {
            Regions::firstOrCreate(['nom_region' => $region['nom_region']], $region);
        }

        // 4. Types de Contenus
        $typesContenus = [
            ['nom_contenu' => 'Article'],
            ['nom_contenu' => 'Vidéo'],
            ['nom_contenu' => 'Podcast'],
            ['nom_contenu' => 'Galerie'],
        ];
        foreach ($typesContenus as $type) {
            TypeContenus::firstOrCreate(['nom_contenu' => $type['nom_contenu']], $type);
        }

        // 5. Types de Médias
        $typesMedias = [
            ['nom_media' => 'Image'],
            ['nom_media' => 'Vidéo'],
            ['nom_media' => 'Audio'],
            ['nom_media' => 'Document'],
        ];
        foreach ($typesMedias as $type) {
            TypeMedias::firstOrCreate(['nom_media' => $type['nom_media']], $type);
        }
    }
}
