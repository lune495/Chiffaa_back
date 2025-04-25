<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'medecin_id', 
        'creneau_id', 
        'type', 
        'message',
        'is_read',
        'created_at', 
        'updated_at'
    ];

    public  function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public  function creneau()
    {
        return $this->belongsTo(Creneau::class);
    }
}
