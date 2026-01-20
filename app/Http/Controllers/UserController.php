<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Warga;
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
            'nik' => 'required|numeric|digits:16|unique:users',
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
            'nik' => 'required|numeric|digits:16|unique:users,nik,' . $user->id,
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
     * Tampilan profil user saat ini
     */
    public function profile()
    {
        $user = auth()->user();
        $user->load(['role', 'warga']);
            
        return view('profile', compact('user'));
    }

    /**
     * Form edit profil mandiri
     */
    public function editProfile()
    {
        $user = auth()->user();
        $user->load('warga');
        return view('profile_edit', compact('user'));
    }

    /**
     * Update profil mandiri
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $rules = [];
        
        // Hanya Admin yang bisa mengedit informasi akun (name, email, phone)
        if ($user->isAdmin()) {
            $rules = [
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|max:20',
            ];
        }

        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        // Hanya Admin yang bisa mengedit biodata kependudukan
        if ($user->isAdmin() && $user->warga) {
            $wargaRules = [
                'nik' => 'required|numeric|digits:16|unique:warga,nik,' . $user->warga_id,
                'nama_lengkap' => 'required|string|max:255',
                'tempat_lahir' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
                'pendidikan' => 'nullable|string|max:50',
                'jenis_pekerjaan' => 'nullable|string|max:100',
                'alamat' => 'nullable|string',
            ];
            $rules = array_merge($rules, $wargaRules);
        }

        $validated = $request->validate($rules);

        // Update User (Account Info)
        $userData = [];
        
        if ($user->isAdmin()) {
            $userData['name'] = $validated['name'];
            $userData['email'] = $validated['email'];
            $userData['phone'] = $validated['phone'];
        }

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        if (!empty($userData)) {
            $user->update($userData);
        }

        // Update Warga (Hanya jika Admin)
        if ($user->isAdmin() && $user->warga) {
            $wargaData = [
                'nik' => $validated['nik'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'agama' => $validated['agama'] ?? $user->warga->agama,
                'pendidikan' => $validated['pendidikan'] ?? $user->warga->pendidikan,
                'jenis_pekerjaan' => $validated['jenis_pekerjaan'] ?? $user->warga->jenis_pekerjaan,
                'alamat' => $validated['alamat'] ?? $user->warga->alamat,
            ];
            $user->warga->update($wargaData);
        }

        $this->logActivity("Memperbarui profil mandiri");

        return redirect()->route('profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Helper method to log activity
     */
    private function logActivity($aktivitas)
    {

    }
}