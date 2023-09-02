<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Module;
use DateTime;

class ModuleQuery extends Query
{
    protected $attributes = [
        'name' => 'modules'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Module'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'nom'                 => ['type' => Type::string()]
        ];
    }

    public function resolve($root, $args)
    {
        $query = Module::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }

        if (isset($args['date_start']) && isset($args['date_end'])) {
            $startDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $args['date_start'] . ' 00:00:00');
            $endDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $args['date_end'] . ' 23:59:59');
    
            if ($startDateTime && $endDateTime) {
                $query = $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
            }
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Module $item)
        {
            return
            [
                'id'                      => $item->id,
                'nom'                     => $item->nom,
                'type_services'           => $item->type_services
            ];
        });

    }
}
