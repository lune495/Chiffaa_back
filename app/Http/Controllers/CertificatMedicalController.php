<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{CertificatMedical, PatientMedical, Log,Medecin,Outil};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificatMedicalController extends Controller
{
    private $queryName = "certificats";

    public function save(Request $request)
    {
        try 
        {
            $errors = null;
            $item = new CertificatMedical();
            $log = new Log();
            $user = Auth::user();

            if (!empty($request->id)) {
                $item = CertificatMedical::find($request->id);
            }

            DB::beginTransaction();

            if($user->role->nom !== 'MEDECIN') {
                $errors = "Vous n'êtes pas autorisé à effectuer cette action";
            }

            $patient = PatientMedical::find($request->patient_medical_id);

            if(!$patient)
            {
                $errors = "Patient Introuvable";
            }
            $dateDebut = \Carbon\Carbon::parse($request->date_debut_arret);
            $dateFin = \Carbon\Carbon::parse($request->date_fin_arret);
            $dureeRepos = $dateDebut->diffInDays($dateFin);
            if($dureeRepos < 0) {
                $errors = "La date de début d'arrêt ne peut pas être postérieure à la date de fin d'arrêt.";
            }
            if (!isset($errors)) 
            {
                // Calculer la durée de repos en jours
                $item->patient_medical_id = $request->patient_medical_id;
                $item->user_id = $user->id;
                $item->date_examen = $request->date_examen;
                $item->motif_arret = $request->motif_arret;
                $item->duree_repos = $dureeRepos;
                $item->date_debut_arret = $request->date_debut_arret;
                $item->date_fin_arret = $request->date_fin_arret;
                $item->save();
                $id = $item->id;
                DB::commit();
                return Outil::redirectgraphql($this->queryName, "id:$id", Outil::$queries[$this->queryName]);
            }

            if (isset($errors)) 
            {
                throw new \Exception('{"data": null, "errors": "' . $errors . '" }');
            }
        } catch (\Throwable $e) 
        {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $item = CertificatMedical::findOrFail($id);
            $item->delete();

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getOne($id)
    {
        try {
            $item = CertificatMedical::with(['patient_medical', 'user'])->findOrFail($id);
            return response()->json($item);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


    public function generateCertificatMedical($id)
    {
        // Récupérer le certificat médical par ID
        $certificat = CertificatMedical::with(['user', 'patient_medical'])->findOrFail($id);

        // Formater les données dans un tableau
        $data = [
            'nom_medecin' => $certificat->user->name,
            'nom_patient' => $certificat->patient_medical->nom_complet,
            'date_examen' => $certificat->date_examen,
            'motif_arret' => $certificat->motif_arret,
            'duree_repos' => $certificat->duree_repos,
            'date_debut_arret' => $certificat->date_debut_arret,
            'date_fin_arret' => $certificat->date_fin_arret,
        ];
        // Retourner la vue Blade avec les données
        return view('pdf.repos_medical', compact('data'));
    }
}