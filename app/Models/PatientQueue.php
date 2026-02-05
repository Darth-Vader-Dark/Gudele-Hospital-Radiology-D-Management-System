<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'queue_number',
        'status',
        'arrived_at',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'arrived_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get all waiting patients in queue
     */
    public static function getWaitingQueue($doctorId)
    {
        return self::where('doctor_id', $doctorId)
            ->where('status', 'waiting')
            ->orderBy('queue_number')
            ->get();
    }

    /**
     * Get current patient in progress
     */
    public static function getCurrentPatient($doctorId)
    {
        return self::where('doctor_id', $doctorId)
            ->where('status', 'in_progress')
            ->first();
    }

    /**
     * Add patient to queue
     */
    public static function addToQueue($doctorId, $patientId)
    {
        $lastQueue = self::where('doctor_id', $doctorId)
            ->whereDate('created_at', today())
            ->max('queue_number') ?? 0;

        return self::create([
            'doctor_id' => $doctorId,
            'patient_id' => $patientId,
            'queue_number' => $lastQueue + 1,
            'arrived_at' => now(),
        ]);
    }

    /**
     * Start consultation with patient
     */
    public function startConsultation()
    {
        $this->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
        return $this;
    }

    /**
     * Complete consultation
     */
    public function completeConsultation($notes = null)
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'notes' => $notes,
        ]);
        return $this;
    }

    /**
     * Mark as no show
     */
    public function markNoShow()
    {
        $this->update([
            'status' => 'no_show',
            'completed_at' => now(),
        ]);
        return $this;
    }

    /**
     * Get queue statistics
     */
    public static function getQueueStats($doctorId)
    {
        $today = today();
        return [
            'waiting' => self::where('doctor_id', $doctorId)
                ->whereDate('created_at', $today)
                ->where('status', 'waiting')
                ->count(),
            'in_progress' => self::where('doctor_id', $doctorId)
                ->whereDate('created_at', $today)
                ->where('status', 'in_progress')
                ->count(),
            'completed' => self::where('doctor_id', $doctorId)
                ->whereDate('created_at', $today)
                ->where('status', 'completed')
                ->count(),
            'no_show' => self::where('doctor_id', $doctorId)
                ->whereDate('created_at', $today)
                ->where('status', 'no_show')
                ->count(),
        ];
    }
}
