<?php
// database/seeders/LanguesSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguesSeeder extends Seeder
{
    public function run(): void
    {
        $langues = [
            [
                'nom_langue' => 'Fon',
                'code_langue' => 'fon',
                'description' => 'Langue parlée principalement dans le sud du Bénin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_langue' => 'Yoruba',
                'code_langue' => 'yor',
                'description' => 'Langue parlée dans le sud-est du Bénin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_langue' => 'Dendi',
                'code_langue' => 'ddn',
                'description' => 'Langue parlée dans le nord du Bénin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_langue' => 'Bariba',
                'code_langue' => 'bba',
                'description' => 'Langue parlée dans le nord-est du Bénin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_langue' => 'Goun',
                'code_langue' => 'guw',
                'description' => 'Langue parlée dans le département de l\'Ouémé',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_langue' => 'Adja',
                'code_langue' => 'ajg',
                'description' => 'Langue parlée dans le sud-ouest',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_langue' => 'Français',
                'code_langue' => 'fr',
                'description' => 'Langue officielle du Bénin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_langue' => 'Anglais',
                'code_langue' => 'en',
                'description' => 'Langue internationale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('langues')->insert($langues);

        $this->command->info('Langues insérées avec succès!');
    }
}
