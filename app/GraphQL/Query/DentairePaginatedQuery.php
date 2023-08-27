<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Dentaire;
class DentairePaginatedQuery extends Query
{
    protected $attributes = [
        'name' => 'dentaires'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Dentaire'));
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
        $query = Dentaire::query();
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return   $query->map(function (Dentaire $item)
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
            ];
        });

    }
}