<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\RadiologyResult;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        $todayAppointments = Appointment::where('doctor_id', $user->id)
            ->whereDate('scheduled_date', today())
            ->count();

        $upcomingAppointments = Appointment::where('doctor_id', $user->id)
            ->where('status', 'scheduled')
            ->where('scheduled_date', '>', now())
            ->count();

        $resultsAdded = RadiologyResult::where('doctor_id', $user->id)->count();
        $recentPatients = Patient::whereHas('radiologyResults', function ($q) {
            $q->where('doctor_id', Auth::id());
        })->latest()->limit(5)->get();

        return view('doctor.dashboard', compact(
            'todayAppointments',
            'upcomingAppointments',
            'resultsAdded',
            'recentPatients'
        ));
    }

    // Patient Search
    public function searchPatients(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('patient_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $patients = $query->paginate(15);

        return view('doctor.patients.search', compact('patients'));
    }

    // View Patient Details
    public function viewPatient($id)
    {
        $patient = Patient::with(['appointments', 'radiologyResults', 'prescriptions'])->findOrFail($id);
        $appointments = $patient->appointments()->latest()->paginate(10);
        $radiologyResults = $patient->radiologyResults()->latest()->paginate(10);
        $prescriptions = $patient->prescriptions()->latest()->paginate(10);

        return view('doctor.patients.view', compact(
            'patient',
            'appointments',
            'radiologyResults',
            'prescriptions'
        ));
    }

    // Add Radiology Result
    public function createResult($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $appointments = $patient->appointments()->where('status', 'scheduled')->get();

        return view('doctor.results.create', compact('patient', 'appointments'));
    }

    public function storeResult(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $validated = $request->validate([
            'test_type' => 'required|string|max:255',
            'findings' => 'required|string',
            'diagnosis' => 'required|string',
            'recommendations' => 'nullable|string',
            'appointment_id' => 'nullable|exists:appointments,id',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('radiology-images', 'public');
        }

        $validated['patient_id'] = $patientId;
        $validated['doctor_id'] = Auth::id();
        $validated['test_date'] = now();
        $validated['status'] = 'pending';

        RadiologyResult::create($validated);

        return redirect()->route('doctor.patient.view', $patientId)
                        ->with('success', 'Radiology result added successfully.');
    }

    // Add Prescription
    public function createPrescription($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $appointments = $patient->appointments()->where('status', 'scheduled')->get();

        return view('doctor.prescriptions.create', compact('patient', 'appointments'));
    }

    public function storePrescription(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $validated = $request->validate([
            'medication_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'frequency' => 'required|string|max:100',
            'duration_days' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        $validated['patient_id'] = $patientId;
        $validated['doctor_id'] = Auth::id();
        $validated['created_by'] = Auth::id();
        $validated['prescribed_date'] = now();
        $validated['expiry_date'] = now()->addDays($validated['duration_days']);
        $validated['status'] = 'active';

        Prescription::create($validated);

        return redirect()->route('doctor.patient.view', $patientId)
                        ->with('success', 'Prescription added successfully.');
    }

    // Set Next Appointment
    public function createAppointment($patientId)
    {
        $patient = Patient::findOrFail($patientId);

        return view('doctor.appointments.create', compact('patient'));
    }

    public function storeAppointment(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $validated = $request->validate([
            'appointment_type' => 'required|string|max:255',
            'scheduled_date' => 'required|date|after:now',
            'reason_for_visit' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['patient_id'] = $patientId;
        $validated['doctor_id'] = Auth::id();
        $validated['created_by'] = Auth::id();
        $validated['status'] = 'scheduled';

        Appointment::create($validated);

        return redirect()->route('doctor.patient.view', $patientId)
                        ->with('success', 'Appointment scheduled successfully.');
    }

    // View Appointments
    public function myAppointments()
    {
        $appointments = Appointment::where('doctor_id', Auth::id())
                                   ->with('patient')
                                   ->orderBy('scheduled_date', 'asc')
                                   ->paginate(15);

        return view('doctor.appointments.index', compact('appointments'));
    }

    public function updateAppointmentStatus(Request $request, $appointmentId)
    {
        $appointment = Appointment::where('doctor_id', Auth::id())->findOrFail($appointmentId);

        $validated = $request->validate([
            'status' => 'required|in:completed,cancelled,no-show',
        ]);

        $appointment->update($validated);

        return back()->with('success', 'Appointment status updated.');
    }
}
