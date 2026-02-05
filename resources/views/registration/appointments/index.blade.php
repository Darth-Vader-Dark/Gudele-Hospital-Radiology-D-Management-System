@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="fas fa-calendar"></i> All Appointments</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('registration.appointment.create') }}" class="btn btn-primary">
                <i class="fas fa-calendar-plus"></i> Create Appointment
            </a>
            <a href="{{ route('registration.appointments.upcoming') }}" class="btn btn-info">
                <i class="fas fa-calendar-alt"></i> Upcoming
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Type</th>
                            <th>Date & Time</th>
                            <th>Doctor</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>
                                    <strong>{{ $appointment->patient->full_name }}</strong>
                                    <br><small class="text-muted">{{ $appointment->patient->patient_id }}</small>
                                </td>
                                <td>{{ $appointment->appointment_type }}</td>
                                <td>{{ $appointment->scheduled_date->format('M d, Y H:i') }}</td>
                                <td>{{ $appointment->doctor->name ?? 'Not assigned' }}</td>
                                <td><small>{{ $appointment->reason_for_visit ?? 'N/A' }}</small></td>
                                <td>
                                    @if($appointment->status === 'scheduled')
                                        <span class="badge bg-info">Scheduled</span>
                                    @elseif($appointment->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($appointment->status === 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-warning">No-show</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('registration.appointment.edit', $appointment->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('registration.appointment.delete', $appointment->id) }}" 
                                          style="display:inline-block;" 
                                          onsubmit="return confirm('Delete appointment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No appointments</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($appointments->count() > 0)
                <div class="d-flex justify-content-center mt-4">
                    {{ $appointments->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
