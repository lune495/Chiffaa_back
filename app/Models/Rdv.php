<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rdv extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'creneau_id',
        'status',
    ];
    public  function creneau()
    {
        return $this->belongsTo(Creneau::class);
    }
    public  function user()
    {
        return $this->belongsTo(User::class);
    }
}
