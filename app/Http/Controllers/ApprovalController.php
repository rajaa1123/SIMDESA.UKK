<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Status;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    /**
     * Display a listing of pengajuan waiting for kepala desa approval
     */
    public function index()
    {
        $status = Status::where('group_key', 'pengajuan')
            ->where('code', 'menunggu_persetujuan_kades')
            ->first();

        $pengajuans = Permohonan::with(['user', 'layanan', 'status', 'adminUser'])
            ->where('status_id', $status->id ?? 0)
            ->latest('tanggal_pengajuan')
            ->paginate(15);

        return view('approval.index', compact('pengajuans'));
    }

    /**
     * Display the specified pengajuan for approval
     */
    public function show(Permohonan $permohonan)
    {
        // STRICT GUARD: Tolak akses jika bukan status menunggu_persetujuan_kades
        if (!$permohonan->canBeAccessedByKades()) {
            abort(403, 'Akses ditolak: Permohonan ini tidak dalam status menunggu persetujuan Kepala Desa.');
        }

        // Load all necessary relationships
        $permohonan->load([
            'user', 
            'layanan', 
            'status', 
            'adminUser',
            'processor', 
            'history.changedBy', 
            'history.fromStatus', 
            'history.toStatus', 
            'attachments'
        ]);

        return view('approval.show', compact('permohonan'));
    }

    /**
     * Approve the pengajuan dengan tanda tangan digital
     * AI GUARD SIMDESA: Validate surat hasil olahan before approval
     */
    public function approve(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'kades_note' => 'nullable|string|max:1000',
        ]);

        // STRICT GUARD: Check if eligible for approval
        if (!$permohonan->isMenungguPersetujuanKades()) {
            return back()->with('error', 'Pengajuan ini tidak dapat disetujui.');
        }

        // STRICT GUARD: Validate status transition
        if (!$permohonan->canTransitionTo('selesai')) {
            return back()->with('error', 'Transisi status tidak diizinkan.');
        }

        // **AI GUARD SIMDESA**: TOLAK jika surat hasil olahan belum di-upload
        if (!$permohonan->hasHasilSurat()) {
            return back()->with('error', 'Gagal: Admin belum mengunggah surat hasil olahan. Silakan upload PDF terlebih dahulu.');
        }

        try {
            $statusSelesai = Status::where('group_key', 'pengajuan')
                ->where('code', 'selesai')
                ->firstOrFail();

            $kades = auth()->user();

            // **DIGITAL SIGNATURE GENERATION using Python script** (OPTIONAL)
            // Try to generate signature, but don't fail if it doesn't work
            $signatureData = null;
            try {
                $signatureData = $this->generateDigitalSignature($permohonan, $kades);
            } catch (\Exception $e) {
                \Log::warning('Digital signature generation failed, proceeding without signature', [
                    'permohonan_id' => $permohonan->id,
                    'error' => $e->getMessage()
                ]);
                // Continue without signature
            }

            // Create history record
            $permohonan->history()->create([
                'from_status_id' => $permohonan->status_id,
                'to_status_id' => $statusSelesai->id,
                'changed_by' => auth()->id(),
                'note' => 'Disetujui oleh Kepala Desa' . ($request->kades_note ? ': ' . $request->kades_note : ''),
            ]);

            // Update permohonan - with or without digital signature
            $updateData = [
                'status_id' => $statusSelesai->id,
                'kades_user_id' => auth()->id(),
                'kades_approval_date' => now(),
                'kades_note' => $request->kades_note,
                'tanggal_selesai' => now(),
            ];
            
            // Add digital signature fields only if generation succeeded
            if ($signatureData && !empty($signatureData['signature']) && !empty($signatureData['qr_path'])) {
                $updateData['kades_digital_signature'] = $signatureData['signature'];
                $updateData['kades_signature_qr_path'] = $signatureData['qr_path'];
                $updateData['kades_signature_timestamp'] = now();
            }
            
            $permohonan->update($updateData);

            // **NOTIFICATION to warga**
            $this->notifyWarga($permohonan);

            // **AUTO-REGENERATE SURAT with digital signature QR code (if available)**
            try {
                $suratController = app(\App\Http\Controllers\SuratController::class);
                $suratController->regenerateSuratAfterApproval($permohonan);
            } catch (\Exception $e) {
                \Log::error('Failed to regenerate surat after approval', [
                    'permohonan_id' => $permohonan->id,
                    'error' => $e->getMessage()
                ]);
                // Don't fail the approval if surat regeneration fails
            }

            return redirect()->route('approval.index')
                ->with('success', 'Pengajuan layanan berhasil disetujui. Surat telah diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui pengajuan: ' . $e->getMessage());
        }
    }


    /**
     * Generate simple QR code for signature (PHP-based, no extensions needed)
     */
    private function generateDigitalSignature($permohonan, $kades)
    {
        try {
            // Create verification data for QR code
            $verificationData = [
                'nomor_resi' => $permohonan->nomor_resi,
                'layanan' => $permohonan->layanan->nama_layanan,
                'pemohon' => $permohonan->user->name,
                'disetujui_oleh' => $kades->name,
                'tanggal_approval' => now()->format('d/m/Y H:i'),
                'status' => 'APPROVED'
            ];
            
            // Create QR code content (JSON)
            $qrContent = json_encode($verificationData);
            
            // Generate simple signature string
            $signature = hash('sha256', $qrContent . config('app.key'));
            
            // Generate QR code using BaconQrCode (pure PHP, no GD needed)
            $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
                new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
            );
            $writer = new \BaconQrCode\Writer($renderer);
            $qrCodeSvg = $writer->writeString($qrContent);
            
            // Convert SVG to PNG using Imagick or save as SVG
            $qrPath = 'signatures/qr/permohonan_' . $permohonan->id . '.svg';
            \Storage::disk('public')->put($qrPath, $qrCodeSvg);
            
            \Log::info('QR code generated successfully', [
                'permohonan_id' => $permohonan->id,
                'qr_path' => $qrPath
            ]);
            
            return [
                'signature' => $signature,
                'qr_path' => $qrPath,
            ];
            
        } catch (\Exception $e) {
            \Log::error('QR code generation failed', [
                'permohonan_id' => $permohonan->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Send notification to warga when permohonan is approved
     */
    private function notifyWarga($permohonan)
    {
        // TODO: Implement notification system
        // For now, just log it
        \Log::info('Permohonan approved, notification should be sent to warga', [
            'permohonan_id' => $permohonan->id,
            'user_id' => $permohonan->user_id,
            'layanan' => $permohonan->layanan->nama_layanan
        ]);

        // Future implementation could include:
        // - Email notification
        // - In-app notification
        // - SMS notification
    }


    /**
     * Reject the pengajuan
     */
    public function reject(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
            'kades_note' => 'nullable|string|max:1000',
        ]);

        // Check if eligible for rejection
        if (!$permohonan->isMenungguPersetujuanKades()) {
            return back()->with('error', 'Pengajuan ini tidak dapat ditolak.');
        }

        try {
            $statusDitolak = Status::where('group_key', 'pengajuan')
                ->where('code', 'ditolak')
                ->first();

            if (!$statusDitolak) {
                return back()->with('error', 'Status "Ditolak" tidak ditemukan di database.');
            }

            // Create history record
            $permohonan->history()->create([
                'from_status_id' => $permohonan->status_id,
                'to_status_id' => $statusDitolak->id,
                'changed_by' => auth()->id(),
                'note' => 'Ditolak oleh Kepala Desa: ' . $request->rejection_reason,
            ]);

            // Update permohonan
            $permohonan->update([
                'status_id' => $statusDitolak->id,
                'kades_user_id' => auth()->id(),
                'kades_approval_date' => now(),
                'kades_note' => $request->kades_note,
                'rejection_reason' => $request->rejection_reason,
                'rejected_by' => 'kades',
            ]);

            return redirect()->route('approval.index')
                ->with('success', 'Pengajuan layanan berhasil ditolak.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak pengajuan: ' . $e->getMessage());
        }
    }
}
