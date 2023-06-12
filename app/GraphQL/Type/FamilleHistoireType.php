<?php
namespace App\GraphQL\Type;

use App\Models\{FamilleHistoire,Outil};
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class FamilleHistoireType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'FamilleHistoire',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                         => ['type' => Type::id(), 'description' => ''],
                'nom'                        => ['type' => Type::string()],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}