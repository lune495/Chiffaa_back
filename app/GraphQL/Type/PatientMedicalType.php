<?php
namespace App\GraphQL\Type;

use App\Models\PatientMedical;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Carbon\Carbon;

class PatientMedicalType extends GraphQLType
{ 
    protected $attributes = [
        'name'          => 'PatientMedical',
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'nom_complet'               => ['type' => Type::string()],
                'telephone'                 => ['type' => Type::int()],
                'adresse'                   => ['type' => Type::string()],
                'date_naissance'            => ['type' => Type::string()],
                'dossier'                   => ['type' => GraphQL::type('Dossier')],
                'certificats'               => ['type' => Type::listOf(GraphQL::type('CertificatMedical')), 'description' => ''],
            ];
    }
}