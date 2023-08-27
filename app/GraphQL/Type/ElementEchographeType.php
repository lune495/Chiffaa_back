<?php
namespace App\GraphQL\Type;

use App\Models\ElementEchographes;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ElementEchographeType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ElementEchographe',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'echographe'                => ['type' => GraphQL::type('Echographe')],
                'type_echographe'           => ['type' => GraphQL::type('TypeEchographe')],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}