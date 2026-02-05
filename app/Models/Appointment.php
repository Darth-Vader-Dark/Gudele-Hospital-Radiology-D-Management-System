<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_type',
        'scheduled_date',
        'status',
        'notes',
        'reason_for_visit',
        'created_by',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function radiologyResults()
    {
        return $this->hasMany(RadiologyResult::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function isUpcoming()
    {
        return $this->status === 'scheduled' && $this->scheduled_date->isFuture();
    }

    public function isPast()
    {
        return $this->scheduled_date->isPast();
    }
}
