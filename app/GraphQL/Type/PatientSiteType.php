<?php
namespace App\GraphQL\Type;

use App\Models\PatientSite;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Carbon\Carbon;

class PatientSiteType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'PatientSite',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'prenom'                    => ['type' => Type::string()],
                'nom'                       => ['type' => Type::string()],
                'adresse'                   => ['type' => Type::string()],
                'telephone'                 => ['type' => Type::string()],
                'rdvs'                      => ['type' => Type::listOf(GraphQL::type('Rdv')), 'description' => ''],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}