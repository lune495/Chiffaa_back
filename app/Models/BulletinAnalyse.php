<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulletinAnalyse extends Model
{
    use HasFactory;

    protected $table = 'bulletin_analyses';

    protected $fillable = [
        'patient_id',
        'diagnostic',
        'user_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function element_bulletin_analyses()
    {
        return $this->HasMany(ElementBulletinAnalyse::class);
    }
}