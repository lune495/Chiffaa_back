<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoraireRdv extends Model
{
    use HasFactory;

    protected $table = 'horaire_rdvs';
    public  function creneau()
    {
        return $this->belongsTo(Creneaux::class, 'creneau_id');
    }
}
