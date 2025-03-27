<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{PatientSite};

class PatientSiteQuery extends Query
{
    protected $attributes = [
        'name' => 'patient_sites'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('PatientSite'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'nom'                 => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = PatientSite::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        $query->orderBy('id', 'asc');
        $query = $query->get();
        return $query->map(function (PatientSite $item)
        {
            return
            [
                'id'                     => $item->id,
                'nom'                    => $item->nom,
                'prenom'                 => $item->prenom,
                'telephone'              => $item->telephone,
                'adresse'                => $item->adresse
            ];
        });
    }
}