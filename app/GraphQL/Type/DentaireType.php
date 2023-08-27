<?php
namespace App\GraphQL\Type;

use App\Models\Dentaire;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DentaireType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Dentaire',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'nom_complet'               => ['type' => Type::string()],
                'nature'                    => ['type' => Type::string()],
                'montant'                   => ['type' => Type::int()],
                'adresse'                   => ['type' => Type::string()],
                'remise'                    => ['type' => Type::int()],
                'medecin'                   => ['type' => GraphQL::type('Medecin')],
                'user'                      => ['type' => GraphQL::type('User')]
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}