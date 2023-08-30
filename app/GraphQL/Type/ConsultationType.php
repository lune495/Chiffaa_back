<?php
namespace App\GraphQL\Type;

use App\Models\Consultation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Carbon\Carbon;

class ConsultationType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Consultation',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'nom_complet'               => ['type' => Type::string()],
                'nature'                    => ['type' => Type::string()],
                'montant'                   => ['type' => Type::int()],
                'adresse'                   => ['type' => Type::string()],
                'remise'                    => ['type' => Type::int()],
                'medecin'                   => ['type' => GraphQL::type('Medecin')],
                'user'                      => ['type' => GraphQL::type('User')],
                'element_consultations'     => ['type' => Type::listOf(GraphQL::type('ElementConsultation')), 'description' => ''],
                'created_at'                => ['type' => Type::string()],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
    protected function resolveCreatedAtField($root, $args)
    {
        if (!isset($root['created_at']))
        {
            $created_at = $root->created_at;
        }
        else
        {
            $created_at = $root['created_at'];
        }
        return Carbon::parse($created_at)->format('d/m/Y H:i:s');
    }
}