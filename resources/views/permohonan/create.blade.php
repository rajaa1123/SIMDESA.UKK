@extends('layouts.app')

@section('title', 'Ajukan Permohonan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ajukan Permohonan Layanan</h1>
    <a href="{{ route('permohonan.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-primary">Form Pengajuan Permohonan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Pilih Layanan -->
                    <div class="mb-3">
                        <label for="layanan_id" class="form-label">Pilih Layanan <span class="text-danger">*</span></label>
                        <select class="form-control @error('layanan_id') is-invalid @enderror" 
                                id="layanan_id" name="layanan_id" required>
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($layanans as $layanan)
                                <option value="{{ $layanan->id }}" 
                                    {{ old('layanan_id', request('layanan_id')) == $layanan->id ? 'selected' : '' }}>
                                    {{ $layanan->nama_layanan }}
                                </option>
                            @endforeach
                        </select>
                        @error('layanan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Persyaratan Section (Dynamic) -->
                    <div id="upload-section" style="display: none;" class="mb-3">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-upload me-1"></i>Upload Dokumen Persyaratan
                        </h6>
                        <div id="upload-fields"></div>
                    </div>

                    <!-- Dynamic Form Data (Rendered by JavaScript based on Layanan) -->
                    <div class="mb-4" id="dynamic-form-section" style="display: none;">
                        <h6 class="fw-bold text-success mb-3 border-bottom pb-2">
                            <i class="fas fa-file-alt me-1"></i>Data yang Dibutuhkan untuk Surat
                        </h6>
                        <div class="alert alert-info py-2 mb-3">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Isi data berikut dengan lengkap. Data ini akan digunakan untuk mencetak surat.
                            </small>
                        </div>
                        <!-- Forms will be rendered here by JavaScript -->
                        <div id="dynamic-form-fields"></div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3" 
                                  placeholder="Jelaskan keperluan atau informasi tambahan mengenai permohonan ini...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Informasi Pemohon -->
                    <div class="mb-3">
                        <label class="form-label">Informasi Pemohon</label>
                        <div class="card bg-light">
                            <div class="card-body py-2">
                                <div class="row small">
                                    <div class="col-md-6">
                                        <strong>Nama:</strong> {{ auth()->user()->name }}<br>
                                        <strong>Email:</strong> {{ auth()->user()->email }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>No. HP:</strong> {{ auth()->user()->phone ?? '-' }}<br>
                                        <strong>Tanggal:</strong> {{ now()->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info py-2">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Permohonan akan diproses dalam waktu yang telah ditentukan. Anda dapat melacak status permohonan di halaman "Permohonan Saya".
                        </small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-paper-plane me-1"></i>Ajukan Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Info Layanan Terpilih -->
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-info">Informasi Layanan</h6>
            </div>
            <div class="card-body" id="layanan-info">
                <div class="text-center text-muted py-3">
                    <i class="fas fa-concierge-bell fa-2x mb-2"></i>
                    <p class="small">Pilih layanan untuk melihat informasi detail</p>
                </div>
            </div>
        </div>

        <!-- Persyaratan -->
        <div class="card shadow-sm">
            <div class="card-header py-2">
                <h6 class="m-0 fw-bold text-warning">Persyaratan</h6>
            </div>
            <div class="card-body" id="persyaratan-info">
                <div class="text-center text-muted py-2">
                    <i class="fas fa-file-alt fa-2x mb-2"></i>
                    <p class="small">Persyaratan akan ditampilkan setelah memilih layanan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('layanan_id').addEventListener('change', function() {
    const layananId = this.value;
    const layananInfo = document.getElementById('layanan-info');
    const persyaratanInfo = document.getElementById('persyaratan-info');
    const uploadSection = document.getElementById('upload-section');
    const uploadFields = document.getElementById('upload-fields');
    const dynamicFormSection = document.getElementById('dynamic-form-section');
    const dynamicFormFields = document.getElementById('dynamic-form-fields');

    if (layananId) {
        // Fetch form schema from API
        fetch(`/api/layanan/${layananId}/form-schema`)
            .then(response => response.json())
            .then(schemaData => {
                if (schemaData.success && schemaData.form_schema) {
                    // Show dynamic form section
                    dynamicFormSection.style.display = 'block';
                    
                    // Render dynamic form fields
                    let formHtml = '<div class="row">';
                    Object.keys(schemaData.form_schema).forEach(fieldName => {
                        const field = schemaData.form_schema[fieldName];
                        const colClass = (field.type === 'textarea') ? 'col-md-12' : 'col-md-6';
                        
                        formHtml += `<div class="${colClass} mb-3">`;
                        formHtml += `<label for="form_data_${fieldName}" class="form-label">`;
                        formHtml += field.label;
                        if (field.required) {
                            formHtml += ' <span class="text-danger">*</span>';
                        }
                        formHtml += `</label>`;
                        
                        // Render input based on type
                        if (field.type === 'select') {
                            formHtml += `<select class="form-control" id="form_data_${fieldName}" name="form_data[${fieldName}]" ${field.required ? 'required' : ''}>`;
                            formHtml += `<option value="">-- Pilih --</option>`;
                            field.options.forEach(option => {
                                formHtml += `<option value="${option}">${option}</option>`;
                            });
                            formHtml += `</select>`;
                        } else if (field.type === 'textarea') {
                            formHtml += `<textarea class="form-control" id="form_data_${fieldName}" name="form_data[${fieldName}]" rows="3" ${field.required ? 'required' : ''} placeholder="${field.placeholder || ''}"></textarea>`;
                        } else if (field.type === 'number') {
                            formHtml += `<input type="number" class="form-control" id="form_data_${fieldName}" name="form_data[${fieldName}]" ${field.required ? 'required' : ''} ${field.min ? `min="${field.min}"` : ''} placeholder="${field.placeholder || ''}">`;
                        } else {
                            // text, date, time
                            formHtml += `<input type="${field.type}" class="form-control" id="form_data_${fieldName}" name="form_data[${fieldName}]" ${field.required ? 'required' : ''} placeholder="${field.placeholder || ''}">`;
                        }
                        
                        formHtml += `</div>`;
                    });
                    formHtml += '</div>';
                    
                    dynamicFormFields.innerHTML = formHtml;
                } else {
                    // No form schema, hide section
                    dynamicFormSection.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching form schema:', error);
                dynamicFormSection.style.display = 'none';
            });
        
        // Original code for layanan info and persyaratan
        // Data dari database
        const layananData = {
            @foreach($layanans as $layanan)
            '{{ $layanan->id }}': {
                nama: '{{ $layanan->nama_layanan }}',
                kategori: '{{ $layanan->kategori }}',
                deskripsi: '{{ $layanan->deskripsi }}',
                persyaratan: [
                    @foreach($layanan->persyaratan as $syarat)
                    {
                        dokumen_id: {{ $syarat->dokumen_id }},
                        nama: '{{ $syarat->dokumen->nama_dokumen }}',
                        wajib: {{ $syarat->wajib ? 'true' : 'false' }},
                        catatan: '{{ $syarat->catatan ?? "" }}'
                    },
                    @endforeach
                ]
            },
            @endforeach
        };

        const data = layananData[layananId];
        
        // Update info layanan
        layananInfo.innerHTML = `
            <h6 class="fw-bold">${data.nama}</h6>
            <span class="badge bg-success px-3 py-1 rounded-pill mb-2">Layanan Gratis</span>
            <p class="small mt-1 text-muted">${data.deskripsi}</p>
        `;

        // Update persyaratan (Real Data)
        if (data.persyaratan.length > 0) {
            // 1. Update Sidebar Info
            let persyaratanHtml = '<div class="small">';
            
            data.persyaratan.forEach(syarat => {
                persyaratanHtml += `
                    <div class="mb-2">
                        <i class="fas ${syarat.wajib ? 'fa-check-circle text-success' : 'fa-info-circle text-info'} me-1"></i>
                        <span>${syarat.nama}</span>
                        ${syarat.wajib ? '<span class="badge bg-danger ms-1" style="font-size: 0.6rem;">Wajib</span>' : '<span class="badge bg-secondary ms-1" style="font-size: 0.6rem;">Opsional</span>'}
                        ${syarat.catatan ? `<div class="text-muted ms-4" style="font-size: 0.75rem;">${syarat.catatan}</div>` : ''}
                    </div>
                `;
            });
            
            persyaratanHtml += `
                <div class="text-muted mt-3 border-top pt-2">
                    <small><i class="fas fa-info-circle me-1"></i>Mohon siapkan dokumen asli untuk verifikasi</small>
                </div>
            </div>`;
            
            persyaratanInfo.innerHTML = persyaratanHtml;

            // 2. Render Upload Fields (Main Form)
            uploadSection.style.display = 'block';
            let uploadHtml = '';
            
            data.persyaratan.forEach(syarat => {
                uploadHtml += `
                    <div class="mb-3">
                        <label for="attachment_${syarat.id}" class="form-label">
                            ${syarat.nama}
                            ${syarat.wajib ? '<span class="text-danger">*</span>' : '<span class="text-muted small">(Opsional)</span>'}
                        </label>
                        <input type="file" class="form-control" id="attachment_${syarat.id}" 
                               name="attachments[${syarat.dokumen_id}]" 
                               accept=".pdf,.jpg,.jpeg,.png"
                               ${syarat.wajib ? 'required' : ''}>
                        <div class="form-text small">
                            Format: PDF, JPG, PNG. Max: 5MB.
                            ${syarat.catatan ? `<br><span class="text-info"><i class="fas fa-info-circle me-1"></i>${syarat.catatan}</span>` : ''}
                        </div>
                    </div>
                `;
            });
            
            uploadFields.innerHTML = uploadHtml;

        } else {
            // No requirements
            persyaratanInfo.innerHTML = `
                <div class="text-center text-muted py-2">
                    <i class="fas fa-check-double fa-2x mb-2 text-success"></i>
                    <p class="small">Tidak ada persyaratan khusus untuk layanan ini</p>
                </div>
            `;
            uploadSection.style.display = 'none';
            uploadFields.innerHTML = '';
        }
    } else {
        layananInfo.innerHTML = `
            <div class="text-center text-muted py-3">
                <i class="fas fa-concierge-bell fa-2x mb-2"></i>
                <p class="small">Pilih layanan untuk melihat informasi detail</p>
            </div>
        `;
        persyaratanInfo.innerHTML = `
            <div class="text-center text-muted py-2">
                <i class="fas fa-file-alt fa-2x mb-2"></i>
                <p class="small">Persyaratan akan ditampilkan setelah memilih layanan</p>
            </div>
        `;
    }
});

// Trigger change jika ada layanan_id di URL
@if(request('layanan_id'))
document.getElementById('layanan_id').dispatchEvent(new Event('change'));
@endif
</script>
@endpush