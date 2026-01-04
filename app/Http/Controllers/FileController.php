<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{
    /**
     * Download attachment file from database
     */
    public function download(Attachment $attachment)
    {
        // Authorization check
        if (Gate::denies('download', $attachment)) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh file ini.');
        }

        // Check if file content exists
        if (!$attachment->file_content) {
            abort(404, 'File tidak ditemukan.');
        }

        // Decode base64 content
        $fileContent = base64_decode($attachment->file_content);

        // Return file download response
        return response($fileContent, 200)
            ->header('Content-Type', $attachment->mime)
            ->header('Content-Disposition', 'attachment; filename="' . $attachment->nama_file . '"');
    }

    /**
     * Stream attachment file for preview (PDF, images) from database
     */
    public function stream(Attachment $attachment)
    {
        // Authorization check
        if (Gate::denies('view', $attachment)) {
            abort(403, 'Anda tidak memiliki akses untuk melihat file ini.');
        }

        // Check if file content exists
        if (!$attachment->file_content) {
            abort(404, 'File tidak ditemukan.');
        }

        // Only allow streaming for PDF and images
        if (!$attachment->isPdf() && !$attachment->isImage()) {
            // For other file types, force download
            return $this->download($attachment);
        }

        // Decode base64 content
        $fileContent = base64_decode($attachment->file_content);
        
        return response($fileContent, 200)
            ->header('Content-Type', $attachment->mime)
            ->header('Content-Disposition', 'inline; filename="' . $attachment->nama_file . '"');
    }
}
