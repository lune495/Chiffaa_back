<?php

namespace App\GraphQL\Query;

use App\Models\CertificatMedical;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CertificatMedicalQuery extends Query
{
    protected $attributes = [
        'name' => 'certificats'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('CertificatMedical'));
    }

    public function args(): array
    {
        return [
            'id'                    => ['type' => Type::int()],
            'patient_medical_id'    => ['type' => Type::int()],
            'user_id'               => ['type' => Type::int()],
            'dossier_id'            => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = CertificatMedical::query();

        if (isset($args['id'])) {
            $query->where('id', $args['id']);
        }

        if (isset($args['patient_medical_id'])) 
        {
            $query->where('patient_medical_id', $args['patient_medical_id']);
        }

        if (isset($args['user_id'])) {
            $query->where('user_id', $args['user_id']);
        }
        
        if (isset($args['dossier_id'])) {
            $query->whereHas('patient_medical', function ($query) use ($args) {
                $query->whereHas('dossier', function ($query) use ($args) {
                    $query->where('id', $args['dossier_id']);
                });
            });
        }

        $query->orderBy('id', 'desc');

        return $query->get()->map(function (CertificatMedical $item) {
            return [
                'id'                    => $item->id,
                'user'                  => $item->user,
                'patient_medical'       => $item->patient_medical,
                'date_examen'           => $item->date_examen,
                'motif_arret'           => $item->motif_arret,
                'duree_repos'           => $item->duree_repos,
                'date_debut_arret'      => $item->date_debut_arret,
                'date_fin_arret'        => $item->date_fin_arret,
                'updated_at'            => $item->updated_at,
                'created_at'            => $item->created_at,
            ];
        });
    }
}
