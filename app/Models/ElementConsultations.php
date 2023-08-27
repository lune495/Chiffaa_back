<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementConsultations extends Model
{
    use HasFactory;

    public  function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public  function type_consultation()
    {
        return $this->belongsTo(TypeConsultations::class);
    }
}
