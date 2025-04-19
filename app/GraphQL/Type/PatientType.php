<?php
namespace App\GraphQL\Type;

use App\Models\Patient;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Models\{Outil};

class PatientType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Patient',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [ 
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'nom'                       => ['type' => Type::string()],
                'prenom'                    => ['type' => Type::string()],
                'telephone'                 => ['type' => Type::int()],
                'adresse'                   => ['type' => Type::string()],
                'date_naissance'            => ['type' => Type::string()],
                'dossier'                   => ['type' => GraphQL::type('Dossier')],
                'suivis'                    => ['type' => Type::listOf(GraphQL::type('Suivi')), 'description' => ''],
                'services'                  => ['type' => Type::listOf(GraphQL::type('Service')), 'description' => ''],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveNomField($root, array $args)
    {
        return Outil::toutEnMajuscule(is_array($root) ? $root['nom'] : $root->nom);
    }
    protected function resolvePrenomField($root, array $args)
    {
        return Outil::toutEnMajuscule(is_array($root) ? $root['nom'] : $root->nom);
    }
}