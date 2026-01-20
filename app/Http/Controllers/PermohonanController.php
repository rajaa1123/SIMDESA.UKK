<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Layanan;
use App\Models\Status;
use App\Models\User;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermohonanController extends Controller
{
    /**
     * STRICT AUTHORIZATION GUARD
     * Enforce role-based access to permohonan based on status
     */
    private function authorizePermohonanAccess(Permohonan $permohonan, $action = 'view')
    {
        $user = auth()->user();
        
        // === WARGA ACCESS ===
        // Warga can only access their own permohonan
        if ($user->isWarga()) {
            if ($permohonan->user_id !== $user->id) {
                abort(403, 'Akses ditolak: Anda hanya dapat mengakses permohonan Anda sendiri.');
            }
            return; // Allowed for own permohonan
        }
        
        // === KEPALA DESA ACCESS ===
        // Kepala Desa can ONLY access permohonan with status 'menunggu_persetujuan_kades'
        // They should use /approval route, not /permohonan route
        if ($user->isKepalaDesa()) {
            if (!$permohonan->canBeAccessedByKades()) {
                abort(403, 'Akses ditolak: Kepala Desa hanya dapat mengakses permohonan dengan status "Menunggu Persetujuan Kepala Desa". Silakan gunakan menu Approval.');
            }
            
            // Kepala Desa cannot edit via /permohonan route
            if ($action === 'edit') {
                abort(403, 'Akses ditolak: Kepala Desa tidak dapat mengedit permohonan di halaman ini. Gunakan menu Approval untuk menyetujui/menolak.');
            }
            
            return; // Allowed to view only
        }
        
        // === ADMIN ACCESS ===
        // Admin can access all permohonan (full access)
        if ($user->isAdmin()) {
            return; // Full access
        }
        
        // Default: deny access
        abort(403, 'Akses ditolak.');
    }


    public function index()
    {
        $user = auth()->user();
        
        // Get pengajuan status group
        $statuses = Status::where('group_key', 'pengajuan')->get();
        $layanans = Layanan::all();

        // Filter based on role
        $query = Permohonan::with(['user', 'layanan', 'status', 'adminUser', 'kadesUser']);

        if ($user->isWarga()) {
            // Warga only sees their own pengajuan
            $query->where('user_id', $user->id);
        } elseif ($user->isAdmin()) {
            // Admin sees pengajuan that need verification (pending status)
            $pendingStatus = Status::where('group_key', 'pengajuan')
                ->where('code', 'pending')
                ->first();
            // Show all or filter to pending for admin view
            // For now, admin sees all to manage them
        } elseif ($user->isKepalaDesa()) {
            // Kepala Desa sees those waiting for approval
            $menungguStatus = Status::where('group_key', 'pengajuan')
                ->where('code', 'menunggu_persetujuan_kades')
                ->first();
            // Kepala Desa has dedicated approval page, here shows all
        }

        $permohonans = $query->latest()->paginate(10);

        return view('permohonan.index', compact('permohonans', 'statuses', 'layanans'));
    }

    public function create()
    {
        $layanans = Layanan::with('persyaratan.dokumen')->get();
        $statuses = Status::where('group_key', 'pengajuan')->get();
        return view('permohonan.create', compact('layanans', 'statuses'));
    }

    public function store(Request $request)
    {
        // Get selected layanan to validate persyaratan
        $layanan = Layanan::with('persyaratan.dokumen')->findOrFail($request->layanan_id);
        
        // Build validation rules
        $rules = [
            'layanan_id' => 'required|exists:layanan,id',
            'keterangan' => 'nullable',
        ];

        // Add file validation for each persyaratan
        foreach ($layanan->persyaratan as $syarat) {
            $fieldName = 'attachments.' . $syarat->dokumen_id;
            
            if ($syarat->wajib) {
                // Required file validation
                $rules[$fieldName] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'; // 5MB
            } else {
                // Optional file validation
                $rules[$fieldName] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
            }
        }

        // Build validation rules for dynamic form_data
        $formSchemas = config('layanan_forms');
        $templateSlug = $layanan->template_slug;
        
        if (isset($formSchemas[$templateSlug])) {
            foreach ($formSchemas[$templateSlug] as $fieldName => $fieldConfig) {
                if ($fieldConfig['required']) {
                    $rules["form_data.{$fieldName}"] = 'required';
                } else {
                    $rules["form_data.{$fieldName}"] = 'nullable';
                }
            }
        }

        $validated = $request->validate($rules, [
            'attachments.*.required' => 'Dokumen persyaratan wajib harus diunggah.',
            'attachments.*.file' => 'File harus berupa dokumen yang valid.',
            'attachments.*.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
            'attachments.*.max' => 'Ukuran file maksimal 5MB.',
            'form_data.*.required' => 'Field ini wajib diisi.',
        ]);

        $validated['user_id'] = auth()->id();
        
        // Set status to 'pending' from pengajuan group
        $pendingStatus = Status::where('group_key', 'pengajuan')
            ->where('code', 'pending')
            ->first();
        
        $validated['status_id'] = $pendingStatus ? $pendingStatus->id : 1;

        // Generate nomor resi otomatis
        $validated['nomor_resi'] = 'RESI-' . date('Ymd') . '-' . rand(1000, 9999);

        // Create permohonan with form_data
        $permohonan = Permohonan::create([
            'layanan_id' => $validated['layanan_id'],
            'user_id' => $validated['user_id'],
            'status_id' => $validated['status_id'],
            'nomor_resi' => $validated['nomor_resi'],
            'keterangan' => $validated['keterangan'],
            'form_data' => $validated['form_data'] ?? null, // Dynamic form data
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $dokumenId => $file) {
                if ($file && $file->isValid()) {
                    // Read file content and encode to base64
                    $fileContent = base64_encode(file_get_contents($file->getRealPath()));
                    
                    // Create attachment record with file content in database
                    $permohonan->attachments()->create([
                        'dokumen_id' => $dokumenId,
                        'uploaded_by' => auth()->id(),
                        'file_path' => null, // No physical file
                        'file_content' => $fileContent, // Store in database
                        'nama_file' => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }
        }

        return redirect()->route('permohonan.index')
            ->with('success', 'Pengajuan layanan berhasil diajukan dengan dokumen persyaratan.');
    }

    public function show(Permohonan $permohonan)
    {
        // **AUTHORIZATION GUARD**
        $this->authorizePermohonanAccess($permohonan, 'view');

        // Load all relationships including admin and kades
        $permohonan->load(['user', 'layanan', 'status', 'processor', 'adminUser', 'kadesUser', 'history.changedBy', 'history.fromStatus', 'history.toStatus', 'attachments']);

        // Get statuses for dropdown
        $statuses = Status::where('group_key', 'pengajuan')->get();

        return view('permohonan.show', compact('permohonan', 'statuses'));
    }

    public function edit(Permohonan $permohonan)
    {
        // **AUTHORIZATION GUARD**
        $this->authorizePermohonanAccess($permohonan, 'edit');

        $layanans = Layanan::all();
        $statuses = Status::where('group_key', 'pengajuan')->get();
        $processors = User::whereIn('role_id', [2, 3])->get();

        return view('permohonan.edit', compact('permohonan', 'layanans', 'statuses', 'processors'));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'status_id' => 'required|exists:status,id',
            'keterangan' => 'nullable',
            'processor_user_id' => 'nullable|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            if ($permohonan->status_id != $validated['status_id']) {
                $permohonan->history()->create([
                    'from_status_id' => $permohonan->status_id,
                    'to_status_id' => $validated['status_id'],
                    'changed_by' => auth()->id(),
                    'note' => 'Status diupdate melalui form edit',
                ]);
            }

            $permohonan->update($validated);

            // Ensure no financial ledger exists since it's now 100% free
            \App\Models\Keuangan::where('permohonan_id', $permohonan->id)->delete();

            DB::commit();

            return redirect()->route('permohonan.show', $permohonan->id)
                ->with('success', 'Permohonan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui permohonan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Permohonan $permohonan)
    {
        $permohonan->delete();
        return redirect()->route('permohonan.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'status_id' => 'required|exists:status,id',
            'note' => 'nullable',
        ]);

        // Create history record
        $permohonan->history()->create([
            'from_status_id' => $permohonan->status_id,
            'to_status_id' => $request->status_id,
            'changed_by' => auth()->id(),
            'note' => $request->note,
        ]);

        // Update status
        $permohonan->update(['status_id' => $request->status_id]);

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
    
    /**
     * API: Get form schema for dynamic form rendering
     */
    public function getFormSchema(Layanan $layanan)
    {
        $formSchemas = config('layanan_forms');
        $templateSlug = $layanan->template_slug;
        
        if (!isset($formSchemas[$templateSlug])) {
            return response()->json([
                'error' => 'Form schema not defined for this layanan',
                'template_slug' => $templateSlug
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'layanan' => $layanan->nama_layanan,
            'template_slug' => $templateSlug,
            'form_schema' => $formSchemas[$templateSlug]
        ]);
    }

    /**
     * Method untuk Admin verifikasi pengajuan (terima atau tolak)
     * STRICT GUARD: Only pending status can be verified by admin
     */
    public function verifikasiAdmin(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'action' => 'required|in:terima,tolak',
            'admin_note' => 'nullable|string|max:1000',
            'rejection_reason' => 'required_if:action,tolak|string|max:1000',
        ]);

        // STRICT GUARD: Admin can only verify if status is 'pending'
        if (!$permohonan->isPending()) {
            abort(403, 'Akses ditolak: Hanya permohonan dengan status "Menunggu Verifikasi Admin" yang dapat diverifikasi.');
        }

        // STRICT GUARD: Check if status transition is allowed
        $targetStatus = $request->action === 'terima' 
            ? 'menunggu_persetujuan_kades' 
            : 'ditolak';

        if (!$permohonan->canTransitionTo($targetStatus)) {
            return back()->with('error', 'Transisi status tidak diizinkan.');
        }

        // **AUTO-GENERATE PDF**: Generate surat PDF automatically if not exists
        if ($request->action === 'terima') {
            // Auto-generate PDF if not already generated
            if (!$permohonan->hasHasilSurat()) {
                $suratController = app(\App\Http\Controllers\SuratController::class);
                $generated = $suratController->autoGeneratePDF($permohonan);
                
                if (!$generated) {
                    return back()->with('error', 'Gagal: Template surat tidak ditemukan atau generate PDF gagal. Silakan hubungi administrator.');
                }
            }
        }

        try {
            if ($request->action === 'terima') {
                // Admin menerima, ubah status ke menunggu persetujuan kepala desa
                $statusMenunggu = Status::where('group_key', 'pengajuan')
                    ->where('code', 'menunggu_persetujuan_kades')
                    ->firstOrFail();

                // Create history
                $permohonan->history()->create([
                    'from_status_id' => $permohonan->status_id,
                    'to_status_id' => $statusMenunggu->id,
                    'changed_by' => auth()->id(),
                    'note' => 'Diterima oleh Admin' . ($request->admin_note ? ': ' . $request->admin_note : ''),
                ]);

                // Update permohonan
                $permohonan->update([
                    'status_id' => $statusMenunggu->id,
                    'admin_user_id' => auth()->id(),
                    'admin_approval_date' => now(),
                    'admin_note' => $request->admin_note,
                ]);

                return back()->with('success', 'Pengajuan berhasil diterima dan diteruskan ke Kepala Desa.');

            } else {
                // Admin menolak
                $statusDitolak = Status::where('group_key', 'pengajuan')
                    ->where('code', 'ditolak')
                    ->firstOrFail();

                // Create history
                $permohonan->history()->create([
                    'from_status_id' => $permohonan->status_id,
                    'to_status_id' => $statusDitolak->id,
                    'changed_by' => auth()->id(),
                    'note' => 'Ditolak oleh Admin: ' . $request->rejection_reason,
                ]);

                // Update permohonan
                $permohonan->update([
                    'status_id' => $statusDitolak->id,
                    'admin_user_id' => auth()->id(),
                    'admin_approval_date' => now(),
                    'admin_note' => $request->admin_note,
                    'rejection_reason' => $request->rejection_reason,
                    'rejected_by' => 'admin',
                ]);

                return back()->with('success', 'Pengajuan berhasil ditolak.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memverifikasi pengajuan: ' . $e->getMessage());
        }
    }


    /**
     * Upload attachment to existing permohonan
     */
    public function uploadAttachment(Request $request, Permohonan $permohonan)
    {
        // Authorization check
        if (auth()->user()->cannot('upload', [$permohonan, Attachment::class])) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengunggah file.');
        }

        // Check if files can still be uploaded
        if (!$permohonan->canUploadFiles()) {
            return back()->with('error', 'Pengajuan ini sudah tidak dapat diubah.');
        }

        $request->validate([
            'dokumen_id' => 'required|exists:dokumen,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'file.required' => 'File harus dipilih.',
            'file.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $file = $request->file('file');
        $dokumenId = $request->dokumen_id;

        // Check if attachment already exists for this dokumen
        $existingAttachment = $permohonan->attachments()
            ->where('dokumen_id', $dokumenId)
            ->first();

        if ($existingAttachment) {
            return back()->with('error', 'Dokumen ini sudah diunggah. Gunakan fitur replace untuk menggantinya.');
        }

        try {
            // Read file content and encode to base64
            $fileContent = base64_encode(file_get_contents($file->getRealPath()));

            // Create attachment record
            $permohonan->attachments()->create([
                'dokumen_id' => $dokumenId,
                'uploaded_by' => auth()->id(),
                'file_path' => null,
                'file_content' => $fileContent,
                'nama_file' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            return back()->with('success', 'Dokumen berhasil diunggah.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunggah dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Replace existing attachment
     */
    public function replaceAttachment(Request $request, Attachment $attachment)
    {
        // Authorization check
        if (auth()->user()->cannot('replace', $attachment)) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengganti file ini.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'file.required' => 'File harus dipilih.',
            'file.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $file = $request->file('file');
        $permohonan = $attachment->attachable;

        try {
            // Read file content and encode to base64
            $fileContent = base64_encode(file_get_contents($file->getRealPath()));

            // Update attachment record
            $attachment->update([
                'file_content' => $fileContent,
                'nama_file' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            return back()->with('success', 'Dokumen berhasil diganti.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengganti dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Delete attachment
     */
    public function deleteAttachment(Attachment $attachment)
    {
        // Authorization check
        if (auth()->user()->cannot('delete', $attachment)) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus file ini.');
        }

        try {
            // Only delete attachment record (no physical file to delete)
            $attachment->delete();

            return back()->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Upload hasil surat (PDF) by admin/kepala desa
     */
    public function uploadHasilSurat(Request $request, Permohonan $permohonan)
    {
        // Authorization: Only admin or kepala desa
        if (!auth()->user()->isAdmin() && !auth()->user()->isKepalaDesa()) {
            abort(403, 'Anda tidak memiliki akses untuk upload surat hasil.');
        }

        // Validate file
        $request->validate([
            'hasil_surat' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ], [
            'hasil_surat.required' => 'File surat hasil wajib diupload.',
            'hasil_surat.mimes' => 'File harus berformat PDF.',
            'hasil_surat.max' => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $file = $request->file('hasil_surat');
            
            // Save to STORAGE (Disk)
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('surat/' . date('Y/m'), $filename, 'public');
            
            // Update permohonan (Store PATH)
            $permohonan->update([
                'hasil_surat_file' => $path,
                'hasil_surat_filename' => $filename,
                'hasil_surat_uploaded_at' => now(),
                'hasil_surat_uploaded_by' => auth()->id(),
            ]);

            return redirect()->back()->with('success', 'Surat hasil layanan berhasil diupload. Warga dapat mendownload surat tersebut.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload surat: ' . $e->getMessage());
        }
    }

    /**
     * Download hasil surat by warga (owner), admin, or kepala desa
     */
    /**
     * Download hasil surat by warga (owner), admin, or kepala desa
     */
    public function downloadHasilSurat(Permohonan $permohonan)
    {
        // Authorization: Only owner (warga), admin, or kepala desa
        $user = auth()->user();
        $isOwner = $permohonan->user_id === $user->id;
        $isAdminOrKades = $user->isAdmin() || $user->isKepalaDesa();

        if (!$isOwner && !$isAdminOrKades) {
            abort(403, 'Anda tidak memiliki akses untuk mendownload surat ini.');
        }
        
        // RESTRICTION: Warga cannot download if not yet approved by Kades (Status 'selesai')
        if ($user->isWarga() && !$permohonan->isSelesai()) {
            abort(403, 'Maaf, surat ini belum ditandatangani oleh Kepala Desa. Anda baru dapat mendownloadnya setelah status "Selesai".');
        }

        // Check if hasil surat exists
        if (!$permohonan->hasHasilSurat()) {
            abort(404, 'Surat hasil belum tersedia.');
        }

        try {
            $filename = $permohonan->hasil_surat_filename ?? 'Surat_Hasil_' . $permohonan->nomor_resi . '.pdf';
            
            // CHECK: Is it a file path (starts with surat/) or Base64 (legacy)?
            if (str_starts_with($permohonan->hasil_surat_file, 'surat/')) {
                // STORAGE MODE
                $path = $permohonan->hasil_surat_file;
                
                if (!\Storage::disk('public')->exists($path)) {
                    abort(404, 'File surat fisik tidak ditemukan di server.');
                }
                
                return \Storage::disk('public')->download($path, $filename);
            } else {
                // LEGACY BASE64 MODE
                $fileContent = base64_decode($permohonan->hasil_surat_file);
                
                return response($fileContent, 200)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
            }
        } catch (\Exception $e) {
            abort(500, 'Gagal mendownload surat: ' . $e->getMessage());
        }
    }
}