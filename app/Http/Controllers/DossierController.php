<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Dossier,Outil};

class DossierController extends Controller
{
    //

    private $queryName = "dossiers";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $item = new Dossier();
            if (!empty($request->id))
            {
                $item = Dossier::find($request->id);
            }
            // if (empty($request->nom))
            // {
            //     $errors = "Renseignez la categorie";
            // }
            DB::beginTransaction();
            $item->patient_id = $request->patient_id;
            if (!isset($errors)) 
            {
                $item->save();
                $item->numero = "DOC-000{$item->id}";
                $item->save();
                $id = $item->id;
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
