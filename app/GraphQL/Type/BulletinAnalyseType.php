<?php

namespace App\GraphQL\Type;

use App\Models\BulletinAnalyse;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BulletinAnalyseType extends GraphQLType
{
    protected $attributes = [
        'name' => 'BulletinAnalyse',
    ];

    public function fields(): array
    {
        return [
            'id'                => ['type' => Type::id()],
            'diagnostic'        => ['type' => Type::string()],
            'patient_id'        => ['type' => Type::int()],
            'user_id'           => ['type' => Type::int()],
            'patient_medical'           => ['type' => GraphQL::type('PatientMedical')],
            'user'              => ['type' => GraphQL::type('User')],
            'element_bulletin_analyses'     => ['type' => Type::listOf(GraphQL::type('ElementBulletinAnalyse'))],
        ];
    }
}