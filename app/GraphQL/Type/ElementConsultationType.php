<?php
namespace App\GraphQL\Type;

use App\Models\ElementConsultations;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ElementConsultationType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ElementConsultation',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                         => ['type' => Type::id(), 'description' => ''],
                'consultation'               => ['type' => GraphQL::type('Consultation')],
                'type_consultation'          => ['type' => GraphQL::type('TypeConsultation')],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}