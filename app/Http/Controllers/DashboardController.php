<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Permohonan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isWarga()) {
            // Untuk warga: hanya tampilkan pengajuan sendiri dengan status baru
            $stats = [
                'total_permohonan' => Permohonan::where('user_id', $user->id)->count(),
                'permohonan_pending' => Permohonan::where('user_id', $user->id)
                    ->whereHas('status', function($q) {
                        $q->where('code', 'pending')->where('group_key', 'pengajuan');
                    })->count(),
                'permohonan_diproses' => Permohonan::where('user_id', $user->id)
                    ->whereHas('status', function($q) {
                        $q->where('code', 'menunggu_persetujuan_kades')->where('group_key', 'pengajuan');
                    })->count(),
                'permohonan_selesai' => Permohonan::where('user_id', $user->id)
                    ->whereHas('status', function($q) {
                        $q->where('code', 'selesai')->where('group_key', 'pengajuan');
                })->count(),
                'total_layanan' => Layanan::count(),
            ];
            
            $recent_permohonan = Permohonan::with(['user', 'layanan', 'status'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
            
            // Status breakdown untuk chart
            $statusBreakdown = [
                'pending' => $stats['permohonan_pending'],
                'diproses' => $stats['permohonan_diproses'],
                'selesai' => $stats['permohonan_selesai'],
            ];
            
            // Layanan paling populer (top 5)
            $popularLayanan = Layanan::withCount('permohonan')
                ->orderBy('permohonan_count', 'desc')
                ->take(5)
                ->get();
            
            // Recent updates (permohonan yang statusnya berubah dalam 7 hari terakhir)
            $recentUpdates = Permohonan::with(['layanan', 'status'])
                ->where('user_id', $user->id)
                ->where('updated_at', '>=', now()->subDays(7))
                ->where('updated_at', '!=', DB::raw('created_at'))
                ->latest('updated_at')
                ->take(3)
                ->get();
            
            // Permohonan dengan hasil surat tersedia
            $permohonanWithSurat = Permohonan::with(['layanan'])
                ->where('user_id', $user->id)
                ->whereNotNull('hasil_surat_file')
                ->latest('hasil_surat_uploaded_at')
                ->take(5)
                ->get();
            
            return view('dashboard.index', compact('stats', 'recent_permohonan', 'statusBreakdown', 'popularLayanan', 'recentUpdates', 'permohonanWithSurat'));
                
        } elseif ($user->isAdmin()) {
            // Untuk admin: fokus pada pengajuan yang perlu verifikasi
            $stats = [
                'total_warga' => Warga::count(),
                'total_permohonan' => Permohonan::count(),
                'perlu_verifikasi' => Permohonan::whereHas('status', function($q) {
                    $q->where('code', 'pending')->where('group_key', 'pengajuan');
                })->count(),
                'sudah_verifikasi' => Permohonan::whereNotNull('admin_user_id')->count(),
                'total_layanan' => Layanan::count(),
            ];

            $recent_permohonan = Permohonan::with(['user', 'layanan', 'status'])
                ->latest()
                ->take(5)
                ->get();
            
            $statusBreakdown = [];
            $popularLayanan = collect();
            $recentUpdates = collect();
            
            return view('dashboard.index', compact('stats', 'recent_permohonan', 'statusBreakdown', 'popularLayanan', 'recentUpdates'));
            
        } else {
            // Untuk kepala desa: fokus pada approval
            $stats = [
                'total_warga' => Warga::count(),
                'total_permohonan' => Permohonan::count(),
                'menunggu_approval' => Permohonan::whereHas('status', function($q) {
                    $q->where('code', 'menunggu_persetujuan_kades')->where('group_key', 'pengajuan');
                })->count(),
                'sudah_approved' => Permohonan::whereNotNull('kades_user_id')
                    ->whereMonth('kades_approval_date', now()->month)
                    ->count(),
                'total_layanan' => Layanan::count(),
            ];

            $recent_permohonan = Permohonan::with(['user', 'layanan', 'status'])
                ->latest()
                ->take(5)
                ->get();
            
            $statusBreakdown = [];
            $popularLayanan = collect();
            $recentUpdates = collect();
            
            return view('dashboard.index', compact('stats', 'recent_permohonan', 'statusBreakdown', 'popularLayanan', 'recentUpdates'));
        }
    }
}