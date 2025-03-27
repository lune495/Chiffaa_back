<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Planning;
use Carbon\Carbon;

class PlanningQuery extends Query
{
    protected $attributes = [
        'name' => 'plannings'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Planning'));
    }

    public function args(): array
    {
        return [
            'id'          => ['type' => Type::int()],
            'jour'        => ['type' => Type::string()],
            'date_debut'  => ['type' => Type::string()],
            'date_fin'    => ['type' => Type::string()],
            'medecin_id'  => ['type' => Type::int()],
            'module_id'   => ['type' => Type::int(),'nullable' => true],
            'user_id'     => ['type' => Type::int()],
        ];
    }

    
public function resolve($root, $args)
{
    $query = Planning::query();
    if (isset($args['date_debut']) && isset($args['date_fin'])) {
        $dateDebut = Carbon::parse($args['date_debut'])->toDateString();
        $dateFin = Carbon::parse($args['date_fin'])->toDateString();
        $query = $query->whereHas('creneaux', function ($q) use ($dateDebut, $dateFin) {
            $q->whereBetween('date', [$dateDebut, $dateFin]);
        });
    } elseif (isset($args['date_debut'])) {
        $dateDebut = Carbon::parse($args['date_debut'])->toDateString();
        $query = $query->whereHas('creneaux', function ($q) use ($dateDebut) {
            $q->where('date', '>=', $dateDebut);
        });
    } elseif (isset($args['date_fin'])) {
        $dateFin = Carbon::parse($args['date_fin'])->toDateString();
        $query = $query->whereHas('creneaux', function ($q) use ($dateFin) {
            $q->where('date', '<=', $dateFin);
        });
    }
    // else {
    //     $today = Carbon::today()->toDateString();
    //     $query = $query->whereHas('creneaux', function ($q) use ($today) {
    //         $q->where('date', '=', $today);
    //     });
    // }

    if (isset($args['medecin_id'])) {
        $query = $query->where('medecin_id', $args['medecin_id']);
    }
    if(isset($args['module_id']))
    {
        $query = $query->whereHas('medecin', function ($q) use ($args) {
            $q->where('module_id', $args['module_id']);
        });
    }

    if(isset($args['user_id']))
    {
        $query = $query->whereHas('medecin', function ($q) use ($args) {
            $q->where('user_id', $args['user_id']);
        });
    }

    $query->orderBy('id', 'asc');
    $plannings = $query->get();

    return $plannings->map(function (Planning $item) use ($args) {
        $filteredCreneaux = $item->creneaux->filter(function ($creneau) use ($args) {
            $dateDebut = isset($args['date_debut']) ? Carbon::parse($args['date_debut'])->toDateString() : null;
            $dateFin = isset($args['date_fin']) ? Carbon::parse($args['date_fin'])->toDateString() : null;

            if ($dateDebut && $dateFin) {
                return $creneau->date >= $dateDebut && $creneau->date <= $dateFin;
            } elseif ($dateDebut) {
                return $creneau->date >= $dateDebut;
            } elseif ($dateFin) {
                return $creneau->date <= $dateFin;
            }

            return true;
        });

        return [
            'id'            => $item->id,
            'date_planning' => $item->date_planning,
            'heure_debut'   => $item->heure_debut,
            'heure_fin'     => $item->heure_fin,
            'medecin'       => $item->medecin,
            'creneaux'      => $filteredCreneaux->values()
        ];
    });
}
}