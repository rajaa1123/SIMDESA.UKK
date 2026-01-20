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
        
        // Save to STORAGE (Disk)
        $filename = "Surat_{$permohonan->layanan->nama_layanan}_{$permohonan->id}.pdf";
        $path = "surat/" . date('Y/m') . "/" . $filename;
        
        \Storage::disk('public')->put($path, $pdf->output());
        
        // Save to database (Store PATH instead of Content)
        $permohonan->update([
            'hasil_surat_file' => $path, // Storing PATH now
            'hasil_surat_filename' => $filename,
            'hasil_surat_uploaded_at' => now(),
            'hasil_surat_uploaded_by' => auth()->id(),
            'nomor_surat' => $nomorSurat,
        ]);
        
        return redirect()->route('permohonan.show', $permohonan)
            ->with('success', 'Surat berhasil diterbitkan dan dikirim ke kepala desa untuk ditandatangani .');
    }

    /**
     * Helper to prepare data for template
     */
    private function prepareSuratData($permohonan, $nomorSurat)
    {
        $warga = $permohonan->user->warga;
        $user = $permohonan->user;
        $formData = $permohonan->form_data ?? []; // ✅ GET Form Data
        
        // PRIORITY: Custom surat data (filled by warga in form) > Form Data (Dynamic) > Warga profile > User data > Default
        $nama = $permohonan->surat_nama ?? $formData['name'] ?? $formData['nama'] ?? $formData['nama_lengkap'] ?? $warga?->nama_lengkap ?? $user->name ?? 'NAMA BELUM DIISI';
        $nik = $permohonan->surat_nik ?? $formData['nik'] ?? $warga?->nik ?? 'NIK BELUM DIISI';
        $tempat_lahir = $permohonan->surat_tempat_lahir ?? $formData['tempat_lahir'] ?? $warga?->tempat_lahir ?? '-';
        
        $tanggal_lahir = '-';
        if ($permohonan->surat_tanggal_lahir) {
            $tanggal_lahir = Carbon::parse($permohonan->surat_tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY');
        } elseif (!empty($formData['tanggal_lahir'])) {
            $tanggal_lahir = Carbon::parse($formData['tanggal_lahir'])->locale('id')->isoFormat('D MMMM YYYY');
        } elseif ($warga?->tanggal_lahir) {
            $tanggal_lahir = Carbon::parse($warga->tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY');
        }
        
        $jenis_kelamin = $permohonan->surat_jenis_kelamin ?? $formData['jenis_kelamin'] ?? $warga?->jenis_kelamin ?? '-';
        $agama = $permohonan->surat_agama ?? $formData['agama'] ?? $warga?->agama ?? '-';
        $pekerjaan = $permohonan->surat_pekerjaan ?? $formData['pekerjaan'] ?? $warga?->jenis_pekerjaan ?? '-';
        
        // ✅ FIX: Use alamat from form_data if available
        $alamat = $permohonan->surat_alamat ?? $formData['alamat'] ?? $warga?->alamat ?? '-';
        $rt = $permohonan->surat_rt ?? $formData['rt'] ?? $warga?->rt ?? '-';
        $rw = $permohonan->surat_rw ?? $formData['rw'] ?? $warga?->rw ?? '-';
        
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
            'kades_signature_qr_raw' => $this->getSignatureQrRaw($permohonan),
            'logo_base64' => $this->getLogoBase64(),
            'layout_class' => $this->getLayoutClass($permohonan->layanan->template_slug, $permohonan->form_data),
        ];
    }

    /**
     * Get Raw SVG content for QR code (bypasses GD requirement in some cases)
     */
    private function getSignatureQrRaw($permohonan)
    {
        if (!$permohonan->kades_signature_qr_path) {
            return null;
        }

        $qrPath = storage_path('app/public/' . $permohonan->kades_signature_qr_path);
        
        if (!file_exists($qrPath)) {
            return null;
        }

        if (pathinfo($qrPath, PATHINFO_EXTENSION) === 'svg') {
            $svgContent = file_get_contents($qrPath);
            // Remove XML declaration and potential doctype to avoid dompdf issues
            $svgContent = preg_replace('/<\?xml.*?\?>/s', '', $svgContent);
            $svgContent = preg_replace('/<!DOCTYPE.*?>/s', '', $svgContent);
            return trim($svgContent);
        }

        return null;
    }

    /**
     * Get Village Logo as Base64 for PDF embedding
     */
    private function getLogoBase64()
    {
        $logoPath = public_path('images/logo-sidoarjo.png');
        
        if (file_exists($logoPath)) {
            try {
                $imageData = base64_encode(file_get_contents($logoPath));
                $mimeType = mime_content_type($logoPath);
                return "data:{$mimeType};base64,{$imageData}";
            } catch (\Exception $e) {
                \Log::error('Failed to encode logo to base64', ['error' => $e->getMessage()]);
            }
        }
        
        return null;
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
        $extension = pathinfo($qrPath, PATHINFO_EXTENSION);
        $mimeType = ($extension === 'svg') ? 'image/svg+xml' : mime_content_type($qrPath);
        
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
        
        // Save to STORAGE (Disk)
        $filename = "Surat_{$permohonan->layanan->nama_layanan}_{$permohonan->id}.pdf";
        $path = "surat/" . date('Y/m') . "/" . $filename;
        
        \Storage::disk('public')->put($path, $pdf->output());
        
        // Update database (Store PATH)
        $permohonan->update([
            'hasil_surat_file' => $path,
            'hasil_surat_filename' => $filename,
            'hasil_surat_uploaded_at' => now(),
            'hasil_surat_uploaded_by' => auth()->id(),
            'nomor_surat' => $nomorSurat,
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
            
            // Save to STORAGE (Disk)
            $filename = "Surat_{$permohonan->layanan->nama_layanan}_{$permohonan->id}.pdf";
            $path = "surat/" . date('Y/m') . "/" . $filename;
            
            \Storage::disk('public')->put($path, $pdf->output());
            
            // Save to database
            $permohonan->update([
                'hasil_surat_file' => $path, // Store PATH
                'hasil_surat_filename' => $filename,
                'hasil_surat_uploaded_at' => now(),
                'hasil_surat_uploaded_by' => auth()->id(),
                'nomor_surat' => $nomorSurat,
            ]);
            
            \Log::info('Auto-generated PDF saved to storage', [
                'permohonan_id' => $permohonan->id,
                'path' => $path
            ]);
            
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
     * Public Verification Page (Scanned from QR Code)
     */
    public function verify($code)
    {
        // Simple decryption/decoding logic (e.g., base64 encoded ID or just ID)
        // For security, you might want to use ID obfuscation or a dedicated unique token column.
        // Assuming 'code' is the permohonan ID for now or a simple base64 of it.
        try {
            $id = base64_decode($code);
            // Fallback if not base64 (for backward compatibility if needed)
            if (!is_numeric($id)) {
                $id = $code;
            }
        } catch (\Exception $e) {
            $id = $code;
        }

        $permohonan = Permohonan::with(['user.warga', 'layanan', 'kadesUser'])
            ->find($id);

        if (!$permohonan) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        // Only show valid if status is 'selesai' (approved/signed)
        // Ensure to check relation access safely
        $isValid = ($permohonan->isSelesai() || ($permohonan->status && $permohonan->status->code === 'selesai')) && $permohonan->kades_user_id;

        // Fallback for legacy records: generate number if null
        $nomorSurat = $permohonan->nomor_surat ?? $this->generateNomorSurat($permohonan);

        return view('surat.verifikasi', compact('permohonan', 'isValid', 'nomorSurat'));
    }

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

    /**
     * Determine layout scaling class based on template and content density
     */
    private function getLayoutClass($templateSlug, $formData)
    {
        // Very Long Templates
        $extraCompact = [
            'pengantar-nikah', 'pindah-datang', 'pindah-tempat', 
            'akte-kelahiran', 'akte-kematian', 'ahli-waris'
        ];
        
        // Moderately Long Templates
        $compact = [
            'domisili', 'skck', 'sktm', 'ijin-keramaian', 
            'riwayat-tanah', 'kematian'
        ];
        
        // Very Short Templates
        $extraRelaxed = [
            'legalisasi', 'beda-nama', 'kia', 'ktp', 'kk', 'peduli-dilan'
        ];
        
        if (in_array($templateSlug, $extraCompact)) return 'extra-compact';
        if (in_array($templateSlug, $compact)) return 'compact';
        if (in_array($templateSlug, $extraRelaxed)) return 'extra-relaxed';
        
        // Default heuristic based on form data fields count
        $fieldCount = count($formData ?? []);
        if ($fieldCount > 10) return 'compact';
        if ($fieldCount < 5) return 'relaxed';
        
        return 'standard';
    }
}
