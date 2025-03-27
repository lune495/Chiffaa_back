<?php
namespace App\GraphQL\Type;

use App\Models\Planning;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Carbon\Carbon;

class PlanningType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Planning',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'date_planning'             => ['type' => Type::string()],
                'heure_debut'               => ['type' => Type::string()],
                'heure_fin'                 => ['type' => Type::string()],
                'medecin_id'                => ['type' => Type::int()],
                'medecin'                   => ['type' => GraphQL::type('Medecin')],
                'creneaux'                  => ['type' => Type::listOf(GraphQL::type('Creneau')), 'description' => ''],
            ];
    }

    protected function resolveJourField($root, array $args)
    {
        Carbon::setLocale('fr');
        $jour = Carbon::parse(is_array($root) ? $root['date_planning'] : $root->date_planning)->translatedFormat('l');
        return $jour;    
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}