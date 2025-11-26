<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Warga;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['role', 'warga'])->latest();
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(10);
        $roles = Role::all();
        
        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $wargas = Warga::all();
        return view('users.create', compact('roles', 'wargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|max:20',
            'role_id' => 'required|exists:roles,id',
            'warga_id' => 'nullable|exists:warga,id',
            'status' => 'nullable|in:active,inactive,suspended',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = $validated['status'] ?? 'active';

        $user = User::create($validated);
        
        // Log activity
        $this->logActivity("Menambahkan user baru: {$user->name} ({$user->email})");

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load(['role', 'warga', 'permohonan.layanan', 'permohonan.status', 'processedPermohonan']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $wargas = Warga::all();
        return view('users.edit', compact('user', 'roles', 'wargas'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|max:20',
            'role_id' => 'required|exists:roles,id',
            'warga_id' => 'nullable|exists:warga,id',
            'status' => 'nullable|in:active,inactive,suspended',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        
        // Log activity
        $this->logActivity("Mengupdate user: {$user->name}");

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus user sendiri.');
        }
        
        $userName = $user->name;
        $user->delete();
        
        // Log activity
        $this->logActivity("Menghapus user: {$userName}");
        
        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
    
    /**
     * Bulk activate users
     */
    public function bulkActivate(Request $request)
    {
        $ids = explode(',', $request->ids);
        User::whereIn('id', $ids)->update(['status' => 'active']);
        
        $this->logActivity("Mengaktifkan " . count($ids) . " user secara bulk");
        
        return redirect()->route('users.index')
            ->with('success', count($ids) . ' user berhasil diaktifkan.');
    }
    
    /**
     * Bulk deactivate users
     */
    public function bulkDeactivate(Request $request)
    {
        $ids = explode(',', $request->ids);
        User::whereIn('id', $ids)
            ->where('id', '!=', auth()->id())
            ->update(['status' => 'inactive']);
        
        $this->logActivity("Menonaktifkan " . count($ids) . " user secara bulk");
        
        return redirect()->route('users.index')
            ->with('success', count($ids) . ' user berhasil dinonaktifkan.');
    }
    
    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $count = User::whereIn('id', $ids)
            ->where('id', '!=', auth()->id())
            ->delete();
        
        $this->logActivity("Menghapus {$count} user secara bulk");
        
        return redirect()->route('users.index')
            ->with('success', $count . ' user berhasil dihapus.');
    }
    
    /**
     * Helper method to log activity
     */
    private function logActivity($aktivitas)
    {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}