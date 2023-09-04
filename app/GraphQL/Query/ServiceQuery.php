<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Service;
class ServiceQuery extends Query
{
    protected $attributes = [
        'name' => 'services'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Service'));
    }

    public function args(): array
    {
        return
        [
            'id'                 => ['type' => Type::int()],
            'nom_complet'        => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Service::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Service $item)
        {
            return
            [
                'id'                      => $item->id,
                'nom_complet'             => $item->nom_complet,
                'nature'                  => $item->nature,
                'montant'                 => $item->montant,
                'adresse'                 => $item->adresse,
                'remise'                  => $item->remise,
                'medecin'                 => $item->medecin,
                'module'                  => $item->module,
                'montant_total'           => $item->montant_total,
                'user'                    => $item->user,
                'created_at'              => $item->created_at,
                'element_services'        => $item->element_services,
            ];
        });

    }
}
