@extends('layouts.app')

@section('title', 'Upcoming Appointments')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="fas fa-calendar-alt"></i> Upcoming Appointments</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('registration.appointments') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> All Appointments
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($appointments->count() > 0)
                <div class="row">
                    @foreach($appointments as $appointment)
                        <div class="col-md-6 mb-3">
                            <div class="card border-left border-primary">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $appointment->patient->full_name }}</h5>
                                    <p class="card-text text-muted">{{ $appointment->patient->patient_id }}</p>
                                    
                                    <div class="mb-2">
                                        <strong>Date & Time:</strong> 
                                        <br>{{ $appointment->scheduled_date->format('l, F d, Y \a\t g:i A') }}
                                    </div>

                                    <div class="mb-2">
                                        <strong>Type:</strong> {{ $appointment->appointment_type }}
                                    </div>

                                    <div class="mb-2">
                                        <strong>Reason:</strong> {{ $appointment->reason_for_visit ?? 'N/A' }}
                                    </div>

                                    <div class="mb-2">
                                        <strong>Doctor:</strong> {{ $appointment->doctor->name ?? 'Not assigned' }}
                                    </div>

                                    <div class="mb-3">
                                        <strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($appointment->status) }}</span>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('registration.appointment.edit', $appointment->id) }}" class="btn btn-sm btn-primary flex-grow-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('registration.patient.view', $appointment->patient->id) }}" class="btn btn-sm btn-secondary flex-grow-1">
                                            <i class="fas fa-user"></i> Patient
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $appointments->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-check-circle"></i> No upcoming appointments scheduled
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
