<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'medication_name',
        'dosage',
        'frequency',
        'duration_days',
        'instructions',
        'status',
        'prescribed_date',
        'expiry_date',
        'created_by',
    ];

    protected $casts = [
        'prescribed_date' => 'datetime',
        'expiry_date' => 'datetime',
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->expiry_date->isFuture();
    }

    public function isExpired()
    {
        return $this->expiry_date->isPast();
    }
}
