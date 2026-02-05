@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-calendar"></i> My Appointments</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Type</th>
                            <th>Date & Time</th>
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
                                    <a href="{{ route('doctor.patient.view', $appointment->patient->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($appointment->status === 'scheduled' && $appointment->scheduled_date->isPast())
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" 
                                                    data-bs-target="#statusModal{{ $appointment->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>

                                        <!-- Status Modal -->
                                        <div class="modal fade" id="statusModal{{ $appointment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Appointment Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST" action="{{ route('doctor.appointment.status', $appointment->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-control" name="status" required>
                                                                    <option value="completed">Completed</option>
                                                                    <option value="cancelled">Cancelled</option>
                                                                    <option value="no-show">No-show</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No appointments</td>
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
