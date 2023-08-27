<?php
namespace App\GraphQL\Type;

use App\Models\ElementLabos;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ElementLaboType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ElementLabo',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'labo'                     => ['type' => GraphQL::type('Labo')],
                'type_labo'                 => ['type' => GraphQL::type('TypeLabo')],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}