<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementMaternites extends Model
{
    use HasFactory;
    public  function maternite()
    {
        return $this->belongsTo(Maternite::class);
    }

    public  function type_maternite()
    {
        return $this->belongsTo(TypeMaternite::class);
    }
}
