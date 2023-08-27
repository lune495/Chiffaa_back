<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementLabos extends Model
{
    use HasFactory;

    public  function labo()
    {
        return $this->belongsTo(Labo::class);
    }

    public  function type_labo()
    {
        return $this->belongsTo(TypeLabo::class);
    }
}
