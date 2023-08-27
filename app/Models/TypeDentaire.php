<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDentaire extends Model
{
    use HasFactory;
    
    public function element_dentaires()
    {
        return $this->hasMany(ElementDentaires::class);
    }
}
