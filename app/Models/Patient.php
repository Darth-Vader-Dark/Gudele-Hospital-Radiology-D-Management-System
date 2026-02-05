<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'first_name',
        'last_name',
        'sex',
        'age',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'emergency_contact',
        'emergency_contact_phone',
        'blood_type',
        'medical_history',
        'allergies',
        'status',
        'created_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function radiologyResults()
    {
        return $this->hasMany(RadiologyResult::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
