<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medecin;
use Illuminate\Support\Facades\Hash;

class MedecinsUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les médecins existants
        // $medecins = Medecin::all();
        // $email = 'DrTest@gmail.com';
        // foreach ($medecins as $medecin) {
        //     // Générer l'email basé sur nom + prénom
        //     // $email = strtolower($medecin->nom . $medecin->prenom) . '@gmail.com';
        //     $email = preg_replace('/dr|\s|\d/', '', $email) . '@gmail.com';
        //     // Vérifier si l'utilisateur existe déjà pour éviter les doublons
        //     // if (!User::where('email', $email)->exists()) {
        //     //     User::create([
        //     //         'name' => $medecin->nom . ' ' . $medecin->prenom,
        //     //         'email' => $email,
        //     //         'password' => Hash::make('passer123'),
        //     //         'role_id' => 4,
        //     //     ]);
        //     // }
        //     // $medecin->user_id = User::where('email', $email)->first()->id;
        //     $
        //     $medecin->save();
        // }

        // Récupérer tous les utilisateurs existants
        $users = User::all();

        foreach ($users as $user) {
            // Convertir en minuscule
            $email = strtolower($user->email);
            
            // Supprimer toutes les répétitions de "@gmail.com" et ne garder qu'une seule
            // $email = preg_replace('/(@gmail\.com)+/', '', $email) . '@gmail.com';
            // Supprimer "dr", les espaces et les chiffres
            $email = preg_replace('/dr|\s|\d/', '', $email);
            // Mettre à jour l'email de l'utilisateur
            $user->email = $email;
            $user->save();
        }
    }
}
