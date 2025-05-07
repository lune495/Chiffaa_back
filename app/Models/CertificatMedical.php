<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificatMedical extends Model
{
    use HasFactory;

    protected $table = 'certificats_medicaux';

    protected $fillable = [
        'user_id',
        'patient_id',
        'date_examen',
        'motif_arret',
        'duree_repos',
        'date_debut_arret',
        'date_fin_arret',
    ];

    /**
     * Relation avec le médecin (un certificat appartient à un médecin).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le patient (un certificat appartient à un patient).
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function patient_medical()
    {
        return $this->belongsTo(PatientMedical::class);
    }
}