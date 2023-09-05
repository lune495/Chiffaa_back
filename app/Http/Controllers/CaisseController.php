<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as Image;
use App\Models\{Service,Outil,User,ElementService,Log,TypeService,CaisseClosure};
use \PDF;

class CaisseController extends Controller
{

    private $queryName = "services";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $item = new Service();
            $log = new Log();
            if (!empty($request->id))
            {
                $item = Service::find($request->id);
            }
            if (empty($request->medecin_id))
            {
                $errors = "Renseignez le Medecin";
            }
            if (empty($request->nom_complet))
            {
                $errors = "Renseignez le nom";
            }
            $str_json_type_service = json_encode($request->type_services);
            $type_service_tabs = json_decode($str_json_type_service, true);
            DB::beginTransaction();
            $item->nom_complet = $request->nom_complet;
            $item->nature = $request->nature;
            $item->montant = $request->montant;
            $item->adresse = $request->adresse;
            $item->remise = $request->remise;
            $item->medecin_id = $request->medecin_id;
            $item->module_id = $request->module_id;
            $item->user_id = $request->user_id;
            $montant = 0;
            if (!isset($errors)) 
            {
                $item->save();
                $id = $item->id;
                if($item->save())
                {
                    foreach ($type_service_tabs as $type_service_tab) 
                    {
                        $tpc = TypeService::find($type_service_tab['type_service_id']);
                        if (!isset($tpc)) {
                        $errors = "Type  Service inexistant";
                        }
                        $element_service = new ElementService();
                        $element_service->service_id =  $id;
                        $element_service->type_service_id =  $type_service_tab['type_service_id'];
                        $element_service->save();
                        if($element_service->save())
                        {
                            $montant  = $montant + $element_service->type_service->prix;
                        }
                    }
                    $log->designation = $item->module->nom;
                    $log->id_evnt = $id;
                    $log->date = $item->created_at;
                    $log->prix = $montant;
                    $log->remise = $item->remise;
                    $log->montant = $item->montant;
                    $log->save();
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

    public function closeCaisse(Request $request)
    {
        try {
            // Calculez le montant total de la caisse à la fermeture (par exemple, en ajoutant les montants des consultations non facturées)
            $totalCaisse = $request->montant_total;

            // Enregistrez les détails de la clôture de caisse
            $caisseClosure = new CaisseClosure();
            $caisseClosure->heure_fermeture = now(); // Ou utilisez la date/heure appropriée
            $caisseClosure->montant_total = $totalCaisse;
            $caisseClosure->save();

            return response()->json(['message' => 'Caisse fermée avec succès.']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la clôture de la caisse.']);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return Service::all();

    }

    public function generatePDF($id,$start=false,$end=false)
    {
        $service = Service::find($id);
        if($service!=null)
        {
         $data = Outil::getOneItemWithGraphQl($this->queryName, $id, true);
        //dd($data);
         $pdf = PDF::loadView("pdf.ticket-service", $data);
        $measure = array(0,0,225.772,650.197);
        return $pdf->setPaper($measure, 'orientation')->stream();
            //  return $pdf->stream();
        }else{
         $data = Outil::getOneItemWithGraphQl($this->queryName, $id, false);
            return view('notfound');
        }
    }

    public function generatePDF2($start=false,$end=false)
    {
        if($start!=false && $end!=false)
        {
            $data = DB::table('logs')
            ->select('user_id','designation', DB::raw('SUM(prix) as total_prix'))
            ->groupBy('designation','user_id')
            ->get()
            ->pluck('total_prix', 'designation','user_id')
            ->toArray();
            $start="2023-09-06";
            $end= "2023-09-06";
            $dateRange = [
                'start' => $start,
                'end' => $end
            ];
         $pdf = PDF::loadView("pdf.SG", $data,$dateRange);
         return $pdf->stream();
        }
        else
        {
         return view('notfound');
        }
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

     /**
     * Search for a name.
     * @param str $name
     */
    public function search($name)
    {
        //
        return Consultation::where('titre','like','%'.$name)->get();
    }
}
