<?php
// database/seeders/Type_ContenusSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Type_ContenusSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'nom_contenu' => 'Contes et légendes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_contenu' => 'Recettes culinaires',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_contenu' => 'Histoire et traditions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_contenu' => 'Musiques et danses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_contenu' => 'Arts et artisanat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_contenu' => 'Proverbes et sagesse',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_contenu' => 'Langue et vocabulaire',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_contenu' => 'Géographie culturelle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_contenu' => 'Rites et cérémonies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_contenu' => 'Personnages historiques',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('type_contenus')->insert($types);

        $this->command->info('Types de contenus insérés avec succès!');
    }
}
