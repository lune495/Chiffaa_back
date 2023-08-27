<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labo extends Model
{
    use HasFactory;

    public  function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public function element_labos()
    {
        return $this->hasMany(ElementLabos::class);
    }
}
