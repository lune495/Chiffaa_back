<?php
namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Patient, Outil};

class PatientQuery extends Query
{
    protected $attributes = [
        'name' => 'patients'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Patient'));
    }

    public function args(): array
    {
        return [
            'id'                  => ['type' => Type::int()],
            'nom'                 => ['type' => Type::string()],
            'search'              => ['type' => Type::string()],
            'prenom'              => ['type' => Type::string()],
            'telephone'           => ['type' => Type::string()],
            'date_naissance'      => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Patient::doesntHave('dossier');

        // Filtrage par nom
        if (isset($args['nom'])) {
            $query->where('nom', Outil::getOperateurLikeDB(), '%'.$args['nom'].'%');
        }

        // Filtrage par prenom
        if (isset($args['prenom'])) {
            $query->where('prenom', Outil::getOperateurLikeDB(), '%'.$args['prenom'].'%');
        }

        if (isset($args['search'])) {
            $query->where(function ($subQuery) use ($args) {
                $subQuery->Where('prenom', Outil::getOperateurLikeDB(), '%' . $args['search'] . '%')
                         ->orWhere('nom', Outil::getOperateurLikeDB(), '%' . $args['search'] . '%');
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
        return $results->map(function (Patient $item) {
            return [
                'id'                  => $item->id,
                'nom'                 => $item->nom,
                'prenom'              => $item->prenom,
                'telephone'           => $item->telephone,
                'adresse'             => $item->adresse,
                'date_naissance'      => $item->date_naissance,
                'suivis'              => $item->suivis,
                'services'            => $item->services,
                'dossier'             => $item->dossier,
            ];
        });
    }
}