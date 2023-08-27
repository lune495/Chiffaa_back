<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEchographe extends Model
{
    use HasFactory;

    public function element_echographes()
    {
        return $this->hasMany(ElementEchographes::class);
    }
}
