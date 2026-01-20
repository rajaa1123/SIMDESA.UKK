<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;

class NotificationController extends Controller
{
    /**
     * Get count of pending permohonan (need verification)
     */
    public function getPendingCount()
    {
        $count = Permohonan::whereHas('status', function($q) {
            $q->where('code', 'pending')->where('group_key', 'pengajuan');
        })->count();

        return response()->json([
            'count' => $count,
            'timestamp' => now()->toIso8601String()
        ]);
    }

    /**
     * Get recent submissions (last 24 hours)
     */
    public function getRecentSubmissions()
    {
        $recent = Permohonan::with(['user', 'layanan', 'status'])
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'user_name' => $item->user->name,
                    'layanan' => $item->layanan->nama,
                    'created_at' => $item->created_at->diffForHumans(),
                    'is_new' => $item->created_at->diffInHours() < 24
                ];
            });

        return response()->json([
            'data' => $recent,
            'count' => $recent->count()
        ]);
    }

    /**
     * Get count of permohonan waiting for Kepala Desa approval
     */
    public function getApprovalCount()
    {
        $count = Permohonan::whereHas('status', function($q) {
            $q->where('code', 'menunggu_persetujuan_kades')->where('group_key', 'pengajuan');
        })->count();

        return response()->json([
            'count' => $count,
            'timestamp' => now()->toIso8601String()
        ]);
    }
}
