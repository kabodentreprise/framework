<?php
// database/seeders/AdminUserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifier si l'admin existe déjà
        $adminExists = DB::table('utilisateurs')
            ->where('email', 'maurice.comlan@uac.bj')
            ->exists();

        if (!$adminExists) {
            DB::table('utilisateurs')->insert([
                'nom' => 'Comlan',
                'prenom' => 'Maurice',
                'email' => 'maurice.comlan@uac.bj',
                'mot_de_passe' => Hash::make('Eneam123'),
                'sexe' => 'M',
                'date_naissance' => '1990-01-01',
                'date_inscription' => now(),
                'statut' => 'actif',
                'photo' => null,
                'id_role' => 1, // Administrateur
                'id_langue' => 7, // Français
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info('Utilisateur admin créé avec succès!');
            $this->command->info('Email: maurice.comlan@uac.bj');
            $this->command->info('Mot de passe: Eneam123');
        } else {
            $this->command->info('L\'utilisateur admin existe déjà.');
        }
    }
}
