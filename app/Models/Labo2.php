<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labo2 extends Model
{
    use HasFactory;

    public  function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public  function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function element_labo2s()
    {
        return $this->hasMany(ElementLabo2s::class);
    }
}
