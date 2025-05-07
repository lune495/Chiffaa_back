<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;

    public  function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public  function patient_medical()
    {
        return $this->belongsTo(PatientMedical::class);
    }
}
