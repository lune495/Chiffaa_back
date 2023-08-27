<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementDentaires extends Model
{
    use HasFactory;

    public  function dentaire()
    {
        return $this->belongsTo(Dentaire::class);
    }

    public  function type_dentaire()
    {
        return $this->belongsTo(TypeDentaire::class);
    }
}
