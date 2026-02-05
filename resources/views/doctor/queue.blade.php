@extends('layouts.app')

@section('title', 'Patient Queue')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">Patient Queue Management</h1>
        </div>
    </div>

    <!-- Queue Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ $queueStats['waiting'] }}</div>
                <div class="stat-label">Waiting</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-info">{{ $queueStats['in_progress'] }}</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-success">{{ $queueStats['completed'] }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ $queueStats['no_show'] }}</div>
                <div class="stat-label">No Show</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Current Patient -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Current Patient</h5>
                </div>
                <div class="card-body">
                    @if($currentPatient)
                        <div class="alert alert-info mb-3">
                            <h6 class="mb-2"><i class="fas fa-circle-notch fa-spin"></i> Now Serving</h6>
                        </div>
                        <div class="patient-card mb-3">
                            <p class="mb-2">
                                <strong>Patient:</strong> {{ $currentPatient->patient->first_name }} {{ $currentPatient->patient->last_name }}
                            </p>
                            <p class="mb-2">
                                <strong>Patient ID:</strong> {{ $currentPatient->patient->patient_id }}
                            </p>
                            <p class="mb-2">
                                <strong>Age:</strong> {{ $currentPatient->patient->age }} years
                            </p>
                            <p class="mb-3">
                                <strong>Started At:</strong> {{ $currentPatient->started_at->format('H:i:s') }}
                            </p>
                            <form action="{{ route('doctor.queue.complete', $currentPatient->id) }}" method="POST" class="mb-2">
                                @csrf
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Consultation Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Add any notes..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check"></i> Complete Consultation
                                </button>
                            </form>
                            <form action="{{ route('doctor.queue.noshow', $currentPatient->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Mark as no show?')">
                                    <i class="fas fa-times"></i> Mark as No Show
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-secondary text-center py-5">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            <p class="mb-0">No patient currently being served</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Waiting Queue -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Waiting Queue</h5>
                    <span class="badge bg-primary">{{ $waitingQueue->count() }}</span>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    @if($waitingQueue->count() > 0)
                        <div class="list-group">
                            @foreach($waitingQueue as $queue)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="mb-2">
                                                <span class="badge bg-secondary me-2">#{{ $queue->queue_number }}</span>
                                                <strong>{{ $queue->patient->first_name }} {{ $queue->patient->last_name }}</strong>
                                            </div>
                                            <p class="mb-1 small text-muted">
                                                <i class="fas fa-id-card"></i> {{ $queue->patient->patient_id }}
                                            </p>
                                            <p class="mb-0 small text-muted">
                                                <i class="fas fa-clock"></i> Arrived: {{ $queue->arrived_at->format('H:i') }}
                                            </p>
                                        </div>
                                        <div class="btn-group-vertical ms-2" role="group">
                                            <form action="{{ route('doctor.queue.start', $queue->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary" title="Start consultation">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('doctor.queue.remove', $queue->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Remove from queue" onclick="return confirm('Remove from queue?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-users fa-2x mb-2 d-block"></i>
                            <p class="mb-0">No patients in queue</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recently Completed -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recently Completed (Today)</h5>
                </div>
                <div class="card-body">
                    @if($recentlyCompleted->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Queue #</th>
                                        <th>Patient Name</th>
                                        <th>Patient ID</th>
                                        <th>Completed At</th>
                                        <th>Duration</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentlyCompleted as $queue)
                                        <tr>
                                            <td><span class="badge bg-success">#{{ $queue->queue_number }}</span></td>
                                            <td>{{ $queue->patient->first_name }} {{ $queue->patient->last_name }}</td>
                                            <td>{{ $queue->patient->patient_id }}</td>
                                            <td>{{ $queue->completed_at->format('H:i:s') }}</td>
                                            <td>
                                                @if($queue->started_at && $queue->completed_at)
                                                    {{ $queue->completed_at->diffInMinutes($queue->started_at) }} min
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($queue->notes, 50) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted py-3">No completed consultations today</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .patient-card {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        border-left: 4px solid #3498db;
    }

    .list-group-item {
        padding: 12px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
