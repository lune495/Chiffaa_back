<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Notification};

class NotificationQuery extends Query
{
    protected $attributes = [
        'name' => 'notifications'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Notification'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Notification::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();

        return $query->map(function (Notification $item)
        {
            return
            [
                'id'                       => $item->id,
                'medecin'                  => $item->medecin,
                'creneau'                  => $item->creneau,
                'type'                     => $item->type,
                'message'                  => $item->message,
                'is_read'                  => $item->is_read,
                'created_at'               => $item->created_at
            ];  
        });
    }
}