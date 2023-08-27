<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultationspecs extends Model
{
    use HasFactory;

    public  function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
    
    public function element_consultationspecs()
    {
        return $this->hasMany(ElementConsultationspecs::class);
    }
}
