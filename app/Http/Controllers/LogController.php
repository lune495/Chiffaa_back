<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //
    // private $queryName = "logs";

    // public function save(Request $request)
    // {
    //     try 
    //     {
    //         $errors =null;
    //         $item = new Log();
    //         $chapitre = new Chapitre();
    //         if (!empty($request->id))
    //         {
    //             $item = Log::find($request->id);
    //         }
    //         if (empty($request->famille_histoire_id))
    //         {
    //             $errors = "Renseignez la categorie du livre";
    //         }
    //         if (empty($request->titre))
    //         {
    //             $errors = "Renseignez le titre";
    //         }
    //         $str_json_chapitre = json_encode($request->tab_chapitres);
    //         $chapitre_tabs = json_decode($str_json_chapitre, true);
    //         DB::beginTransaction();
    //         $image_name = null;
    //         if($request->hasFile('image')){
    //             //    $destinationPath = "images/produits";
    //                $image = $request->file("image");
    //                $image_name = $image->getClientOriginalName();
    //                 $destinationPath = public_path().'/images';
    //                 $image->move($destinationPath,$image_name);
    //                //Storage::disk('public')->put($image_name,file_get_contents($request->image));
    //                //$path = $request->file('image')->storeAs($destinationPath,$image_name);
    //             }
    //         $item->image = $image_name;
    //         $item->titre = $request->titre;
    //         $item->genre = $request->genre;
    //         $item->resume = $request->resume;
    //         $item->famille_histoire_id = $request->famille_histoire_id;
    //         $item->user_id = $request->user_id;
    //         if (!isset($errors)) 
    //         {
    //             $item->save();
    //             $id = $item->id;
    //             if($item->save())
    //             {
    //                 foreach ($chapitre_tabs as $chapitre_tab) 
    //                 {
    //                     $chapitre->histoire_id =  $item->id;
    //                     $chapitre->titre =  $chapitre_tab['titre'];
    //                     $chapitre->save();
    //                 }
    //             }
    //             DB::commit();
    //             return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
    //         }
    //         if (isset($errors))
    //         {
    //             throw new \Exception('{"data": null, "errors": "'. $errors .'" }');
    //         }
    //     } catch (\Throwable $e) {
    //             DB::rollback();
    //             return $e->getMessage();
    //     }
    // }

}