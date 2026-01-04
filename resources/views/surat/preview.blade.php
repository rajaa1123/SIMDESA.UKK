@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permohonan.show', $permohonan->id) }}">Detail Permohonan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Preview Surat</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Preview Surat: {{ $permohonan->layanan->nama_layanan }}</h5>
                    <span class="badge bg-info text-dark">Template: {{ $templateSlug }}</span>
                </div>
                <div class="card-body p-0">
                    {{-- Iframe for HTML preview --}}
                    <iframe 
                        id="preview-iframe" 
                        style="width: 100%; height: 800px; border: none;"
                        srcdoc="{{ view("surat.templates.{$templateSlug}", $data)->render() }}"
                    ></iframe>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-file-signature me-2"></i>Terbitkan Surat</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <small><i class="fas fa-info-circle"></i> Pastikan data di preview sudah benar sebelum menerbitkan surat.</small>
                    </div>

                    <form action="{{ route('surat.generate', $permohonan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menerbitkan surat ini? PDF akan dibuat dan disimpan.');">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control" 
                                   value="{{ $nomorSurat }}" required>
                            <div class="form-text">Sesuaikan nomor surat jika diperlukan.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Data Pemohon</label>
                            <table class="table table-sm table-borderless bg-light rounded">
                                <tr>
                                    <td width="30%">Nama</td>
                                    <td width="5%">:</td>
                                    <td>{{ $data['nama'] }}</td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td>{{ $data['nik'] }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl Lahir</td>
                                    <td>:</td>
                                    <td>{{ $data['tanggal_lahir'] }}</td>
                                </tr>
                            </table>
                        </div>

                        <hr>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-file-pdf me-2"></i> Terbitkan Surat (PDF)
                        </button>
                        
                        <a href="{{ route('permohonan.show', $permohonan->id) }}" 
                           class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
