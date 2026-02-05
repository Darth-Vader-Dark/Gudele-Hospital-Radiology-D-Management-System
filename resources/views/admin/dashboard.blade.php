@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-users" style="font-size: 30px; color: #3498db;"></i>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-user-md" style="font-size: 30px; color: #e74c3c;"></i>
                <div class="stat-value">{{ $doctors }}</div>
                <div class="stat-label">Doctors</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-clipboard" style="font-size: 30px; color: #27ae60;"></i>
                <div class="stat-value">{{ $registration }}</div>
                <div class="stat-label">Registration Staff</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-check-circle" style="font-size: 30px; color: #f39c12;"></i>
                <div class="stat-value">{{ $activeUsers }}</div>
                <div class="stat-label">Active Users</div>
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
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm mb-2 w-100">
                        <i class="fas fa-plus"></i> Add New User
                    </a>
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary btn-sm mb-2 w-100">
                        <i class="fas fa-list"></i> Manage Users
                    </a>
                    <a href="{{ route('admin.audit-logs') }}" class="btn btn-secondary btn-sm mb-2 w-100">
                        <i class="fas fa-history"></i> View Audit Logs
                    </a>
                    <a href="{{ route('admin.settings') }}" class="btn btn-secondary btn-sm w-100">
                        <i class="fas fa-cog"></i> System Settings
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Recent Audit Logs</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLogs as $log)
                                    <tr>
                                        <td>
                                            <small>{{ $log->user->name ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $log->action }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $log->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No logs available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
