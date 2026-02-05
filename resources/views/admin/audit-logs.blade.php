@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-history"></i> Audit Logs</h2>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.audit-logs.filter') }}" class="row g-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="action" placeholder="Filter by action" 
                           value="{{ request('action') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="date_from" placeholder="From date" 
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="date_to" placeholder="To date" 
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
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
                            <th>User</th>
                            <th>Action</th>
                            <th>Model Type</th>
                            <th>IP Address</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <strong>{{ $log->user->name ?? 'N/A' }}</strong>
                                    <br><small class="text-muted">{{ $log->user->email ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $log->action }}</span>
                                </td>
                                <td>{{ $log->model_type ?? 'N/A' }}</td>
                                <td><small>{{ $log->ip_address }}</small></td>
                                <td>
                                    <small>{{ $log->created_at->format('M d, Y H:i') }}</small>
                                    <br><small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No logs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $logs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
