<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\RadiologyResult;
use App\Models\Prescription;
use App\Models\PatientQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $validated['duration_days'] = (int) $validated['duration_days'];
        $validated['expiry_date'] = now()->addDays((int) $validated['duration_days']);
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

    // Queue Management
    public function queue()
    {
        $user = Auth::user();
        $waitingQueue = PatientQueue::getWaitingQueue($user->id);
        $currentPatient = PatientQueue::getCurrentPatient($user->id);
        $queueStats = PatientQueue::getQueueStats($user->id);
        $recentlyCompleted = PatientQueue::where('doctor_id', $user->id)
            ->whereDate('created_at', today())
            ->where('status', 'completed')
            ->latest('completed_at')
            ->limit(5)
            ->get();

        return view('doctor.queue', compact('waitingQueue', 'currentPatient', 'queueStats', 'recentlyCompleted'));
    }

    public function addToQueue(Patient $patient)
    {
        $user = Auth::user();

        // Check if patient is already in queue
        $existingQueue = PatientQueue::where('doctor_id', $user->id)
            ->where('patient_id', $patient->id)
            ->whereIn('status', ['waiting', 'in_progress'])
            ->first();

        if ($existingQueue) {
            return back()->with('warning', 'Patient is already in the queue.');
        }

        PatientQueue::addToQueue($user->id, $patient->id);

        return back()->with('success', "Patient {$patient->first_name} {$patient->last_name} added to queue.");
    }

    public function startConsultation(PatientQueue $queue)
    {
        $this->authorizeDoctor($queue->doctor_id);

        // End any previous consultation
        $previous = PatientQueue::where('doctor_id', $queue->doctor_id)
            ->where('status', 'in_progress')
            ->first();

        if ($previous) {
            $previous->completeConsultation();
        }

        $queue->startConsultation();

        return back()->with('success', 'Consultation started with ' . $queue->patient->first_name);
    }

    public function completeConsultation(PatientQueue $queue, Request $request)
    {
        $this->authorizeDoctor($queue->doctor_id);

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $queue->completeConsultation($validated['notes'] ?? null);

        return back()->with('success', 'Consultation completed.');
    }

    public function markNoShow(PatientQueue $queue)
    {
        $this->authorizeDoctor($queue->doctor_id);

        $queue->markNoShow();

        return back()->with('warning', 'Patient marked as no show.');
    }

    public function removeFromQueue(PatientQueue $queue)
    {
        $this->authorizeDoctor($queue->doctor_id);

        $patientName = $queue->patient->first_name . ' ' . $queue->patient->last_name;
        $queue->delete();

        return back()->with('success', "{$patientName} removed from queue.");
    }

    private function authorizeDoctor($doctorId)
    {
        if (Auth::id() !== $doctorId) {
            abort(403, 'Unauthorized action.');
        }
    }

    // PDF Generation Methods
    public function generateReport(Patient $patient)
    {
        $doctor = Auth::user();
        
        // Get results and prescriptions for this patient
        $results = RadiologyResult::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->latest()
            ->get();

        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->latest()
            ->get();

        // Check if report has content
        if ($results->isEmpty() && $prescriptions->isEmpty()) {
            return back()->with('warning', 'No results or prescriptions to print. Please add examination data first.');
        }

        $pdf = Pdf::loadView('pdfs.doctor-report', [
            'patient' => $patient,
            'doctor' => $doctor,
            'results' => $results,
            'prescriptions' => $prescriptions,
        ]);

        $filename = "radiology_report_{$patient->patient_id}_" . now()->format('YmdHis') . ".pdf";
        return $pdf->download($filename);
    }

    public function generatePatientSummary(Patient $patient)
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


