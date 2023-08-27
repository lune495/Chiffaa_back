<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeLabo extends Model
{
    use HasFactory;
    public function element_labos()
    {
        return $this->hasMany(ElementLabos::class);
    }
}
