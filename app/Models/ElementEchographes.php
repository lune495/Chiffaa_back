<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementEchographes extends Model
{
    use HasFactory;

    public  function echographe()
    {
        return $this->belongsTo(Echographe::class);
    }

    public  function type_echographe()
    {
        return $this->belongsTo(TypeEchographe::class);
    }
}
