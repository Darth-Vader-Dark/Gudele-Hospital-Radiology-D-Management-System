<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\RadiologyResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalPatients = Patient::count();
        $recentPatients = Patient::latest()->limit(5)->get();
        $todayAppointments = Appointment::whereDate('scheduled_date', today())->count();
        $upcomingAppointments = Appointment::where('status', 'scheduled')
                                           ->where('scheduled_date', '>', now())
                                           ->count();

        return view('registration.dashboard', compact(
            'totalPatients',
            'recentPatients',
            'todayAppointments',
            'upcomingAppointments'
        ));
    }

    // Patient Management
    public function patients()
    {
        $patients = Patient::paginate(15);
        return view('registration.patients.index', compact('patients'));
    }

    public function searchPatients(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('patient_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        }

        $patients = $query->paginate(15);

        return view('registration.patients.search', compact('patients'));
    }

    public function createPatient()
    {
        return view('registration.patients.create');
    }

    public function storePatient(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female,Other',
            'age' => 'required|integer|min:0|max:150',
            'date_of_birth' => 'required|date|before:today',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:patients',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|in:O+,O-,A+,A-,B+,B-,AB+,AB-,Unknown',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        // Generate unique patient ID
        $validated['patient_id'] = 'RAD-' . date('Y') . '-' . str_pad(Patient::count() + 1, 5, '0', STR_PAD_LEFT);
        $validated['status'] = 'active';
        $validated['created_by'] = Auth::id();

        $patient = Patient::create($validated);

        return redirect()->route('registration.patient.view', $patient->id)
                        ->with('success', 'Patient registered successfully.');
    }

    public function viewPatient($id)
    {
        $patient = Patient::with(['appointments', 'radiologyResults', 'prescriptions'])->findOrFail($id);
        $appointments = $patient->appointments()->latest()->paginate(10);
        $radiologyResults = $patient->radiologyResults()->latest()->paginate(10);
        $prescriptions = $patient->prescriptions()->latest()->paginate(10);

        return view('registration.patients.view', compact(
            'patient',
            'appointments',
            'radiologyResults',
            'prescriptions'
        ));
    }

    public function editPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return view('registration.patients.edit', compact('patient'));
    }

    public function updatePatient(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female,Other',
            'age' => 'required|integer|min:0|max:150',
            'date_of_birth' => 'required|date|before:today',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:patients,email,' . $id,
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|in:O+,O-,A+,A-,B+,B-,AB+,AB-,Unknown',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('registration.patient.view', $patient->id)
                        ->with('success', 'Patient information updated successfully.');
    }

    // Appointment Management
    public function appointments()
    {
        $appointments = Appointment::with('patient', 'doctor')
                                   ->orderBy('scheduled_date', 'asc')
                                   ->paginate(15);

        return view('registration.appointments.index', compact('appointments'));
    }

    public function createAppointment()
    {
        $patients = Patient::where('status', 'active')->get();
        return view('registration.appointments.create', compact('patients'));
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_type' => 'required|string|max:255',
            'scheduled_date' => 'required|date|after:now',
            'reason_for_visit' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'scheduled';

        Appointment::create($validated);

        return redirect()->route('registration.appointments')
                        ->with('success', 'Appointment created successfully.');
    }

    public function editAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $patients = Patient::where('status', 'active')->get();

        return view('registration.appointments.edit', compact('appointment', 'patients'));
    }

    public function updateAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_type' => 'required|string|max:255',
            'scheduled_date' => 'required|date|after:now',
            'reason_for_visit' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:scheduled,completed,cancelled,no-show',
        ]);

        $appointment->update($validated);

        return redirect()->route('registration.appointments')
                        ->with('success', 'Appointment updated successfully.');
    }

    public function deleteAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return back()->with('success', 'Appointment deleted successfully.');
    }

    public function upcomingAppointments()
    {
        $appointments = Appointment::where('status', 'scheduled')
                                   ->where('scheduled_date', '>', now())
                                   ->with('patient', 'doctor')
                                   ->orderBy('scheduled_date', 'asc')
                                   ->paginate(15);

        return view('registration.appointments.upcoming', compact('appointments'));
    }

    // Generate Patient Summary PDF (Reception)
    public function generatePatientReport(Patient $patient)
    {
        $results = RadiologyResult::where('patient_id', $patient->id)
            ->latest()
            ->limit(5)
            ->get();

        $nextAppointment = Appointment::where('patient_id', $patient->id)
            ->where('scheduled_date', '>', now())
            ->where('status', 'scheduled')
            ->first();

        // Check if patient has data to print
        if ($results->isEmpty() && !$nextAppointment) {
            return back()->with('warning', 'No examination results or appointments to print for this patient.');
        }

        $pdf = Pdf::loadView('pdfs.patient-summary', [
            'patient' => $patient,
            'results' => $results,
            'nextAppointment' => $nextAppointment,
        ]);

        $filename = "patient_summary_{$patient->patient_id}_" . now()->format('YmdHis') . ".pdf";
        return $pdf->download($filename);
    }
}
}
