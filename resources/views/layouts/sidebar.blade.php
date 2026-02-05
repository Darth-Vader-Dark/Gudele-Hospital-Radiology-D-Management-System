@auth
    <div class="sidebar">
        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) active @endif">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="@if(request()->routeIs('admin.users*')) active @endif">
                <i class="fas fa-users"></i> Manage Users
            </a>
            <a href="{{ route('admin.audit-logs') }}" class="@if(request()->routeIs('admin.audit-logs*')) active @endif">
                <i class="fas fa-history"></i> Audit Logs
            </a>
            <a href="{{ route('admin.settings') }}" class="@if(request()->routeIs('admin.settings')) active @endif">
                <i class="fas fa-cog"></i> Settings
            </a>
        @elseif(Auth::user()->isDoctor())
            <a href="{{ route('doctor.dashboard') }}" class="@if(request()->routeIs('doctor.dashboard')) active @endif">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('doctor.patients.search') }}" class="@if(request()->routeIs('doctor.patients*')) active @endif">
                <i class="fas fa-search"></i> Search Patients
            </a>
            <a href="{{ route('doctor.appointments') }}" class="@if(request()->routeIs('doctor.appointments')) active @endif">
                <i class="fas fa-calendar"></i> My Appointments
            </a>
        @elseif(Auth::user()->isRegistration())
            <a href="{{ route('registration.dashboard') }}" class="@if(request()->routeIs('registration.dashboard')) active @endif">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('registration.patients') }}" class="@if(request()->routeIs('registration.patients*')) active @endif">
                <i class="fas fa-users"></i> Patients
            </a>
            <a href="{{ route('registration.patient.create') }}" class="@if(request()->routeIs('registration.patient.create')) active @endif">
                <i class="fas fa-user-plus"></i> Register Patient
            </a>
            <a href="{{ route('registration.appointments') }}" class="@if(request()->routeIs('registration.appointments*')) active @endif">
                <i class="fas fa-calendar"></i> Appointments
            </a>
            <a href="{{ route('registration.appointments.upcoming') }}" class="@if(request()->routeIs('registration.appointments.upcoming')) active @endif">
                <i class="fas fa-calendar-alt"></i> Upcoming
            </a>
        @endif
    </div>
@endauth
