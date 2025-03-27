<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSite extends Model
{
    use HasFactory;

    public function rdvs()
    {
        return $this->hasMany(Rdv::class);
    }
}
