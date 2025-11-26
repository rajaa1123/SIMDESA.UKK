<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index()
    {
        $wargas = Warga::with('kartuKeluarga')
            ->latest()
            ->paginate(10);

        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        $kartuKeluargas = KartuKeluarga::all();
        return view('warga.create', compact('kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|numeric|unique:warga|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pendidikan' => 'nullable|string|max:50',
            'jenis_pekerjaan' => 'nullable|string|max:100',
            'status_hidup' => 'nullable|string',
            'status_domisili' => 'nullable|string',
            'status_perkawinan' => 'nullable|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'no_hp' => 'nullable|numeric|digits_between:10,13',
            'kartu_keluarga_id' => 'nullable|exists:kartu_keluarga,id',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'nik.digits' => 'NIK harus 16 digit',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
        ]);

        Warga::create($validated);

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function show(Warga $warga)
    {
        return view('warga.show', compact('warga'));
    }

    public function edit(Warga $warga)
    {
        $kartuKeluargas = KartuKeluarga::all();
        return view('warga.edit', compact('warga', 'kartuKeluargas'));
    }

    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);

        $validated = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:warga,nik,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pendidikan' => 'nullable|string|max:50',
            'jenis_pekerjaan' => 'nullable|string|max:100',
            'status_hidup' => 'nullable|string',
            'status_domisili' => 'nullable|string',
            'status_perkawinan' => 'nullable|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'no_hp' => 'nullable|numeric|digits_between:10,13',
            'kartu_keluarga_id' => 'nullable|exists:kartu_keluarga,id',
        ]);

        $warga->update($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui!');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil dihapus.');
    }
}