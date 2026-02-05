<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiologyResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'test_type',
        'findings',
        'diagnosis',
        'recommendations',
        'image_path',
        'status',
        'test_date',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'test_date' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
