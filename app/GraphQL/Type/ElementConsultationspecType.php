<?php
namespace App\GraphQL\Type;

use App\Models\ElementConsultationspec;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ElementConsultationspecType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ElementConsultationspec',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                             => ['type' => Type::id(), 'description' => ''],
                'consultationspec'               => ['type' => GraphQL::type('Consultationspec')],
                'type_consultationspec'          => ['type' => GraphQL::type('TypeConsultationspec')],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}