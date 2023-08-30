<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Echographe;
class EchographeQuery extends Query
{
    protected $attributes = [
        'name' => 'echographes'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Echographe'));
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
        $query = Echographe::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Echographe $item)
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
                'user'                    => $item->user,
                'created_at'              => $item->created_at,
                'element_echographes'     => $item->element_echographes,
            ];
        });

    }
}
