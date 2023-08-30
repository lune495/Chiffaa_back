<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Labo;
class LaboQuery extends Query
{
    protected $attributes = [
        'name' => 'labos'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Labo'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'nom_complet'         => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Labo::query();
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Labo $item)
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
                'element_labos'           => $item->element_labos,
                'created_at'              => $item->created_at
            ];
        });

    }
}
