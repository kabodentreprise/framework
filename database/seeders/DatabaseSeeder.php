<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            Type_contenusSeeder::class,
            Type_mediasSeeder::class,
            RegionsSeeder::class,
            LanguesSeeder::class,
            AdminSeeder::class,
            // UtilisateursSeeder::class, // Décommenter si nécessaire
            // ContenusSeeder::class,     // Décommenter si nécessaire
            // MediasSeeder::class,       // Décommenter si nécessaire
        ]);
    }
}
