@extends('layouts.app')

@section('title', 'Search Patients')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-search"></i> Search Patients</h2>

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
                                <td colspan="7" class="text-center text-muted">
                                    @if(request('search'))
                                        No patients found matching your search
                                    @else
                                        Enter search criteria to find patients
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($patients->count() > 0)
                <div class="d-flex justify-content-center mt-4">
                    {{ $patients->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
