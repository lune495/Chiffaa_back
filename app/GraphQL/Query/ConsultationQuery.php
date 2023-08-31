<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Consultation;
use DateTime;

class ConsultationQuery extends Query
{
    protected $attributes = [
        'name' => 'consultations'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Consultation'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'nom_complet'         => ['type' => Type::string()],
            'date_start'         => ['type' => Type::string()],
            'date_end'           => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Consultation::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }

        if (isset($args['date_start']) && isset($args['date_end'])) {
            $startDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $args['date_start'] . ' 00:00:00');
            $endDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $args['date_end'] . ' 23:59:59');
    
            if ($startDateTime && $endDateTime) {
                $query = $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
            }
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Consultation $item)
        {
            return
            [
                'id'                      => $item->id,
                'nom_complet'             => $item->nom_complet,
                'nature'                  => $item->nature,
                'montant'                 => $item->montant,
                'adresse'                 => $item->adresse,
                'remise'                  => $item->remise,
                'medecin'                 => $item->medecin,
                'element_consultations'   => $item->element_consultations,
                'user'                    => $item->user,
                'created_at'              => $item->created_at,
            ];
        });

    }
}
