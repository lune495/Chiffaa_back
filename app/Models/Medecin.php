<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;

    public  function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function plannings()
    {
        return $this->hasMany(Planning::class);
    }

    public function certificats()
    {
        return $this->hasMany(CertificatMedical::class);
    }
}