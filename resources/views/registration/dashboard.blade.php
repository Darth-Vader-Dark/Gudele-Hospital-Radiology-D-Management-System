@extends('layouts.app')

@section('title', 'Registration Dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Registration Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-users" style="font-size: 30px; color: #3498db;"></i>
                <div class="stat-value">{{ $totalPatients }}</div>
                <div class="stat-label">Total Patients</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-user-plus" style="font-size: 30px; color: #e74c3c;"></i>
                <div class="stat-value">{{ $recentPatients->count() }}</div>
                <div class="stat-label">Recent Patients</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-calendar-check" style="font-size: 30px; color: #27ae60;"></i>
                <div class="stat-value">{{ $todayAppointments }}</div>
                <div class="stat-label">Today's Appointments</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-calendar-alt" style="font-size: 30px; color: #f39c12;"></i>
                <div class="stat-value">{{ $upcomingAppointments }}</div>
                <div class="stat-label">Upcoming Appointments</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-link"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('registration.patient.create') }}" class="btn btn-primary btn-sm mb-2 w-100">
                        <i class="fas fa-user-plus"></i> Register New Patient
                    </a>
                    <a href="{{ route('registration.patients') }}" class="btn btn-secondary btn-sm mb-2 w-100">
                        <i class="fas fa-list"></i> View All Patients
                    </a>
                    <a href="{{ route('registration.appointment.create') }}" class="btn btn-secondary btn-sm mb-2 w-100">
                        <i class="fas fa-calendar-plus"></i> Create Appointment
                    </a>
                    <a href="{{ route('registration.appointments') }}" class="btn btn-secondary btn-sm w-100">
                        <i class="fas fa-calendar"></i> View All Appointments
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Recently Registered Patients</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($recentPatients as $patient)
                            <a href="{{ route('registration.patient.view', $patient->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $patient->full_name }}</h6>
                                    <small>{{ $patient->patient_id }}</small>
                                </div>
                                <small class="text-muted">{{ $patient->age }} years • {{ $patient->sex }}</small>
                            </a>
                        @empty
                            <p class="text-muted text-center py-3">No patients registered</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
