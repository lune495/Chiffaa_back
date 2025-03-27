<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{

    use HasFactory;

    protected $fillable = [
        'date_planning',
        'heure_debut',
        'heure_fin',
    ];
    public  function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public function creneaux()
    {
        return $this->hasMany(Creneau::class);
    }
}
