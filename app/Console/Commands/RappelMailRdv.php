<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Planning, Creneau};
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RdvRappelMail;

class RappelMailRdv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rappel:mail-rdv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Récupérer les créneaux qui ont un rendez-vous dans les 24 prochaines heures
        $creneaux = Creneau::whereHas('rdv', function ($query) {
            $query->where('date', '>=', now())
                  ->where('date', '<=', now()->addHours(24));
        })->get();

        // $creneaux = Creneau::whereHas('rdv', function ($query) {
        //             $query->where('user_id', '=', 154);
        //  })->get();

        // Pour chaque créneau, envoyer un email de rappel pour le rendez-vous associé
        foreach ($creneaux as $creneau) {
            $rdv = $creneau->rdv;
            if ($rdv) {
                // Logique d'envoi d'email ici
                // Par exemple : Mail::to($rdv->user->email)->send(new RappelMail($rdv));
                // Envoyer un mail de confirmation
                Mail::to($rdv->user->email)->send(new RdvRappelMail($rdv->user, $creneau));
                $this->info("Rappel envoyé pour le rendez-vous ID: {$rdv->id}");
            }
        }

        $this->info('Tous les rappels ont été envoyés avec succès.');
        return 0;
    }
}
