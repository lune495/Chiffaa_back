<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{BulletinAnalyse, PatientMedical, ElementBulletinAnalyse, Outil};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BulletinAnalyseController extends Controller
{
    private $queryName = "bulletin_analyses";

    public function save(Request $request)
    {
        try 
        {
            $errors = null;
            $user = Auth::user();

            if ($user->role->nom !== 'MEDECIN') 
            {
                $errors = "Vous n'êtes pas autorisé à effectuer cette action";
            }

            $patient = PatientMedical::find($request->patient_medical_id);
            if (!$patient) {
                $errors = "Patient introuvable";
            }

            if (!isset($request->type_services) || !is_array($request->type_services)) {
                $errors = "Le champ type_service_id doit être un tableau";
            }

            if (!isset($errors)) 
            {
                DB::beginTransaction(); 
                $item = new BulletinAnalyse();
                $item->patient_medical_id = $request->patient_medical_id;
                $item->user_id = $user->id;
                $item->diagnostic = $request->diagnostic;
                $item->save();
                foreach ($request->type_services as $serviceId)
                {
                    $item2 = new ElementBulletinAnalyse();
                    $item2->type_service_id = $serviceId;
                    $item2->bulletin_analyse_id = $item->id;
                    $item2->save();
                }

                DB::commit();
                $id = $item->id;
                return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
            }
            throw new \Exception('{"data": null, "errors": "' . $errors . '" }');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function generateBulletinAnalyse($id)
    {
        try 
        {
            $bulletin = BulletinAnalyse::find($id);
            if (!$bulletin) {
                return response()->json(['error' => 'Bulletin introuvable'], 404);
            }

            $pdf = \PDF::loadView('bulletin_analyse', ['bulletin' => $bulletin]);
            return $pdf->stream('bulletin_analyse.pdf');
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erreur lors de la génération du PDF'], 500);
        }
    }
}
