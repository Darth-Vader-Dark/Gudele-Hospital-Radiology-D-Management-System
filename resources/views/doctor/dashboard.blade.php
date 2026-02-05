@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Doctor Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-calendar-check" style="font-size: 30px; color: #3498db;"></i>
                <div class="stat-value">{{ $todayAppointments }}</div>
                <div class="stat-label">Today's Appointments</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-calendar-alt" style="font-size: 30px; color: #e74c3c;"></i>
                <div class="stat-value">{{ $upcomingAppointments }}</div>
                <div class="stat-label">Upcoming Appointments</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-image" style="font-size: 30px; color: #27ae60;"></i>
                <div class="stat-value">{{ $resultsAdded }}</div>
                <div class="stat-label">Results Added</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-user-injured" style="font-size: 30px; color: #f39c12;"></i>
                <div class="stat-value">{{ $recentPatients->count() }}</div>
                <div class="stat-label">Recent Patients</div>
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
                    <a href="{{ route('doctor.queue') }}" class="btn btn-danger btn-sm mb-2 w-100">
                        <i class="fas fa-hospital-user"></i> Patient Queue
                    </a>
                    <a href="{{ route('doctor.patients.search') }}" class="btn btn-primary btn-sm mb-2 w-100">
                        <i class="fas fa-search"></i> Search Patients
                    </a>
                    <a href="{{ route('doctor.appointments') }}" class="btn btn-secondary btn-sm mb-2 w-100">
                        <i class="fas fa-calendar"></i> View Appointments
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Recent Patients</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($recentPatients as $patient)
                            <a href="{{ route('doctor.patient.view', $patient->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $patient->full_name }}</h6>
                                    <small>{{ $patient->patient_id }}</small>
                                </div>
                                <small class="text-muted">{{ $patient->age }} years old • {{ $patient->sex }}</small>
                            </a>
                        @empty
                            <p class="text-muted text-center py-3">No recent patients</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
