<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\{Planning,Outil,User,Creneau,Rdv,Notification};
use \PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RdvConfirmationMail;

class PlanningController extends Controller
{
    private $queryName = "plannings";
    private $queryName2 = "rdvs";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $user = Auth::user();
            $str_json_plannings = json_encode($request->tab_plannings);
            $tab_plannings = json_decode($str_json_plannings, true);

            if (!empty($request->id))
            {
                $item = Planning::find($request->id);
            }
            foreach ($tab_plannings as $tab_planning) 
            {
                //Vérifier si un planning existe déjà pour ce médecin et ce jour
                // $existingPlanning = Planning::where('medecin_id', $user->medecin->id)
                $existingPlanning = Planning::where('medecin_id', $request->medecin_id)
                ->where('date_planning', $tab_planning['date_planning'])
                ->first();

                if ($existingPlanning) {
                    $errors = "Un planning pour la date du ".$existingPlanning->date_planning." existe déjà !";
                    break;
                }
            }

            if($user->role->id != 8) // 8 = Major
            {
                $errors = "Vous n'avez pas le profil Major pour creer un planning";
            }

            DB::beginTransaction();
            if (!isset($errors)) {
                foreach ($tab_plannings as $tab_planning) {
                    $planning = new Planning();
                    $planning->medecin_id = $request->medecin_id;
                    $planning->date_planning = $tab_planning['date_planning'];
                    $planning->heure_debut = $tab_planning['heure_debut'];
                    $planning->heure_fin = $tab_planning['heure_fin'];
                    $planning->save();
                
                    if ($planning->id) {
                        $id = $planning->id;
                        $heureDebutInitial = Carbon::parse($planning->heure_debut);
                        $heureFin = Carbon::parse($planning->heure_fin);
                        $dureeTotal = $heureDebutInitial->diffInMinutes($heureFin);
                
                        // Générer les créneaux pour les 6 prochains mois (chaque semaine)
                        for ($semaine = 0; $semaine < 26; $semaine++) {
                            $dateCreneau = Carbon::parse($planning->date_planning)->addWeeks($semaine);
                            $heureDebut = $heureDebutInitial->copy(); // Réinitialiser l'heure de début pour chaque jour
                
                            // Génération des créneaux toutes les 30 minutes pour cette date
                            for ($i = 0; $i < $dureeTotal; $i += 30) {
                                $creneau = new Creneau();
                                $creneau->planning_id = $planning->id;
                                $creneau->date = $dateCreneau->format('Y-m-d'); // Date du créneau
                                $creneau->heure_debut = $heureDebut->format('H:i');
                                $creneau->heure_fin = $heureDebut->addMinutes(30)->format('H:i');
                                $creneau->disponible = true; // Créneau libre par défaut
                                $creneau->save();
                            }
                        }
                    }
                }
                DB::commit();
                return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
            }
            if (isset($errors))
            {
                throw new \Exception('{"data": null, "errors": "'. $errors .'" }');
            }
        } catch (\Throwable $e) {
                DB::rollback();
                return $e->getMessage();
        }
    }


    public function contacter(Request $request)
    {
        $email = $request->email;
        $message = $request->message;
        $object = $request->objet;
        $nom_complet = $request->nom_complet;

        Mail::raw($message, function ($msg) use ($email, $object, $nom_complet) {
            $msg->to('secretaire.general.cg@chifaa.sn') // Destinataire final
                ->subject($object)
                ->replyTo($email, $nom_complet) // Permet de répondre à l'expéditeur
                ->from('secretaire.general.cg@chifaa.sn', 'CHIFAA'); // Expéditeur officiel
        });
    }

    public function prendreRdv(Request $request)
    {
        try {
            $user = Auth::user();
            $creneauId = $request->creneau_id;
            $telephone = $request->telephone;
            if ($telephone) {
                $user->telephone = $telephone;
                $user->save();
            }
            // Vérifier si le créneau est disponible
            $creneau = Creneau::where('id', $creneauId)->where('disponible', true)->first();

            if (!$creneau) {
                throw new \Exception('{"data": null, "errors": "Ce créneau n\'est plus disponible." }');
            }

            // Vérifier si l'utilisateur a déjà un rendez-vous confirmé
            if (Rdv::where('user_id', $user->id)->where('status', 'confirmé')->exists()) {
                throw new \Exception('{"data": null, "errors": "Vous avez déjà un rendez-vous actif." }');
            }

            // Vérifier si l'utilisateur a déjà un RDV le même jour
            $rdvExistant = Rdv::where('user_id', $user->id)
                ->whereHas('creneau', function ($query) use ($creneau) {
                    $query->whereDate('date', $creneau->date);
                })
                ->exists();

            if ($rdvExistant) {
                throw new \Exception('{"data": null, "errors": "Vous avez déjà un rendez-vous ce jour-là." }');
            }

            DB::beginTransaction();

            // Créer le RDV
            $rdv = Rdv::create([
                'user_id' => $user->id,
                'creneau_id' => $creneauId,
                'status' => 'confirme'
            ]);

            // Mettre à jour le créneau
            $creneau->update(['disponible' => false]);

            DB::commit();

            // Envoyer un mail de confirmation
            Mail::to($user->email)->send(new RdvConfirmationMail($user, $creneau));

            return Outil::redirectgraphql($this->queryName2, "id:{$rdv->id}", Outil::$queries[$this->queryName2]);

        } catch (\Throwable $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function prendreRdvCaisse(Request $request)
    {
        try 
        {
            $nom_complet = $request->nom_complet;
            $email =  strtolower(str_replace(' ', '', $nom_complet)).'@gmail.com';
            $user =  User::create([
                'name' => $nom_complet,
                'email' => $email,
                // 'telephone' => $fields['telephone'],
                'password' => bcrypt('passer123'),
                'role_id' => 9,
                'actif' => true,
            ]);
            // $user = Auth::user();
            $creneauId = $request->creneau_id;
            $telephone = $request->telephone;
            if ($telephone) {
                $user->telephone = $telephone;
                $user->save();
            }
            // Vérifier si le créneau est disponible
            $creneau = Creneau::where('id', $creneauId)->where('disponible', true)->first();

            if (!$creneau) {
                throw new \Exception('{"data": null, "errors": "Ce créneau n\'est plus disponible." }');
            }

            // Vérifier si l'utilisateur a déjà un rendez-vous confirmé
            if (Rdv::where('user_id', $user->id)->where('status', 'confirmé')->exists()) {
                throw new \Exception('{"data": null, "errors": "Vous avez déjà un rendez-vous actif." }');
            }

            // Vérifier si l'utilisateur a déjà un RDV le même jour
            $rdvExistant = Rdv::where('user_id', $user->id)
                ->whereHas('creneau', function ($query) use ($creneau) {
                    $query->whereDate('date', $creneau->date);
                })
                ->exists();

            if ($rdvExistant) {
                throw new \Exception('{"data": null, "errors": "C Patient a déjà un rendez-vous ce jour-là." }');
            }

            DB::beginTransaction();

            // Créer le RDV
            $rdv = Rdv::create([
                'user_id' => $user->id,
                'creneau_id' => $creneauId,
                'status' => 'confirme'
            ]);

            // Mettre à jour le créneau
            $creneau->update(['disponible' => false]);

            $creneau = Creneau::find($rdv->creneau_id);
            $medecin = $creneau->planning->medecin;

            Notification::create([
                'medecin_id' => $medecin->id,
                'creneau_id' => $creneau->id,
                'type' => 'rdv_nouveau', // cela peut etre un rdv annulee
                'message' => "Nouveau rendez-vous réservé pour le {$creneau->date} à {$creneau->heure_debut}.",
            ]);

            DB::commit();

            // Envoyer un mail de confirmation
            // Mail::to($user->email)->send(new RdvConfirmationMail($user, $creneau));

            return Outil::redirectgraphql($this->queryName2, "id:{$rdv->id}", Outil::$queries[$this->queryName2]);

        }catch (\Throwable $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


    public function annulerRdvSiteParId($id)
    {
        $user = Auth::user();
        $rdv = Rdv::where('id', $id)->where('user_id', $user->id)->first();

        if (!$rdv) {
            return response()->json(['message' => 'Rendez-vous introuvable.'], 404);
        }

        // Réactiver le créneau
        $rdv->creneau->update(['disponible' => true]);
        // Supprimer le RDV
        $rdv->delete();

        return response()->json(['message' => 'Rendez-vous annulé avec succès.'], 200);
    }

    public function annulerRdvCaisseParId($id)
    {
        try {
            $rdv = Rdv::find($id);

            if (!$rdv) {
                return response()->json(['message' => 'Rendez-vous introuvable.'], 404);
            }

            // Réactiver le créneau associé
            $rdv->creneau->update(['disponible' => true]);

            Notification::create([
                'medecin_id' => $rdv->creaneau->planning->medecin->id,
                'creneau_id' => $rdv->creneau->id,
                'type' => 'rdv_annule', // cela peut etre un nouveau rdv
                'message' => "Nouveau rendez-vous réservé pour le {$creneau->date} à {$creneau->heure_debut}.",
            ]);

            // Supprimer le rendez-vous
            $rdv->delete();

            return response()->json(['message' => 'Rendez-vous annulé avec succès.'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Erreur lors de l\'annulation du rendez-vous.', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function modifierPlanning(Request $request, $planningId)
    {
        try {
            DB::beginTransaction();

            $planning = Planning::find($planningId);

            if (!$planning) {
                throw new \Exception('{"data": null, "errors": "Planning introuvable." }');
            }
             // Vérifier si le planning doit être supprimé
             if ($request->has('supprimer') && $request->supprimer) {
                // Supprimer uniquement les créneaux qui ne sont pas liés à des rendez-vous
                Creneau::where('planning_id', $planningId)
                    ->whereDoesntHave('rdv') // Vérifie l'absence de rendez-vous
                    ->delete();
            
                // Vérifier s'il reste des créneaux liés à des rendez-vous
                $remainingCreneaux = Creneau::where('planning_id', $planningId)->exists();
            
                if ($remainingCreneaux) {
                    throw new \Exception('Impossible de supprimer le planning : certains créneaux sont liés à des rendez-vous.');
                }
            
                // Supprimer le planning
                $planning->delete();
            
                DB::commit();
            
                return response()->json(['message' => 'Planning et créneaux supprimés avec succès.']);
            }
            // Calculer l'écart de date entre l'ancienne et la nouvelle date
            $ancienneDate = Carbon::parse($planning->date_planning);
            $nouvelleDate = Carbon::parse($request->date_planning);
            $diffJours = $ancienneDate->diffInDays($nouvelleDate);

            // Mettre à jour le planning
            $planning->update([
                'date_planning' => $request->date_planning,
                'heure_debut' => $request->heure_debut,
                'heure_fin' => $request->heure_fin
            ]);

            // Supprimer les créneaux qui dépassent la nouvelle heure de fin et ne sont pas référencés dans rdvs
                $creneauxASupprimer = Creneau::where('planning_id', $planningId)
                ->where('heure_debut', '>=', $request->heure_fin)
                ->get();

            foreach ($creneauxASupprimer as $creneau) {
                if (!$creneau->rdv) {
                    $creneau->delete();
                }
            }

            // Générer de nouveaux créneaux si la nouvelle heure de fin est plus tard
            $heureDebutInitial = Carbon::parse($request->heure_debut);
            $heureFin = Carbon::parse($request->heure_fin);
            $dureeTotal = $heureDebutInitial->diffInMinutes($heureFin);

            // Mettre à jour les créneaux disponibles
            $creneauxDisponibles = Creneau::where('planning_id', $planningId)
                ->where('disponible', true) // Ne modifier que les créneaux libres
                ->get();

            foreach ($creneauxDisponibles as $creneau) {
                $ancienneDateCreneau = Carbon::parse($creneau->date);
                $nouvelleDateCreneau = $ancienneDateCreneau->copy()->addDays($diffJours);

                $creneau->update([
                    'date' => $nouvelleDateCreneau->format('Y-m-d')
                ]);
            }

            // Générer les créneaux pour la nouvelle plage horaire
            $heureDebut = $heureDebutInitial->copy(); // Réinitialiser l'heure de début

            // Génération des créneaux toutes les 30 minutes pour la nouvelle plage horaire
            for ($i = 0; $i < $dureeTotal; $i += 30) {
                $creneau = Creneau::firstOrNew([
                    'planning_id' => $planning->id,
                    'date' => $nouvelleDate->format('Y-m-d'),
                    'heure_debut' => $heureDebut->format('H:i')
                ]);

                if (!$creneau->exists) {
                    $creneau->heure_fin = $heureDebut->addMinutes(30)->format('H:i');
                    $creneau->disponible = true; // Créneau libre par défaut
                    $creneau->save();
                }

                $heureDebut->addMinutes(30);
            }

            DB::commit();

            return response()->json(['message' => 'Planning et créneaux mis à jour avec succès.']);

        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => 'Erreur lors de la modification du planning.', 'error' => $e->getMessage()], 500);
        }
    }
   


}
