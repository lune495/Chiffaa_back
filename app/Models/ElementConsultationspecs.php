<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementConsultationspecs extends Model
{
    use HasFactory;

    public  function consultationspec()
    {
        return $this->belongsTo(Consultationspecs::class);
    }

    public  function type_consultationspec()
    {
        return $this->belongsTo(TypeConsultations::class);
    }
}
