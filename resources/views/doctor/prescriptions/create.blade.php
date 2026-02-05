@extends('layouts.app')

@section('title', 'Add Prescription')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-prescription-bottle"></i> Add Prescription</h4>
                    <small class="text-white">Patient: {{ $patient->full_name }} ({{ $patient->patient_id }})</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('doctor.prescription.store', $patient->id) }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="medication_name" class="form-label">Medication Name</label>
                                    <input type="text" class="form-control @error('medication_name') is-invalid @enderror" 
                                           id="medication_name" name="medication_name" required>
                                    @error('medication_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dosage" class="form-label">Dosage</label>
                                    <input type="text" class="form-control @error('dosage') is-invalid @enderror" 
                                           id="dosage" name="dosage" placeholder="e.g., 500mg, 10ml" required>
                                    @error('dosage')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="frequency" class="form-label">Frequency</label>
                                    <input type="text" class="form-control @error('frequency') is-invalid @enderror" 
                                           id="frequency" name="frequency" placeholder="e.g., Twice daily, Every 8 hours" required>
                                    @error('frequency')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration_days" class="form-label">Duration (Days)</label>
                                    <input type="number" class="form-control @error('duration_days') is-invalid @enderror" 
                                           id="duration_days" name="duration_days" min="1" required>
                                    @error('duration_days')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="instructions" class="form-label">Instructions (Optional)</label>
                            <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                      id="instructions" name="instructions" rows="3" placeholder="e.g., Take with food, Do not take with milk"></textarea>
                            @error('instructions')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="appointment_id" class="form-label">Related Appointment (Optional)</label>
                            <select class="form-control @error('appointment_id') is-invalid @enderror" 
                                    id="appointment_id" name="appointment_id">
                                <option value="">-- Select Appointment --</option>
                                @foreach($appointments as $appointment)
                                    <option value="{{ $appointment->id }}">
                                        {{ $appointment->appointment_type }} - {{ $appointment->scheduled_date->format('M d, Y') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('appointment_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Prescription
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
