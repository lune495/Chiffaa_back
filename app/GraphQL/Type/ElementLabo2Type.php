<?php
namespace App\GraphQL\Type;

use App\Models\ElementLabos;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ElementLabo2Type extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ElementLabo2',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'labo2'                     => ['type' => GraphQL::type('Labo2')],
                'type_labo2'                 => ['type' => GraphQL::type('TypeLabo2')],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}