<?php

namespace App\GraphQL\Type;

use App\Models\CertificatMedical;
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CertificatMedicalType extends GraphQLType
{
    protected $attributes = [
        'name' => 'CertificatMedical',
        'description' => '',
    ];

    public function fields(): array
    {
        return [
            'id'                    => ['type' => Type::int()],
            'user'                  => ['type' => GraphQL::type('User')],
            'patient_medical'       => ['type' => GraphQL::type('PatientMedical')],
            'date_examen'           => ['type' => Type::string()],
            'motif_arret'           => ['type' => Type::string()],
            'duree_repos'           => ['type' => Type::int()],
            'date_debut_arret'      => ['type' => Type::string()],
            'date_fin_arret'        => ['type' => Type::string()],
            'created_at'            => ['type' => Type::string()],
            'created_at_fr'         => ['type' => Type::string()],
            'updated_at'            => ['type' => Type::string()],
            'updated_at_fr'         => ['type' => Type::string()],
        ];
    }

    // protected function resolveCreatedAtField($root, $args)
    // {
    //     return is_string($root->created_at)
    //         ? $root->created_at
    //         : $root->created_at->format('Y-m-d H:i:s');
    // }

    protected function resolveCreatedAtFrField($root, $args)
    {
        return Carbon::parse($root->created_at)->format('d/m/Y H:i:s');
    }

    protected function resolveUpdatedAtField($root, $args)
    {
        return is_string($root->updated_at)
            ? $root->updated_at
            : $root->updated_at->format('Y-m-d H:i:s');
    }

    protected function resolveUpdatedAtFrField($root, $args)
    {
        return Carbon::parse($root->updated_at)->format('d/m/Y H:i:s');
    }
}
