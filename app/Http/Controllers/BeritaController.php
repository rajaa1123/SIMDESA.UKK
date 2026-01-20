<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->isAdmin() || $user->isKepalaDesa()) {
            $beritas = Berita::with('user')->latest()->paginate(10);
            return view('berita.admin_index', compact('beritas'));
        }
        
        $beritas = Berita::with('user')->whereNotNull('published_at')->latest()->paginate(9);
        return view('berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'kategori' => 'required|in:Berita,Pengumuman,Kegiatan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['judul']) . '-' . time();

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita', 'public');
            $validated['gambar'] = $path;
        }

        Berita::create($validated);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil diterbitkan.');
    }

    public function show(string $slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        return view('berita.show', compact('berita'));
    }

    public function edit(Berita $berita)
    {
        return view('berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'kategori' => 'required|in:Berita,Pengumuman,Kegiatan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $path = $request->file('gambar')->store('berita', 'public');
            $validated['gambar'] = $path;
        }

        $berita->update($validated);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        $berita->delete();

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
