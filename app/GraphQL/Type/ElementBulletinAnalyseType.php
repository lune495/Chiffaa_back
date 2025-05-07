<?php
namespace App\GraphQL\Type;

use App\Models\ElementBulletinAnalyse;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Carbon\Carbon;

class ElementBulletinAnalyseType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ElementBulletinAnalyse',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                => ['type' => Type::id(), 'description' => ''],
                'type_service_id'   => ['type' => Type::int()],
                'created_at'        => ['type' => Type::string()],
                'updated_at'        => ['type' => Type::string()],
                'bulletin_analyse'  => ['type' => GraphQL::type('BulletinAnalyse')],
                'type_service'      => ['type' => GraphQL::type('TypeService')]
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}