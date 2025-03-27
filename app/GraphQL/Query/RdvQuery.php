<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Rdv,Outil};
class RdvQuery extends Query
{
    protected $attributes = [
        'name' => 'rdvs'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Rdv'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'user_id'             => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Rdv::query();
        if (isset($args['user_id']))
        {
            $query = $query->where('user_id', $args['user_id']);
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Rdv $item)
        {
            return
            [
                'id'                  => $item->id,
                'user'                => $item->user,
                'creneau'             => $item->creneau,
                'status'              => $item->status,
            ];
        });

    }
}