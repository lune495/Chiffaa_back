<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Depense;
class DepenseQuery extends Query
{
    protected $attributes = [
        'name' => 'depenses'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Depense'));
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
        $query = Depense::query();
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Depense $item)
        {
            return
            [
                'id'                      => $item->id,
                'nom'                     => $item->nom,
                'montant'                 => $item->montant
            ];
        });

    }
}
