<?php
// database/seeders/RegionsSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            [
                'nom_region' => 'Atacora',
                'description' => 'Région montagneuse au nord-ouest du Bénin',
                'population' => 772000,
                'superficie' => 20499,
                'localisation' => json_encode(['latitude' => 10.3, 'longitude' => 1.38]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Donga',
                'description' => 'Région au nord du Bénin',
                'population' => 543000,
                'superficie' => 11126,
                'localisation' => json_encode(['latitude' => 9.72, 'longitude' => 1.68]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Borgou',
                'description' => 'Grande région au nord-est',
                'population' => 1203000,
                'superficie' => 25856,
                'localisation' => json_encode(['latitude' => 9.34, 'longitude' => 2.63]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Alibori',
                'description' => 'Région la plus septentrionale',
                'population' => 868000,
                'superficie' => 26242,
                'localisation' => json_encode(['latitude' => 11.13, 'longitude' => 2.94]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Zou',
                'description' => 'Région du centre',
                'population' => 851000,
                'superficie' => 5243,
                'localisation' => json_encode(['latitude' => 7.35, 'longitude' => 2.07]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Collines',
                'description' => 'Région vallonnée du centre',
                'population' => 717000,
                'superficie' => 13931,
                'localisation' => json_encode(['latitude' => 8.0, 'longitude' => 2.25]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Plateau',
                'description' => 'Petite région au sud-est',
                'population' => 622000,
                'superficie' => 3264,
                'localisation' => json_encode(['latitude' => 7.07, 'longitude' => 2.51]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Ouémé',
                'description' => 'Région côtière sud-est',
                'population' => 1120000,
                'superficie' => 1281,
                'localisation' => json_encode(['latitude' => 6.5, 'longitude' => 2.6]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Atlantique',
                'description' => 'Région côtière',
                'population' => 1407000,
                'superficie' => 3233,
                'localisation' => json_encode(['latitude' => 6.67, 'longitude' => 2.15]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Littoral',
                'description' => 'Plus petite région incluant Cotonou',
                'population' => 679000,
                'superficie' => 79,
                'localisation' => json_encode(['latitude' => 6.37, 'longitude' => 2.43]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Mono',
                'description' => 'Région côtière sud-ouest',
                'population' => 495000,
                'superficie' => 1605,
                'localisation' => json_encode(['latitude' => 6.65, 'longitude' => 1.72]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Couffo',
                'description' => 'Région du sud-ouest',
                'population' => 741000,
                'superficie' => 2404,
                'localisation' => json_encode(['latitude' => 7.0, 'longitude' => 1.8]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('regions')->insert($regions);

        $this->command->info('Régions insérées avec succès!');
    }
}
