<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\PengaduanLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin() || $user->isKepalaDesa()) {
            $pengaduans = Pengaduan::with('user')->latest()->paginate(10);
        } else {
            $pengaduans = Pengaduan::where('user_id', $user->id)->latest()->paginate(10);
        }

        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'isi_laporan' => 'required',
            'lokasi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'Pending';

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('pengaduan', 'public');
            $validated['foto'] = $path;
        }

        $pengaduan = Pengaduan::create($validated);

        // Log initial creation
        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id' => auth()->id(),
            'status_sebelumnya' => null,
            'status_sesudahnya' => 'Pending',
            'pesan' => 'Pengaduan baru diajukan oleh warga.'
        ]);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Laporan pengaduan berhasil dikirim.');
    }

    public function show(Pengaduan $pengaduan)
    {
        // Authorization check: User can only view their own, unless admin/kades
        if (auth()->user()->isWarga() && $pengaduan->user_id != auth()->id()) {
            abort(403);
        }

        return view('pengaduan.show', compact('pengaduan'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        // Only Admin/Kades can update status/response
        if (!auth()->user()->isAdmin() && !auth()->user()->isKepalaDesa()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:Pending,Diproses,Selesai,Ditolak',
            'tanggapan' => 'required|string',
        ]);

        $statusSebelumnya = $pengaduan->status;
        $pengaduan->update($validated);

        // Log status change/response
        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id' => auth()->id(),
            'status_sebelumnya' => $statusSebelumnya,
            'status_sesudahnya' => $validated['status'],
            'pesan' => 'Tanggapan: ' . $validated['tanggapan']
        ]);

        return redirect()->route('pengaduan.show', $pengaduan)
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }
    
    public function destroy(Pengaduan $pengaduan)
    {
         if (auth()->user()->isWarga() && $pengaduan->user_id != auth()->id()) {
            abort(403);
        }
        
        if ($pengaduan->foto) {
             Storage::disk('public')->delete($pengaduan->foto);
        }
        
        $pengaduan->delete();
        
        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
}
