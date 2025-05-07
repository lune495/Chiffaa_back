<?php
namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{PatientMedical, Outil};

class PatientMedicalQuery extends Query
{
    protected $attributes = [
        'name' => 'patient_medicals'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('PatientMedical'));
    }

    public function args(): array
    {
        return [
            'id'                  => ['type' => Type::int()],
            'nom'                 => ['type' => Type::string()],
            'search'              => ['type' => Type::string()],
            'telephone'           => ['type' => Type::string()],
            'date_naissance'      => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = PatientMedical::query();
        // Filtrage par nom
        if (isset($args['nom'])) {
            $query->where('nom', Outil::getOperateurLikeDB(), '%'.$args['nom'].'%');
        }

        if (isset($args['search'])) {
            $query->where(function ($subQuery) use ($args) {
                $subQuery->Where('nom', Outil::getOperateurLikeDB(), '%' . $args['search'] . '%')
                         ->orWhere('telephone', Outil::getOperateurLikeDB(), '%' . $args['search'] . '%');
            });
        }

        // Filtrage par telephone
        if (isset($args['telephone'])) {
            $query->where('telephone', Outil::getOperateurLikeDB(), '%'.$args['telephone'].'%');
        }

        // Filtrage par date de naissance
        if (isset($args['date_naissance']) && $args['date_naissance'] != "") {
            $query->where('date_naissance', $args['date_naissance']);
        }

        // Tri par ID décroissant
        $query->orderBy('id', 'asc');

        // Récupération des résultats
        $results = $query->get();

        // Mapping des résultats
        return $results->map(function (PatientMedical $item) {
            return [
                'id'                  => $item->id,
                'nom_complet'         => $item->nom_complet,
                'telephone'           => $item->telephone,
                'adresse'             => $item->adresse,
                'date_naissance'      => $item->date_naissance,
                'dossier'             => $item->dossier,
            ];
        });
    }
}