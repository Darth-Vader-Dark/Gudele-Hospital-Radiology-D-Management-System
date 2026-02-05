<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\RegistrationController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('password.change');
    
    // Session activity tracking
    Route::get('/session-activity', function () {
        return response()->noContent();
    })->name('session.activity');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('user.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('user.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('user.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('user.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('user.delete');

    // Audit Logs
    Route::get('/audit-logs', [AdminController::class, 'auditLogs'])->name('audit-logs');
    Route::get('/audit-logs/filter', [AdminController::class, 'filterAuditLogs'])->name('audit-logs.filter');

    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');

    // Queue Management
    Route::get('/queue', [DoctorController::class, 'queue'])->name('queue');
    Route::post('/queue/add/{patient}', [DoctorController::class, 'addToQueue'])->name('queue.add');
    Route::post('/queue/{queue}/start', [DoctorController::class, 'startConsultation'])->name('queue.start');
    Route::post('/queue/{queue}/complete', [DoctorController::class, 'completeConsultation'])->name('queue.complete');
    Route::post('/queue/{queue}/no-show', [DoctorController::class, 'markNoShow'])->name('queue.noshow');
    Route::delete('/queue/{queue}', [DoctorController::class, 'removeFromQueue'])->name('queue.remove');

    // Patient Management
    Route::get('/patients/search', [DoctorController::class, 'searchPatients'])->name('patients.search');
    Route::get('/patients/{patient}', [DoctorController::class, 'viewPatient'])->name('patient.view');
    Route::get('/patients/{patient}/generate-report', [DoctorController::class, 'generateReport'])->name('patient.report');
    Route::get('/patients/{patient}/summary-pdf', [DoctorController::class, 'generatePatientSummary'])->name('patient.summary-pdf');

    // Radiology Results
    Route::get('/patients/{patient}/results/create', [DoctorController::class, 'createResult'])->name('result.create');
    Route::post('/patients/{patient}/results', [DoctorController::class, 'storeResult'])->name('result.store');

    // Prescriptions
    Route::get('/patients/{patient}/prescriptions/create', [DoctorController::class, 'createPrescription'])->name('prescription.create');
    Route::post('/patients/{patient}/prescriptions', [DoctorController::class, 'storePrescription'])->name('prescription.store');

    // Appointments
    Route::get('/appointments', [DoctorController::class, 'myAppointments'])->name('appointments');
    Route::get('/patients/{patient}/appointments/create', [DoctorController::class, 'createAppointment'])->name('appointment.create');
    Route::post('/patients/{patient}/appointments', [DoctorController::class, 'storeAppointment'])->name('appointment.store');
    Route::put('/appointments/{appointment}/status', [DoctorController::class, 'updateAppointmentStatus'])->name('appointment.status');
});

// Registration/Reception Routes
Route::middleware(['auth', 'role:registration'])->prefix('registration')->name('registration.')->group(function () {
    Route::get('/dashboard', [RegistrationController::class, 'dashboard'])->name('dashboard');

    // Patient Management
    Route::get('/patients', [RegistrationController::class, 'patients'])->name('patients');
    Route::get('/patients/search', [RegistrationController::class, 'searchPatients'])->name('patients.search');
    Route::get('/patients/create', [RegistrationController::class, 'createPatient'])->name('patient.create');
    Route::post('/patients', [RegistrationController::class, 'storePatient'])->name('patient.store');
    Route::get('/patients/{patient}', [RegistrationController::class, 'viewPatient'])->name('patient.view');
    Route::get('/patients/{patient}/edit', [RegistrationController::class, 'editPatient'])->name('patient.edit');
    Route::put('/patients/{patient}', [RegistrationController::class, 'updatePatient'])->name('patient.update');
    Route::get('/patients/{patient}/report-pdf', [RegistrationController::class, 'generatePatientReport'])->name('patient.report-pdf');

    // Appointment Management
    Route::get('/appointments', [RegistrationController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/upcoming', [RegistrationController::class, 'upcomingAppointments'])->name('appointments.upcoming');
    Route::get('/appointments/create', [RegistrationController::class, 'createAppointment'])->name('appointment.create');
    Route::post('/appointments', [RegistrationController::class, 'storeAppointment'])->name('appointment.store');
    Route::get('/appointments/{appointment}/edit', [RegistrationController::class, 'editAppointment'])->name('appointment.edit');
    Route::put('/appointments/{appointment}', [RegistrationController::class, 'updateAppointment'])->name('appointment.update');
    Route::delete('/appointments/{appointment}', [RegistrationController::class, 'deleteAppointment'])->name('appointment.delete');
});

// Root redirect
Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route(auth()->user()->role . '.dashboard')
        : redirect()->route('login');
})->name('home');
