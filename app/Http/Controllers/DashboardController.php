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
        
        // ✅ TAMBAH: Logic berbeda untuk setiap role
        if ($user->isWarga()) {
            // Untuk warga: hanya tampilkan permohonan sendiri
            $stats = [
                'total_permohonan' => Permohonan::where('user_id', $user->id)->count(),
                'permohonan_pending' => Permohonan::where('user_id', $user->id)
                    ->whereHas('status', function($q) {
                        $q->where('code', 'baru');
                    })->count(),
                'permohonan_diproses' => Permohonan::where('user_id', $user->id)
                    ->whereHas('status', function($q) {
                        $q->where('code', 'diproses');
                    })->count(),
                'permohonan_selesai' => Permohonan::where('user_id', $user->id)
                    ->whereHas('status', function($q) {
                        $q->where('code', 'selesai');
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
            
            return view('dashboard.index', compact('stats', 'recent_permohonan', 'statusBreakdown', 'popularLayanan', 'recentUpdates'));
                
        } else {
            // Untuk admin & kepala desa: tampilkan semua data
            $stats = [
                'total_warga' => Warga::count(),
                'total_permohonan' => Permohonan::count(),
                'permohonan_baru' => Permohonan::where('status_id', 1)->count(),
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