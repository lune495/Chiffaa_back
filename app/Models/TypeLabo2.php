<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeLabo2 extends Model
{
    use HasFactory;

    public function element_labo2s()
    {
        return $this->hasMany(ElementLabo2s::class);
    }
}
