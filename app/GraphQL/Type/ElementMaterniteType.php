<?php
namespace App\GraphQL\Type;

use App\Models\ElementMaternites;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ElementMaterniteType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ElementMaternite',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'maternite'                 => ['type' => GraphQL::type('Maternite')],
                'type_maternite'            => ['type' => GraphQL::type('TypeMaternite')],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}