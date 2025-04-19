<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Outil,Suivi,Notification};
use Illuminate\Support\Facades\DB;

class SuiviController extends Controller
{
    //
    private $queryName = "suivis";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $item = new Suivi();
            $notification = new Notification();
            if (!empty($request->id)) {
                $item = Suivi::find($request->id);
                $patient = Patient::find($request->patient_id);
                $dossier_id = $patient->dossier->id;
                $notification = Notification::where('dossier_id', $dossier_id)
                                            ->where('rdv', $request->rdv)
                                            ->first();
            }
            // if (empty($request->nom))
            // {
            //     $errors = "Renseignez le nom du module";
            // }
            DB::beginTransaction();
            $item->patient_id = $request->patient_id;
            $item->diagnostic = $request->diagnostic;
            $item->traitement = $request->traitement;
            $item->rdv = $request->rdv;

            if (!isset($errors)) 
            {
                $is_saved = $item->save();
                if ($is_saved) {
                    $notification->dossier_id = $item->patient->dossier->id;
                    $notification->rdv = $item->rdv;
                    $notification->lu = false;
                    $notification->save();
                    $id = $item->id;
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

    // public function updatenotif(Request $request)
    // {
    //     $str_json_notifs = json_encode($request->notifs);
    //     $type_notifs = json_decode($str_json_notifs, true);
    //     foreach ($type_notifs as $type_notif) 
    //     {
    //         $notifications = Notification::whereDate('rdv', '=',$type_notif['rdv']) // Inclure uniquement les rdv d'aujourd'hui
    //         ->get();
    //     foreach ($notifications as $notification) {
    //         // Mettre à jour le champ 'lu' à true
    //         $notification->lu = false;
    //         $notification->save();
    //     }
    //     }
    // }
}
