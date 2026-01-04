<?php

namespace App\Policies;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view the attachment
     */
    public function view(User $user, Attachment $attachment)
    {
        // Get the permohonan from attachable (polymorphic)
        $permohonan = $attachment->attachable;
        
        if (!$permohonan) {
            return false;
        }

        // Warga can only view their own permohonan files
        if ($user->isWarga()) {
            return $permohonan->user_id === $user->id;
        }

        // Admin and Kepala Desa can view all files
        if ($user->isAdmin() || $user->isKepalaDesa()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can download the attachment
     */
    public function download(User $user, Attachment $attachment)
    {
        // Same authorization as view
        return $this->view($user, $attachment);
    }

    /**
     * Determine if the user can upload attachments to a permohonan
     */
    public function upload(User $user, $permohonan)
    {
        // Only warga who owns the permohonan can upload
        if (!$user->isWarga()) {
            return false;
        }

        if ($permohonan->user_id !== $user->id) {
            return false;
        }

        // Can only upload if status allows it
        return $permohonan->canUploadFiles();
    }

    /**
     * Determine if the user can replace an attachment
     */
    public function replace(User $user, Attachment $attachment)
    {
        $permohonan = $attachment->attachable;
        
        if (!$permohonan) {
            return false;
        }

        // Only warga who owns the permohonan can replace
        if (!$user->isWarga()) {
            return false;
        }

        if ($permohonan->user_id !== $user->id) {
            return false;
        }

        // Can only replace if files are not locked
        return !$permohonan->isFilesLocked() && $permohonan->canUploadFiles();
    }

    /**
     * Determine if the user can delete an attachment
     */
    public function delete(User $user, Attachment $attachment)
    {
        $permohonan = $attachment->attachable;
        
        if (!$permohonan) {
            return false;
        }

        // Only warga who owns the permohonan can delete
        if (!$user->isWarga()) {
            return false;
        }

        if ($permohonan->user_id !== $user->id) {
            return false;
        }

        // Can only delete if status is still pending (before any approval)
        return $permohonan->isPending();
    }
}
