<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Layanan;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function index()
    {
        $statuses = Status::where('group_key', 'permohonan')->get();
        $layanans = Layanan::all();

        $permohonans = Permohonan::with(['user', 'layanan', 'status'])
            ->latest()
            ->paginate(10);

        return view('permohonan.index', compact('permohonans', 'statuses', 'layanans'));
    }

    public function create()
    {
        $layanans = Layanan::with('persyaratan.dokumen')->get();
        $statuses = Status::where('group_key', 'permohonan')->get();
        return view('permohonan.create', compact('layanans', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'keterangan' => 'nullable',
        ]);

        $validated['user_id'] = auth()->id(); // User yang login
        $validated['status_id'] = 1; // Status: Menunggu Diproses (ID 1)

        // Generate nomor resi otomatis
        $validated['nomor_resi'] = 'RESI-' . date('Ymd') . '-' . rand(1000, 9999);
        // $validated['tanggal_pengajuan'] = now();


        Permohonan::create($validated);

        return redirect()->route('permohonan.index')
            ->with('success', 'Permohonan berhasil diajukan.');
    }

    public function show(Permohonan $permohonan)
    {
        // ✅ LOAD RELATIONSHIPS
        $permohonan->load(['user', 'layanan', 'status', 'processor', 'history.changedBy', 'history.fromStatus', 'history.toStatus', 'attachments']);

        // ✅ TAMBAH INI: Ambil data statuses untuk dropdown
        $statuses = Status::where('group_key', 'permohonan')->get();

        return view('permohonan.show', compact('permohonan', 'statuses'));
    }

    public function edit(Permohonan $permohonan)
    {

        $layanans = Layanan::all();
        $statuses = Status::where('group_key', 'permohonan')->get();
        $processors = User::whereIn('role_id', [2, 3])->get();

        return view('permohonan.edit', compact('permohonan', 'layanans', 'statuses', 'processors'));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'status_id' => 'required|exists:status,id',
            'keterangan' => 'nullable',
            'processor_user_id' => 'nullable|exists:users,id',
            'biaya_admin' => 'nullable|numeric',
        ]);
        try {
            if ($permohonan->status_id != $validated['status_id']) {
                $permohonan->history()->create([
                    'from_status_id' => $permohonan->status_id,
                    'to_status_id' => $validated['status_id'],
                    'changed_by' => auth()->id(),
                    'note' => 'Status diupdate melalui form edit',
                ]);
            }

            $permohonan->update($validated);

            return redirect()->route('permohonan.show', $permohonan->id)
                ->with('success', 'Permohonan berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui permohonan. Silakan coba lagi.']);
        }
    }

    public function destroy(Permohonan $permohonan)
    {
        $permohonan->delete();
        return redirect()->route('permohonan.index')
            ->with('success', 'Permohonan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'status_id' => 'required|exists:status,id',
            'note' => 'nullable',
        ]);

        // Create history record
        $permohonan->history()->create([
            'from_status_id' => $permohonan->status_id,
            'to_status_id' => $request->status_id,
            'changed_by' => auth()->id(),
            'note' => $request->note,
        ]);

        // Update status
        $permohonan->update(['status_id' => $request->status_id]);

        return back()->with('success', 'Status permohonan berhasil diperbarui.');
    }
}