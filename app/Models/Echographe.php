<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echographe extends Model
{
    use HasFactory;

    public  function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
    public function element_echographes()
    {
        return $this->hasMany(ElementEchographes::class);
    }
}
