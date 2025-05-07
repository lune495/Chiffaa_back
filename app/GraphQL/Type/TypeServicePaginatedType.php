<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
class TypeServicePaginatedType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'type_servicespaginated'
    ];
    public function fields(): array
    {  return
        [
            'metadata' =>
            [
                'type' => GraphQL::type('Metadata'),
                'resolve' => function ($root)
                {
                    return Arr::except($root->toArray(), ['data']);
                }
            ],
            'data' =>
            [
                'type' => Type::listOf(GraphQL::type('TypeService')),
                'resolve' => function ($root)
                {
                    return $root;
                }
            ]
        ];
    }
}
