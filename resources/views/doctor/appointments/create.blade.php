@extends('layouts.app')

@section('title', 'Schedule Appointment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-calendar-plus"></i> Schedule Appointment</h4>
                    <small class="text-white">Patient: {{ $patient->full_name }} ({{ $patient->patient_id }})</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('doctor.appointment.store', $patient->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="appointment_type" class="form-label">Appointment Type</label>
                            <input type="text" class="form-control @error('appointment_type') is-invalid @enderror" 
                                   id="appointment_type" name="appointment_type" placeholder="e.g., Follow-up, Consultation" required>
                            @error('appointment_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="scheduled_date" class="form-label">Date & Time</label>
                                    <input type="datetime-local" class="form-control @error('scheduled_date') is-invalid @enderror" 
                                           id="scheduled_date" name="scheduled_date" required>
                                    @error('scheduled_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reason_for_visit" class="form-label">Reason for Visit</label>
                                    <input type="text" class="form-control @error('reason_for_visit') is-invalid @enderror" 
                                           id="reason_for_visit" name="reason_for_visit">
                                    @error('reason_for_visit')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3"></textarea>
                            @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Schedule Appointment
                            </button>
                            <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
