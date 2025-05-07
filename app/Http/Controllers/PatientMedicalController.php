<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Outil,PatientMedical};
use Illuminate\Support\Facades\DB;

class PatientMedicalController extends Controller
{
    //
    private $queryName = "patient_medicals";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $patient = new PatientMedical();
            if (!empty($request->id))
            {
                $patient = PatientMedical::find($request->id);
            }
            if (empty($request->nom_complet))
            {
                $errors = "Renseignez le nom";
            }
            DB::beginTransaction();
            $patient->nom_complet = $request->nom_complet;
            $patient->adresse = $request->adresse;
            $patient->telephone = $request->telephone;
            $patient->date_naissance = $request->date_naissance;
            $patient->save();
            $montant = 0;
            if (!isset($errors)) 
            {
                $patient->save();
                $id = $patient->id;
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
}
