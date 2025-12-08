<?php
// database/seeders/Type_MediasSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Type_MediasSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'nom_media' => 'Image',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_media' => 'Audio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_media' => 'Vidéo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_media' => 'Document PDF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_media' => 'Présentation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('type_medias')->insert($types);

        $this->command->info('Types de médias insérés avec succès!');
    }
}
