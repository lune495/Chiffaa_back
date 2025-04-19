<?php
namespace App\GraphQL\Type;

use App\Models\Role;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CreneauType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Creneau',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'planning_id'               => ['type' => Type::int()],
                'date'                      => ['type' => Type::string()],
                'heure_debut'               => ['type' => Type::string()],
                'heure_fin'                 => ['type' => Type::string()],
                'disponible'                => ['type' => Type::boolean()],
                'planning'                  => ['type' => GraphQL::type('Planning')],
                'rdv'                       => ['type' => GraphQL::type('Rdv')],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}