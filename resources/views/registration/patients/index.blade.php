@extends('layouts.app')

@section('title', 'Patients')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="fas fa-users"></i> Patients</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('registration.patient.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Register New Patient
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('registration.patients.search') }}" class="row g-3">
                <div class="col-md-9">
                    <input type="text" class="form-control" name="search" placeholder="Search by name, ID, email, or phone" 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Contact</th>
                            <th>Registered</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td><strong>{{ $patient->patient_id }}</strong></td>
                                <td>{{ $patient->full_name }}</td>
                                <td>{{ $patient->age }}</td>
                                <td>{{ $patient->sex }}</td>
                                <td>
                                    @if($patient->phone)
                                        <small>{{ $patient->phone }}</small>
                                    @else
                                        <small class="text-muted">N/A</small>
                                    @endif
                                </td>
                                <td><small>{{ $patient->created_at->format('M d, Y') }}</small></td>
                                <td>
                                    @if($patient->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('registration.patient.view', $patient->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('registration.patient.edit', $patient->id) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No patients found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($patients->count() > 0)
                <div class="d-flex justify-content-center mt-4">
                    {{ $patients->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
