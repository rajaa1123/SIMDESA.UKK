<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Warga;
use Illuminate\Http\Request;

class KartuKeluargaController extends Controller
{
    public function index()
    {
        $kartuKeluargas = KartuKeluarga::withCount('wargas')
            ->latest()
            ->paginate(10);
        
        return view('kartu-keluarga.index', compact('kartuKeluargas'));
    }

    public function create()
    {
        return view('kartu-keluarga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|unique:kartu_keluarga|max:20',
            'alamat' => 'required',
            'kepala_keluarga' => 'required|max:100',
        ]);

        KartuKeluarga::create($validated);

        return redirect()->route('kartu-keluarga.index')
            ->with('success', 'Data kartu keluarga berhasil ditambahkan.');
    }

    public function show(KartuKeluarga $kartuKeluarga)
    {
        $wargas = Warga::where('kartu_keluarga_id', $kartuKeluarga->id)->get();
        return view('kartu-keluarga.show', compact('kartuKeluarga', 'wargas'));
    }

    public function edit(KartuKeluarga $kartuKeluarga)
    {
        return view('kartu-keluarga.edit', compact('kartuKeluarga'));
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $validated = $request->validate([
            'no_kk' => 'required|max:20|unique:kartu_keluarga,no_kk,' . $kartuKeluarga->id,
            'alamat' => 'required',
            'kepala_keluarga' => 'required|max:100',
        ]);

        $kartuKeluarga->update($validated);

        return redirect()->route('kartu-keluarga.index')
            ->with('success', 'Data kartu keluarga berhasil diperbarui.');
    }

    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->delete();

        return redirect()->route('kartu-keluarga.index')
            ->with('success', 'Data kartu keluarga berhasil dihapus.');
    }
}