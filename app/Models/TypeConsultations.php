<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeConsultations extends Model
{
    use HasFactory;

    public function element_consultations()
    {
        return $this->hasMany(ElementConsultations::class);
    }
}
