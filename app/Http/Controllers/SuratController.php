<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    /**
     * Preview surat (HTML view) before generating PDF
     */
    public function preview(Permohonan $permohonan)
    {
        // Authorization
        $this->authorize('manageSurat', $permohonan);
        
        // Load relationships
        $permohonan->load(['user.warga', 'layanan', 'kadesUser']);
        
        // Get template slug
        $templateSlug = $permohonan->layanan->template_slug;
        
        if (!$templateSlug || !view()->exists("surat.templates.{$templateSlug}")) {
            abort(404, 'Template surat tidak ditemukan untuk layanan ini.');
        }
        
        // Generate nomor surat (preview)
        $nomorSurat = $this->generateNomorSurat($permohonan);
        
        // Prepare data for template
        $data = $this->prepareSuratData($permohonan, $nomorSurat);
        
        return view('surat.preview', compact('permohonan', 'templateSlug', 'data', 'nomorSurat'));
    }

    /**
     * Generate PDF and save to database
     */
    public function generate(Request $request, Permohonan $permohonan)
    {
        // Authorization
        $this->authorize('manageSurat', $permohonan);
        
        // Validation - allow 'AUTO' for automatic nomor surat generation
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
        ]);
        
        // Auto-generate nomor surat if 'AUTO' is specified
        $nomorSurat = $request->nomor_surat;
        if ($nomorSurat === 'AUTO') {
            $nomorSurat = $this->generateNomorSurat($permohonan);
        }
        
        // Load relationships
        $permohonan->load(['user.warga', 'layanan', 'kadesUser']);
        
        // Get template
        $templateSlug = $permohonan->layanan->template_slug;
        
        if (!view()->exists("surat.templates.{$templateSlug}")) {
            return back()->with('error', 'Template surat tidak ditemukan.');
        }
        
        // Prepare data
        $data = $this->prepareSuratData($permohonan, $nomorSurat);
        
        // Generate PDF
        $pdf = Pdf::loadView("surat.templates.{$templateSlug}", $data);
        $pdf->setPaper('a4', 'portrait');
        
        // Convert to base64
        $pdfContent = base64_encode($pdf->output());
        
        // Save to database
        $permohonan->update([
            'hasil_surat_file' => $pdfContent,
            'hasil_surat_filename' => "Surat_{$permohonan->layanan->nama_layanan}_{$permohonan->id}.pdf",
            'hasil_surat_uploaded_at' => now(),
            'hasil_surat_uploaded_by' => auth()->id(),
        ]);
        
        return redirect()->route('permohonan.show', $permohonan)
            ->with('success', 'Surat berhasil diterbitkan dan dapat didownload oleh warga.');
    }

    /**
     * Helper to prepare data for template
     */
    private function prepareSuratData($permohonan, $nomorSurat)
    {
        $warga = $permohonan->user->warga;
        $user = $permohonan->user;
        
        // PRIORITY: Custom surat data (filled by warga in form) > Warga profile > User data > Default
        $nama = $permohonan->surat_nama ?? $warga?->nama_lengkap ?? $user->name ?? 'NAMA BELUM DIISI';
        $nik = $permohonan->surat_nik ?? $warga?->nik ?? 'NIK BELUM DIISI';
        $tempat_lahir = $permohonan->surat_tempat_lahir ?? $warga?->tempat_lahir ?? '-';
        
        $tanggal_lahir = '-';
        if ($permohonan->surat_tanggal_lahir) {
            $tanggal_lahir = Carbon::parse($permohonan->surat_tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY');
        } elseif ($warga?->tanggal_lahir) {
            $tanggal_lahir = Carbon::parse($warga->tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY');
        }
        
        $jenis_kelamin = $permohonan->surat_jenis_kelamin ?? $warga?->jenis_kelamin ?? '-';
        $agama = $permohonan->surat_agama ?? $warga?->agama ?? '-';
        $pekerjaan = $permohonan->surat_pekerjaan ?? $warga?->pekerjaan ?? '-';
        $alamat = $permohonan->surat_alamat ?? $warga?->alamat ?? '-';
        $rt = $permohonan->surat_rt ?? $warga?->rt ?? '-';
        $rw = $permohonan->surat_rw ?? $warga?->rw ?? '-';
        
        return [
            'nomor_surat' => $nomorSurat,
            'tanggal_surat' => now()->locale('id')->isoFormat('D MMMM YYYY'),
            
            // Warga data (with priority: custom form > profile > default)
            'warga' => $warga,
            'nama' => $nama,
            'nik' => $nik,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'agama' => $agama,
            'pekerjaan' => $pekerjaan,
            'alamat' => $alamat,
            'rt' => $rt,
            'rw' => $rw,
            'kelurahan' => 'SIDOKARE',
            'kecamatan' => 'SIDOARJO',
            'kabupaten' => 'SIDOARJO',
            
            // Dynamic form data specific to layanan
            'form_data' => $permohonan->form_data ?? [],
            
            // Permohonan data
            'permohonan' => $permohonan,
            'layanan' => $permohonan->layanan,
            'tanggal_pengajuan' => $permohonan->tanggal_pengajuan ? Carbon::parse($permohonan->tanggal_pengajuan)->locale('id')->isoFormat('D MMMM YYYY') : '-',
            
            // Kepala Desa signature (if approved)
            'kades' => $permohonan->kadesUser,
            'kades_name' => $permohonan->kadesUser->name ?? 'Kepala Desa',
            'kades_signature_qr' => $this->getSignatureQrBase64($permohonan),
        ];
    }

    /**
     * Convert QR signature image to base64 for PDF embedding
     */
    private function getSignatureQrBase64($permohonan)
    {
        if (!$permohonan->kades_signature_qr_path) {
            return null;
        }

        $qrPath = storage_path('app/public/' . $permohonan->kades_signature_qr_path);
        
        if (!file_exists($qrPath)) {
            return null;
        }

        $imageData = base64_encode(file_get_contents($qrPath));
        $mimeType = mime_content_type($qrPath);
        
        return "data:{$mimeType};base64,{$imageData}";
    }

    /**
     * Regenerate surat PDF after Kades approval (with digital signature)
     * Called by ApprovalController after approval
     */
    public function regenerateSuratAfterApproval(Permohonan $permohonan)
    {
        // Load relationships
        $permohonan->load(['user.warga', 'layanan', 'kadesUser']);
        
        // Get template
        $templateSlug = $permohonan->layanan->template_slug;
        
        if (!view()->exists("surat.templates.{$templateSlug}")) {
            \Log::error('Template not found for surat regeneration', [
                'permohonan_id' => $permohonan->id,
                'template_slug' => $templateSlug
            ]);
            return false;
        }
        
        // Generate nomor surat (use existing if already generated, or create new)
        $nomorSurat = $this->extractNomorSuratFromExisting($permohonan) ?? $this->generateNomorSurat($permohonan);
        
        // Prepare data with digital signature
        $data = $this->prepareSuratData($permohonan, $nomorSurat);
        
        // Generate PDF
        $pdf = Pdf::loadView("surat.templates.{$templateSlug}", $data);
        $pdf->setPaper('a4', 'portrait');
        
        // Convert to base64
        $pdfContent = base64_encode($pdf->output());
        
        // Update database
        $permohonan->update([
            'hasil_surat_file' => $pdfContent,
            'hasil_surat_filename' => "Surat_{$permohonan->layanan->nama_layanan}_{$permohonan->id}.pdf",
            'hasil_surat_uploaded_at' => now(),
            'hasil_surat_uploaded_by' => auth()->id(),
        ]);
        
        \Log::info('Surat regenerated with digital signature', [
            'permohonan_id' => $permohonan->id
        ]);
        
        return true;
    }

    /**
     * Extract nomor surat from existing filename if available
     */
    private function extractNomorSuratFromExisting($permohonan)
    {
        // For now, just regenerate. In future, could parse from filename or store separately
        return null;
    }

    /**
     * Auto-generate PDF for permohonan
     * Called automatically when admin verifies
     */
    public function autoGeneratePDF(Permohonan $permohonan)
    {
        try {
            // Load relationships
            $permohonan->load(['user.warga', 'layanan', 'kadesUser']);
            
            // Get template
            $templateSlug = $permohonan->layanan->template_slug;
            
            if (!view()->exists("surat.templates.{$templateSlug}")) {
                \Log::error('Template not found for auto PDF generation', [
                    'permohonan_id' => $permohonan->id,
                    'template_slug' => $templateSlug
                ]);
                return false;
            }
            
            // Generate nomor surat
            $nomorSurat = $this->generateNomorSurat($permohonan);
            
            // Prepare data
            $data = $this->prepareSuratData($permohonan, $nomorSurat);
            
            // Generate PDF
            $pdf = Pdf::loadView("surat.templates.{$templateSlug}", $data);
            $pdf->setPaper('a4', 'portrait');
            
            // Convert to base64
            $pdfContent = base64_encode($pdf->output());
            
            // Save to database
            $permohonan->update([
                'hasil_surat_file' => $pdfContent,
                'hasil_surat_filename' => "Surat_{$permohonan->layanan->nama_layanan}_{$permohonan->id}.pdf",
                'hasil_surat_uploaded_at' => now(),
                'hasil_surat_uploaded_by' => auth()->id(),
            ]);
            
            \Log::info('Auto-generated PDF', ['permohonan_id' => $permohonan->id]);
            
            return true;
            
        } catch (\Exception $e) {
            \Log::error('Auto PDF generation failed', [
                'permohonan_id' => $permohonan->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Helper to generate default nomor surat
     */
    private function generateNomorSurat($permohonan)
    {
        // Format: 000/SK/DESA-SIDOKARE/ROMAN_MONTH/YEAR
        $counter = str_pad($permohonan->id, 3, '0', STR_PAD_LEFT);
        $kode = 'SK'; // Surat Keterangan
        $desa = 'DESA-SIDOKARE';
        
        $month = now()->month;
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulan = $romanMonths[$month];
        
        $tahun = now()->year;
        
        return "{$counter}/{$kode}/{$desa}/{$bulan}/{$tahun}";
    }
}
