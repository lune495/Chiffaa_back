<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMaternite extends Model
{
    use HasFactory;

    public function element_maternites()
    {
        return $this->hasMany(ElementMaternites::class);
    }
}
