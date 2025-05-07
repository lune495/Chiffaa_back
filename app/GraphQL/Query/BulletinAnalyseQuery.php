<?php

namespace App\GraphQL\Query;

use App\Models\BulletinAnalyse;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class BulletinAnalyseQuery extends Query
{
    protected $attributes = [
        'name' => 'bulletin_analyses'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('BulletinAnalyse'));
    }

    public function args(): array
    {
        return [
            'id'                    => ['type' => Type::int()],
            'patient_medical_id'    => ['type' => Type::int()],
            'user_id'               => ['type' => Type::int()],
            'type_service_id'       => ['type' => Type::int()],
            'dossier_id'            => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = BulletinAnalyse::query();

        if (isset($args['id'])) 
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['patient_medical_id'])) 
        {
            $query->where('patient_medical_id', $args['patient_medical_id']);
        }

        if (isset($args['user_id'])) 
        {
            $query->where('user_id', $args['user_id']);
        }
        if (isset($args['dossier_id'])) 
            {
                $query->whereHas('patient_medical', function ($query) use ($args) {
                    $query->whereHas('dossier', function ($query) use ($args) {
                        $query->where('id', $args['dossier_id']);
                    });
                });
            }
        $query->whereHas('element_bulletin_analyses', function ($query) use ($args) {
            if (isset($args['type_service_id'])) 
            {
                $query->where('type_service_id', $args['type_service_id']);
            }
        });
        return $query->get()->map(function (BulletinAnalyse $item) {
            return [
                'id'                                =>  $item->id,
                'diagnostic'                        =>  $item->diagnostic,
                'patient_medical'                   =>  $item->patient_medical,
                'user'                              =>  $item->user,
                'element_bulletin_analyses'         =>  $item->element_bulletin_analyses,
            ];
        });
    }
}