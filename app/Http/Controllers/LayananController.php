<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Dokumen;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::latest()->paginate(12);
        return view('layanan.index', compact('layanans'));
    }

    public function create()
    {
        $dokumens = Dokumen::all();
        return view('layanan.create', compact('dokumens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|max:255',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'template_slug' => 'nullable|string|max:50',
        ]);

        $layanan = Layanan::create($validated);

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function show(Layanan $layanan)
    {
        return view('layanan.show', compact('layanan'));
    }

    public function edit(Layanan $layanan)
    {
        $dokumens = Dokumen::all();
        return view('layanan.edit', compact('layanan', 'dokumens'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|max:255',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'template_slug' => 'nullable|string|max:50',
        ]);

        $layanan->update($validated);

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}