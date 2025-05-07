<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementBulletinAnalyse extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'bulletin_analyse_id',
        'diagnostic',
        'user_id',
        'type_service_id',
    ];

    public function bulletin_analyse()
    {
        return $this->belongsTo(BulletinAnalyse::class);
    }

    public function type_service()
    {
        return $this->belongsTo(TypeService::class);
    }
}