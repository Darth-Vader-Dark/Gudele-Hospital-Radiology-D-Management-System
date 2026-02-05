@extends('layouts.app')

@section('title', 'Patient Details - ' . $patient->full_name)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="fas fa-user-injured"></i> {{ $patient->full_name }}</h2>
            <p class="text-muted">Patient ID: {{ $patient->patient_id }}</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('doctor.result.create', $patient->id) }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Radiology Result
            </a>
            <a href="{{ route('doctor.prescription.create', $patient->id) }}" class="btn btn-warning">
                <i class="fas fa-prescription-bottle"></i> Add Prescription
            </a>
            <a href="{{ route('doctor.appointment.create', $patient->id) }}" class="btn btn-info">
                <i class="fas fa-calendar-plus"></i> Schedule Appointment
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Patient Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth->format('M d, Y') }}</p>
                    <p><strong>Age:</strong> {{ $patient->age }} years</p>
                    <p><strong>Sex:</strong> {{ $patient->sex }}</p>
                    <p><strong>Blood Type:</strong> {{ $patient->blood_type ?? 'Unknown' }}</p>
                    <p><strong>Phone:</strong> {{ $patient->phone ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $patient->email ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $patient->address ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> 
                        @if($patient->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-exclamation"></i> Medical Info</h5>
                </div>
                <div class="card-body">
                    <p><strong>Medical History:</strong></p>
                    <p>{{ $patient->medical_history ?? 'None recorded' }}</p>
                    <p><strong>Allergies:</strong></p>
                    <p>{{ $patient->allergies ?? 'None recorded' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="results-tab" data-bs-toggle="tab" data-bs-target="#results" type="button">
                        <i class="fas fa-image"></i> Radiology Results
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="prescriptions-tab" data-bs-toggle="tab" data-bs-target="#prescriptions" type="button">
                        <i class="fas fa-prescription-bottle"></i> Prescriptions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#appointments" type="button">
                        <i class="fas fa-calendar"></i> Appointments
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Radiology Results -->
                <div class="tab-pane fade show active" id="results" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            @forelse($radiologyResults as $result)
                                <div class="border-bottom pb-3 mb-3">
                                    <h6>{{ $result->test_type }}</h6>
                                    <p class="text-muted"><small>{{ $result->test_date->format('M d, Y H:i') }}</small></p>
                                    <p><strong>Findings:</strong> {{ Str::limit($result->findings, 200) }}</p>
                                    <p><strong>Diagnosis:</strong> {{ Str::limit($result->diagnosis, 200) }}</p>
                                    <p>
                                        <span class="badge bg-info">{{ ucfirst($result->status) }}</span>
                                    </p>
                                </div>
                            @empty
                                <p class="text-muted text-center">No radiology results recorded</p>
                            @endforelse

                            @if($radiologyResults->count() > 0)
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $radiologyResults->links('pagination::bootstrap-4') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Prescriptions -->
                <div class="tab-pane fade" id="prescriptions" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            @forelse($prescriptions as $prescription)
                                <div class="border-bottom pb-3 mb-3">
                                    <h6>{{ $prescription->medication_name }}</h6>
                                    <p><small class="text-muted">{{ $prescription->dosage }} • {{ $prescription->frequency }}</small></p>
                                    <p><strong>Duration:</strong> {{ $prescription->duration_days }} days</p>
                                    <p><strong>Instructions:</strong> {{ $prescription->instructions ?? 'None' }}</p>
                                    <p>
                                        @if($prescription->isActive())
                                            <span class="badge bg-success">Active</span>
                                        @elseif($prescription->isExpired())
                                            <span class="badge bg-danger">Expired</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($prescription->status) }}</span>
                                        @endif
                                    </p>
                                </div>
                            @empty
                                <p class="text-muted text-center">No prescriptions recorded</p>
                            @endforelse

                            @if($prescriptions->count() > 0)
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $prescriptions->links('pagination::bootstrap-4') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Appointments -->
                <div class="tab-pane fade" id="appointments" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            @forelse($appointments as $appointment)
                                <div class="border-bottom pb-3 mb-3">
                                    <h6>{{ $appointment->appointment_type }}</h6>
                                    <p class="text-muted"><small>{{ $appointment->scheduled_date->format('M d, Y H:i') }}</small></p>
                                    <p><strong>Reason:</strong> {{ $appointment->reason_for_visit ?? 'N/A' }}</p>
                                    <p>
                                        @if($appointment->status === 'scheduled')
                                            <span class="badge bg-info">Scheduled</span>
                                        @elseif($appointment->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($appointment->status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-warning">No-show</span>
                                        @endif
                                    </p>
                                </div>
                            @empty
                                <p class="text-muted text-center">No appointments recorded</p>
                            @endforelse

                            @if($appointments->count() > 0)
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $appointments->links('pagination::bootstrap-4') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
<script>
    // Bootstrap tab functionality
    var triggerTabList = [].slice.call(document.querySelectorAll('#tabs a, .nav-link'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })
</script>
@endsection
@endsection
