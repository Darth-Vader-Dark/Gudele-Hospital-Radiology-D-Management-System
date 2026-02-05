@extends('layouts.app')

@section('title', 'Create Appointment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-calendar-plus"></i> Create Appointment</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('registration.appointment.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="patient_id" class="form-label">Patient</label>
                            <select class="form-control @error('patient_id') is-invalid @enderror" 
                                    id="patient_id" name="patient_id" required>
                                <option value="">-- Select Patient --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" @if(old('patient_id') == $patient->id) selected @endif>
                                        {{ $patient->full_name }} ({{ $patient->patient_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appointment_type" class="form-label">Appointment Type</label>
                                    <input type="text" class="form-control @error('appointment_type') is-invalid @enderror" 
                                           id="appointment_type" name="appointment_type" placeholder="e.g., Radiology, Consultation" 
                                           value="{{ old('appointment_type') }}" required>
                                    @error('appointment_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="scheduled_date" class="form-label">Date & Time</label>
                                    <input type="datetime-local" class="form-control @error('scheduled_date') is-invalid @enderror" 
                                           id="scheduled_date" name="scheduled_date" value="{{ old('scheduled_date') }}" required>
                                    @error('scheduled_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reason_for_visit" class="form-label">Reason for Visit</label>
                            <textarea class="form-control @error('reason_for_visit') is-invalid @enderror" 
                                      id="reason_for_visit" name="reason_for_visit" rows="2" 
                                      placeholder="e.g., Annual checkup, Follow-up">{{ old('reason_for_visit') }}</textarea>
                            @error('reason_for_visit')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Appointment
                            </button>
                            <a href="{{ route('registration.appointments') }}" class="btn btn-secondary">
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
