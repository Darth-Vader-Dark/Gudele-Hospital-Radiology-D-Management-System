@extends('layouts.app')

@section('title', 'Edit Patient - ' . $patient->full_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit Patient Information</h4>
                    <small class="text-white">{{ $patient->patient_id }}</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('registration.patient.update', $patient->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required>
                                    @error('first_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required>
                                    @error('last_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="sex" class="form-label">Sex</label>
                                    <select class="form-control @error('sex') is-invalid @enderror" 
                                            id="sex" name="sex" required>
                                        <option value="Male" @if(old('sex', $patient->sex) === 'Male') selected @endif>Male</option>
                                        <option value="Female" @if(old('sex', $patient->sex) === 'Female') selected @endif>Female</option>
                                        <option value="Other" @if(old('sex', $patient->sex) === 'Other') selected @endif>Other</option>
                                    </select>
                                    @error('sex')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" required>
                                    @error('date_of_birth')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" class="form-control @error('age') is-invalid @enderror" 
                                           id="age" name="age" value="{{ old('age', $patient->age) }}" min="0" max="150" required>
                                    @error('age')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="blood_type" class="form-label">Blood Type</label>
                                    <select class="form-control @error('blood_type') is-invalid @enderror" 
                                            id="blood_type" name="blood_type">
                                        <option value="">-- Select --</option>
                                        <option value="O+" @if(old('blood_type', $patient->blood_type) === 'O+') selected @endif>O+</option>
                                        <option value="O-" @if(old('blood_type', $patient->blood_type) === 'O-') selected @endif>O-</option>
                                        <option value="A+" @if(old('blood_type', $patient->blood_type) === 'A+') selected @endif>A+</option>
                                        <option value="A-" @if(old('blood_type', $patient->blood_type) === 'A-') selected @endif>A-</option>
                                        <option value="B+" @if(old('blood_type', $patient->blood_type) === 'B+') selected @endif>B+</option>
                                        <option value="B-" @if(old('blood_type', $patient->blood_type) === 'B-') selected @endif>B-</option>
                                        <option value="AB+" @if(old('blood_type', $patient->blood_type) === 'AB+') selected @endif>AB+</option>
                                        <option value="AB-" @if(old('blood_type', $patient->blood_type) === 'AB-') selected @endif>AB-</option>
                                        <option value="Unknown" @if(old('blood_type', $patient->blood_type) === 'Unknown') selected @endif>Unknown</option>
                                    </select>
                                    @error('blood_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $patient->phone) }}">
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $patient->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city', $patient->city) }}">
                                    @error('city')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                           id="state" name="state" value="{{ old('state', $patient->state) }}">
                                    @error('state')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Full Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="2">{{ old('address', $patient->address) }}</textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact" class="form-label">Emergency Contact Name</label>
                                    <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                                           id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact) }}">
                                    @error('emergency_contact')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_phone" class="form-label">Emergency Contact Phone</label>
                                    <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                           id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}">
                                    @error('emergency_contact_phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="medical_history" class="form-label">Medical History</label>
                            <textarea class="form-control @error('medical_history') is-invalid @enderror" 
                                      id="medical_history" name="medical_history" rows="2">{{ old('medical_history', $patient->medical_history) }}</textarea>
                            @error('medical_history')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="allergies" class="form-label">Known Allergies</label>
                            <textarea class="form-control @error('allergies') is-invalid @enderror" 
                                      id="allergies" name="allergies" rows="2">{{ old('allergies', $patient->allergies) }}</textarea>
                            @error('allergies')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Patient
                            </button>
                            <a href="{{ route('registration.patient.view', $patient->id) }}" class="btn btn-secondary">
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
