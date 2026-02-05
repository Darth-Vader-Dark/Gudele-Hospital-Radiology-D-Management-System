<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalUsers = User::count();
        $doctors = User::where('role', 'doctor')->count();
        $registration = User::where('role', 'registration')->count();
        $activeUsers = User::where('status', 'active')->count();
        $recentLogs = AuditLog::latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'doctors',
            'registration',
            'activeUsers',
            'recentLogs'
        ));
    }

    // User Management
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:doctor,registration',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $this->logAudit('User Created', 'User', $user->id, null, $validated);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'role' => 'required|in:doctor,registration',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $oldValues = $user->toArray();
        $user->update($validated);

        $this->logAudit('User Updated', 'User', $user->id, $oldValues, $user->toArray());

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $oldValues = $user->toArray();

        $user->delete();

        $this->logAudit('User Deleted', 'User', $id, $oldValues, null);

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    // Audit Logs
    public function auditLogs()
    {
        $logs = AuditLog::with('user')->latest()->paginate(25);
        return view('admin.audit-logs', compact('logs'));
    }

    public function filterAuditLogs(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', "%{$request->action}%");
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(25);

        return view('admin.audit-logs', compact('logs'));
    }

    // System Settings
    public function settings()
    {
        return view('admin.settings');
    }

    protected function logAudit($action, $modelType, $modelId, $oldValues, $newValues)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
