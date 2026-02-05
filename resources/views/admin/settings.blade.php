@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-cog"></i> System Settings</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        System settings management. Additional configuration options will be available soon.
                    </div>

                    <div class="settings-section">
                        <h5>Hospital Information</h5>
                        <p class="text-muted">
                            <strong>Hospital Name:</strong> {{ env('HOSPITAL_NAME', 'Gudele Hospital') }}
                        </p>
                        <p class="text-muted">
                            <strong>Department:</strong> {{ env('RADIOLOGY_DEPT_NAME', 'Radiology Department') }}
                        </p>
                    </div>

                    <hr>

                    <div class="settings-section">
                        <h5>System Configuration</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Application Name:</strong> {{ env('APP_NAME') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Environment:</strong> 
                                    @if(env('APP_ENV') === 'production')
                                        <span class="badge bg-danger">Production</span>
                                    @else
                                        <span class="badge bg-warning">{{ ucfirst(env('APP_ENV')) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Debug Mode:</strong> 
                                    @if(env('APP_DEBUG') === true || env('APP_DEBUG') === 'true')
                                        <span class="badge bg-warning">Enabled</span>
                                    @else
                                        <span class="badge bg-success">Disabled</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Database:</strong> {{ env('DB_CONNECTION', 'mysql') }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="settings-section">
                        <h5>User Management</h5>
                        <p class="text-muted">
                            All users in the system must be created by an administrator. Users can only be assigned the roles of Doctor or Registration Staff.
                        </p>
                        <a href="{{ route('admin.users') }}" class="btn btn-primary">
                            <i class="fas fa-users"></i> Manage Users
                        </a>
                    </div>

                    <hr>

                    <div class="settings-section">
                        <h5>Audit Logs</h5>
                        <p class="text-muted">
                            All system activities are logged automatically. Review audit logs to track user actions and changes.
                        </p>
                        <a href="{{ route('admin.audit-logs') }}" class="btn btn-primary">
                            <i class="fas fa-history"></i> View Audit Logs
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-exclamation-circle"></i> Important Notes</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Security Reminders:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Regularly review audit logs</li>
                            <li>Deactivate inactive users</li>
                            <li>Ensure strong passwords</li>
                            <li>Monitor system performance</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> System Status</h5>
                </div>
                <div class="card-body">
                    <p><small>
                        <strong>Status:</strong> 
                        <span class="badge bg-success">Operational</span>
                    </small></p>
                    <p><small>
                        <strong>Last Backup:</strong> 
                        <span class="text-muted">Check your backup logs</span>
                    </small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
