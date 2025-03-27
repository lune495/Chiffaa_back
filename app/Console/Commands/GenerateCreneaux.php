<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Planning,Creneau};
use Carbon\Carbon;

class GenerateCreneaux extends Command
{
    protected $signature = 'generate:creneaux';
    protected $description = 'Génère les créneaux pour les 6 prochains mois et supprime ceux trop anciens';

    public function handle()
    {
        $this->info('Début de la génération des créneaux...');

        // 1️⃣ Supprimer les créneaux trop anciens (plus de 6 mois)
        $dateLimite = Carbon::now()->subMonths(6);
        Creneaux::where('date', '<', $dateLimite)->delete();
        $this->info("Créneaux supprimés avant la date : " . $dateLimite->toDateString());

        // 2️⃣ Récupérer tous les plannings actifs
        $plannings = Planning::all();

        foreach ($plannings as $planning) {
            $heureDebutInitial = Carbon::parse($planning->heure_debut);
            $heureFin = Carbon::parse($planning->heure_fin);
            $dureeTotal = $heureDebutInitial->diffInMinutes($heureFin);

            // 3️⃣ Générer les créneaux manquants pour les 6 prochains mois
            for ($semaine = 0; $semaine < 26; $semaine++) { 
                $dateCreneau = Carbon::parse($planning->date_planning)->addWeeks($semaine);
                
                // Vérifier si des créneaux existent déjà pour cette date
                if (Creneaux::where('planning_id', $planning->id)->where('date', $dateCreneau->toDateString())->exists()) {
                    continue; // Sauter la création si déjà existant
                }

                $heureDebut = $heureDebutInitial->copy(); // Réinitialiser l'heure de début

                // Génération des créneaux toutes les 30 minutes
                for ($i = 0; $i < $dureeTotal; $i += 30) {
                    Creneaux::create([
                        'planning_id' => $planning->id,
                        'date' => $dateCreneau->toDateString(),
                        'heure_debut' => $heureDebut->format('H:i'),
                        'heure_fin' => $heureDebut->addMinutes(30)->format('H:i'),
                        'disponible' => true
                    ]);
                }
            }
        }

        $this->info('Créneaux générés avec succès pour les 6 prochains mois !');
    }
}