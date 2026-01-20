<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Keuangan::with('user', 'permohonan');

        // Filter by date range
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        // Filter by type
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $items = $query->latest('tanggal')->latest('id')->paginate(20);

        // Calculate summary for the filtered data
        $summary = [
            'total_masuk' => (clone $query)->where('tipe', 'masuk')->sum('jumlah'),
            'total_keluar' => (clone $query)->where('tipe', 'keluar')->sum('jumlah'),
        ];
        $summary['saldo'] = $summary['total_masuk'] - $summary['total_keluar'];

        $categoriesMasuk = Keuangan::getKategoriMasuk();
        $categoriesKeluar = Keuangan::getKategoriKeluar();

        return view('keuangan.index', compact('items', 'summary', 'categoriesMasuk', 'categoriesKeluar'));
    }

    public function create()
    {
        $categoriesMasuk = Keuangan::getKategoriMasuk();
        $categoriesKeluar = Keuangan::getKategoriKeluar();
        return view('keuangan.create', compact('categoriesMasuk', 'categoriesKeluar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|in:masuk,keluar',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();

        Keuangan::create($validated);

        return redirect()->route('keuangan.index')
            ->with('success', 'Transaksi berhasil dicatat ke dalam buku kas.');
    }

    public function edit(Keuangan $keuangan)
    {
        // Don't allow editing automatic service fee entries directly to maintain integrity
        if ($keuangan->permohonan_id) {
            return redirect()->route('keuangan.index')
                ->with('error', 'Transaksi otomatis dari layanan tidak dapat diedit langsung. Silakan edit lewat data permohonan terkait.');
        }

        $categoriesMasuk = Keuangan::getKategoriMasuk();
        $categoriesKeluar = Keuangan::getKategoriKeluar();
        return view('keuangan.edit', compact('keuangan', 'categoriesMasuk', 'categoriesKeluar'));
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        if ($keuangan->permohonan_id) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|in:masuk,keluar',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $keuangan->update($validated);

        return redirect()->route('keuangan.index')
            ->with('success', 'Transaksi buku kas berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        if ($keuangan->permohonan_id) {
            return redirect()->route('keuangan.index')
                ->with('error', 'Transaksi otomatis tidak dapat dihapus langsung.');
        }

        $keuangan->delete();

        return redirect()->route('keuangan.index')
            ->with('success', 'Transaksi berhasil dihapus dari buku kas.');
    }
}
