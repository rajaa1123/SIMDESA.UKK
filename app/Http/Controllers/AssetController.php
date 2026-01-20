<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $asets = Asset::latest()->paginate(10);
        return view('assets.index', compact('asets'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_aset' => 'required|max:255',
            'kode_aset' => 'required|unique:asets,kode_aset',
            'kategori' => 'required',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tanggal_perolehan' => 'nullable|date',
            'nilai_perolehan' => 'required|numeric|min:0',
            'lokasi' => 'nullable|max:255',
            'keterangan' => 'nullable',
        ]);

        Asset::create($validated);

        return redirect()->route('assets.index')
            ->with('success', 'Aset baru berhasil dicatatkan.');
    }

    public function show(Asset $asset)
    {
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'nama_aset' => 'required|max:255',
            'kode_aset' => 'required|unique:asets,kode_aset,' . $asset->id,
            'kategori' => 'required',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tanggal_perolehan' => 'nullable|date',
            'nilai_perolehan' => 'required|numeric|min:0',
            'lokasi' => 'nullable|max:255',
            'keterangan' => 'nullable',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.index')
            ->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')
            ->with('success', 'Data aset berhasil dihapus dari sistem.');
    }
}
