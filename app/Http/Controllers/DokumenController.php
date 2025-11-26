<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumens = Dokumen::latest()->paginate(5);
        return view('dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        return view('dokumen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);

        Dokumen::create($validated);

        return redirect()->route('dokumen.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(Dokumen $dokumen)
    {
        return view('dokumen.show', compact('dokumen'));
    }

    public function edit(Dokumen $dokumen)
    {

        $dokumen->load(['persyaratan.layanan']);

        return view('dokumen.edit', compact('dokumen'));
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);

        try {
            $dokumen->update($validated);

            return redirect()->route('dokumen.show', $dokumen->id)
                ->with('success', 'Dokumen berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui dokumen. Silakan coba lagi.']);
        }
    }

    public function destroy(Dokumen $dokumen)
    {
        $dokumen->delete();
        return redirect()->route('dokumen.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}