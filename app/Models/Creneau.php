<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    use HasFactory;
    protected $table = 'creneaux';
    protected $fillable = [
        'planning_id',
        'date',
        'heure_debut',
        'heure_fin',
        'disponible',
    ];
    public  function planning()
    {
        return $this->belongsTo(Planning::class);
    }

    public function rdv()
    {
        return $this->hasOne(Rdv::class, 'creneau_id');
    }
}   