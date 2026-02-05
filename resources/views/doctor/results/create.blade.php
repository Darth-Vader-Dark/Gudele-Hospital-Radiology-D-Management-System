@extends('layouts.app')

@section('title', 'Add Radiology Result')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-plus"></i> Add Radiology Result</h4>
                    <small class="text-white">Patient: {{ $patient->full_name }} ({{ $patient->patient_id }})</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('doctor.result.store', $patient->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="test_type" class="form-label">Test Type</label>
                                    <input type="text" class="form-control @error('test_type') is-invalid @enderror" 
                                           id="test_type" name="test_type" placeholder="e.g., Chest X-Ray, CT Scan" required>
                                    @error('test_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
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
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="findings" class="form-label">Findings</label>
                            <textarea class="form-control @error('findings') is-invalid @enderror" 
                                      id="findings" name="findings" rows="4" required></textarea>
                            @error('findings')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <textarea class="form-control @error('diagnosis') is-invalid @enderror" 
                                      id="diagnosis" name="diagnosis" rows="4" required></textarea>
                            @error('diagnosis')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="recommendations" class="form-label">Recommendations</label>
                            <textarea class="form-control @error('recommendations') is-invalid @enderror" 
                                      id="recommendations" name="recommendations" rows="3"></textarea>
                            @error('recommendations')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_path" class="form-label">Upload Image/Report (Optional)</label>
                            <input type="file" class="form-control @error('image_path') is-invalid @enderror" 
                                   id="image_path" name="image_path" accept="image/*">
                            <small class="text-muted">Supported formats: JPG, PNG, GIF (Max 2MB)</small>
                            @error('image_path')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Result
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
