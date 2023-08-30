<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementLabo2s extends Model
{
    use HasFactory;

    public  function lab2o()
    {
        return $this->belongsTo(Labo2::class);
    }

    public  function type_labo2()
    {
        return $this->belongsTo(TypeLabo2::class);
    }
}
